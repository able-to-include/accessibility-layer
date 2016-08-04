<?php
/**
 * Apache License, Version 2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * The work represented by this file is partially funded by the ABLE-TO-INCLUDE
 * project through the European Commission's ICT Policy Support Programme as
 * part of the Competitiveness & Innovation Programme (Grant no.: 621055)

 * Copyright © 2016, ABLE-TO-INCLUDE Consortium.
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions & limitations
 * under the License.
 */

/**
 * Returns the URL address to the image describing the indicated word in the indicated language.
 * @return The URL address to the pictogram.
 */
function getArasaacPictogram($word, $langCode) {
  $url="http://arasaac.org/api/index.php?callback=json&language=".$langCode."&word=".$word."&catalog=colorpictos&nresults=1&thumbnailsize=150&TXTlocate=4&KEY=6ArbCprYe2FTNUReAC6X";
  //  Initiate curl
  $ch = curl_init();
  // Disable SSL verification
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  // Will return the response, if false it print the response
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Set the url
  curl_setopt($ch, CURLOPT_URL,$url);
  // Execute
  $result=curl_exec($ch);
  // Closing
  curl_close($ch);
  // Will dump a beauty json :3
  $array_result = json_decode($result, true);
  return $array_result["symbols"][0]["imagePNGURL"];
}

/**
 *
 */
function arasaacNotParallel($text, $language) {
  $words = getWordsFromText($text);
  $notParallel = array();
  $i = 0;
  foreach($words as &$word) {
    $notParallel[$i] = getArasaacPictogram($word, getLangCodeFromLanguage($language));
    $i++;
  }
  return $notParallel;
}

/**
 *
 */
function arasaacParallel($text, $language) {
  $words = getWordsFromText($text);
  $parallel = array();
  $i = 0;
  foreach($words as &$word) {
    $parallel[$i][0] = getArasaacPictogram($word, getLangCodeFromLanguage($language));
    $parallel[$i][1] = $word;
    $i++;
  }
  return $parallel;
}

/**
 * Splits the text in words, deleting comas, dots, etc.
 * @return An array of words.
 */
function getWordsFromText($text) {
  $pattern = '/[¿!¡;,:\.\?#@()"]/';
  $replace = '';
  $input = preg_replace($pattern,$replace, trim($text));
  $words = explode(" ", $input);
  return $words;
}

/**
 * Returns a code for the given language.
 * @return The language code.
 */
function getLangCodeFromLanguage($language) {
  if (strcmp($language, "spanish") == 0)
    return "ES";
  else if (strcmp($language, "english") == 0)
    return "EN";
  else
    return "ES";
}
?>
