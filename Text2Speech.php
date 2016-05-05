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
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once("Able.php");
require_once("errors.php");
require_once("settings.php");

/**
 * Gets the speech from the Text2Speech service.
 */
function getSpeech($text, $lg, $able) {
  $handler = curl_init();
  curl_setopt($handler, CURLOPT_URL, TEXT2SPEECH);
  curl_setopt($handler, CURLOPT_POST,true);
  curl_setopt($handler, CURLOPT_POSTFIELDS, "TextToTranslate=".$text."&Language=".$lg);
  curl_setopt($handler, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
  curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec ($handler);
  curl_close($handler);
  if ($response == NULL || strlen($response) < 1) {
    $able->setStatus(SERVICE_NOT_WORKING);
  } else {}
    $array_response = json_decode($response, true);
    $able->setAudioSpeech($array_response['LinkToFile']);
    $able->setStatus(OK);
  }
}

// Instantiate the object Able
$able = new Able();
// Sets the audioSpeech value to "Error"
$able->setAudioSpeech("Error");
if (isset($_GET['text']) && strlen(trim($_GET['text'])) > 0) {
  $text = trim($_GET['text']);
  $able->setTextInput($text);
  if (isset($_GET['language']) && strlen(trim($_GET['language'])) > 0) {
    //Parameters are ok
    $language = trim($_GET['language']);
    if ( strcmp($language, "spanish") != 0 && strcmp($language, "english") != 0
    && strcmp($language, "dutch") != 0 && strcmp($language, "french") != 0) {
			$able->setStatus(LANGUAGE_NOT_SUPPORTED);
		} else {
     //Language is supported
     $lg = "";
      if ( strcmp($language, "spanish") == 0) {
        //Spanish
        $lg = "es-eu";
        getSpeech($text, $lg, $able);
      } else if (strcmp($language, "english") == 0) {
        //English
        $lg = "en-us";
        getSpeech($text, $lg, $able);
      } else if (strcmp($language, "dutch") == 0) {
        //Dutch
        $lg = "nl-eu";
        getSpeech($text, $lg, $able);
      } else if (strcmp($language, "french") == 0) {
        //French
        $lg = "fr-be";
        getSpeech($text, $lg, $able);
      }
    }
  } else {
    $able->setStatus(EMPTY_LANGUAJE);
  }
} else if (isset($_GET['language'])) {
  $able->setStatus(EMPTY_INPUT_TEXT);
} else {
  $able->setStatus(EMPTY_INPUT_TEXT_AND_LANGUAJE);
}
// Echoes the object Able formatted as JSON
echo json_encode($able);
?>
