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

/**
 * The url where the Text2Picto service is hosted.
 */
define("TEXT2PICTO", "http://picto.ccl.kuleuven.be/picto_json2.php");
/**
 * The url where the Parallel Text2Picto service is hosted.
 */
define("PARALLEL", "http://picto.ccl.kuleuven.be/picto_parallel_JSON.php");

// Instantiate the object Able
$able = new Able();
// Sets the pictos value to "Error"
$able->setPictos("Error");
if (isset($_GET['text']) && strlen(trim($_GET['text'])) > 0) {
  $text = trim($_GET['text']);
  $able->setTextInput($text);
  if (isset($_GET['language']) && strlen(trim($_GET['language'])) > 0) {
    $language = trim($_GET['language']);
    if (isset($_GET['type']) && strlen(trim($_GET['type'])) > 0) {
      //Parameters are ok
      $type = trim($_GET['type']);
      if ( strcmp($language, "spanish") != 0 && strcmp($language, "english") != 0
      && strcmp($language, "dutch") != 0) {
        $able->setStatus(LANGUAGE_NOT_SUPPORTED);
      } else {
        //Language is supported
        if (strcmp($type, "beta") != 0 && strcmp($type, "sclera") != 0) {
          $able->setStatus(TYPE_NOT_SUPPORTED);
        } else {
          // Checks if the language is "dutch" because this service is using
          // a kind of "dutch" language called "cornetto"
          if (strcmp($language, "dutch") == 0) {
            $language = "cornetto";
          }
          // Assign the service address (Text2Picto or Parallel Text2Picto)
          $text2pictoUri = TEXT2PICTO;
          if (isset($_GET['parallel'])) {
            $parallel = $_GET['parallel'];
            switch($parallel) {
              case "true":
                $text2pictoUri = PARALLEL;
                break;
              case "false":
                break;
              default:
                $able->setStatus(PARALLEL_MUST_BE_TRUE_OR_FALSE);
            }
          }
          // Prepares an HTTP request using CURL to the selected Text2Picto service
          $handler = curl_init();
          curl_setopt($handler, CURLOPT_URL, $text2pictoUri);
          curl_setopt($handler, CURLOPT_POST,true);
          curl_setopt($handler, CURLOPT_POSTFIELDS, "input=".$text."&language=".$language."&picto=".$type);
          curl_setopt($handler, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
          curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
          // Send the request to the Text2Picto service
          $response = curl_exec ($handler);
          curl_close($handler);
          if ($response != NULL || strlen($response) < 1) {
            $array_response = json_decode($response, true);
            $able->setPictos($array_response['output']);
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
