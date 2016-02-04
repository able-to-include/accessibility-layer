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
 * The url where the Spanish Simplext service is hosted.
 */
define("SIMPLEXT_SPANISH", "http://simplext.net/simple-api/api/plain/");
/**
 * The url where the English Simplext service is hosted.
 */
define("SIMPLEXT_ENGLISH", "http://5.56.57.123:1919");

// Instantiate the object Able
$able = new Able();
// Sets the simplified text value to "Error"
$able->setTextSimplified("Error");
// Check if the parameter text is correctly received
if (isset($_GET['text']) && strlen(trim($_GET['text'])) > 0) {
  // Store the value of the text and sets the inputText
  $text = trim($_GET['text']);
  $able->setTextInput($text);
  // Checks if the parameter language is correctly received
  if (isset($_GET['language']) && strlen(trim($_GET['language'])) > 0) {
    // Store the value of the language
    $language = trim($_GET['language']);
    // Checks if the language is supported
    if ( strcmp($language, "spanish") != 0 && strcmp($language, "english") != 0) {
      // The language is not supported
      $able->setStatus(LANGUAGE_NOT_SUPPORTED);
		} else {
      // The language is supported
      // Check
      if ( strcmp($language, "spanish") == 0) {
        // Spanish language
        // Prepares an HTTP request using CURL to the Spanish Simplext service
        $handler = curl_init();
        curl_setopt($handler, CURLOPT_URL, SIMPLEXT_SPANISH);
        curl_setopt($handler, CURLOPT_POST,true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, "text=".$text);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        // Send the request to the Spanish Simplext service
        $response = curl_exec ($handler);
        curl_close($handler);
        if ($response == NULL || strlen($response) < 1) {
          $able->setStatus(SERVICE_NOT_WORKING);
        } else {
          $able->setTextSimplified($response);
          // Sets the status value to OK
          $able->setStatus(OK);
        }
      } else if (strcmp($language, "english") == 0) {
        //English language
        // Prepares an HTTP request using CURL to the English Simplext service
        $jsonText = array("text" => $text,
          "type" => "Lexico-Syntactic",
          "language" => "English",
          "action" => "simplify");
        $data = array("id" => "req-id-01",
          "method" => "simplify",
          "params" => $jsonText,
          "jsonrpc" => "2.0");
        $ch = curl_init( SIMPLEXT_ENGLISH );
        $payload = json_encode($data);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        // Send the request to the English Simplext service
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result == NULL || strlen($result) < 1) {
          $able->setStatus(SERVICE_NOT_WORKING);
        } else {
          $array_response = json_decode($result, true);
          $able->setTextSimplified($array_response['result']);
          // Sets the status value to OK
          $able->setStatus(OK);
        }
      }
    }
  } else {
    // Indicates that he client has not indicated the language
    $able->setStatus(EMPTY_LANGUAJE);
  }
} else if (isset($_GET['language'])) {
  // Indicates that he client has not indicated the input text
  $able->setStatus(EMPTY_INPUT_TEXT);
} else {
  // Indicates that the client has not indicated neither the input text nor the
  // language
  $able->setStatus(EMPTY_INPUT_TEXT_AND_LANGUAJE);
}
// Echoes the object Able formatted as JSON
echo json_encode($able);
?>
