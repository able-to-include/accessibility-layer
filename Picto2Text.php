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
// Instantiate the object Able
$able = new Able();

function getPictosFromText($var) {
  return explode(' ', $var);
}

if (isset($_GET['pictos']) && strlen(trim($_GET['pictos'])) > 0) {
  $pictos = trim($_GET['pictos']);
  //$able->setTextInput($text);
  $pictoArray = getPictosFromText($pictos);
  $able->setPictos($pictoArray);


  if (isset($_GET['language']) && strlen(trim($_GET['language'])) > 0) {
    $language = trim($_GET['language']);
    if (isset($_GET['type']) && strlen(trim($_GET['type'])) > 0) {
      //Parameters are ok
      $type = trim($_GET['type']);
      if ( strcmp($language, "spanish") != 0 && strcmp($language, "english") != 0
      && strcmp($language, "dutch") != 0) {
        $able->setStatus(LANGUAGE_NOT_SUPPORTED);
      } else {
        // Language is supported
        if (strcmp($type, "beta") != 0 && strcmp($type, "sclera") != 0) {
          $able->setStatus(TYPE_NOT_SUPPORTED);
        } else {
          // Type is supported
          // Prepares an HTTP request using CURL to the selected Text2Picto service
          $handler = curl_init();
          curl_setopt($handler, CURLOPT_URL, PICTO2TEXT);
          curl_setopt($handler, CURLOPT_POST,true);
          curl_setopt($handler, CURLOPT_POSTFIELDS, "input=".$pictos."&language=".$language."&picto=".$type);
          curl_setopt($handler, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
          curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
          // Send the request to the Text2Picto service
          $response = curl_exec ($handler);
          curl_close($handler);
          if ($response != NULL || strlen($response) < 1) {
            $array_response = json_decode($response, true);
            $able->setTextFromPictos($array_response['output']);
            $able->setStatus(OK);
          } else {
            $able->setStatus(SERVICE_NOT_WORKING);
          }
        }
      }
    } else {
      $able->setStatus(EMPTY_TYPE);
    }
  } else {
    // Indicates that he client has not indicated the language
    $able->setStatus(EMPTY_LANGUAJE);
  }
} else if (isset($_GET['language'])) {
  $able->setStatus(EMPTY_INPUT_TEXT);
} else {
  $able->setStatus(EMPTY_INPUT_TEXT_LANGUAJE_AND_TYPE);
}
// Echoes the object Able formatted as JSON
echo json_encode($able);
?>
