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
 * The ABLE Accessibility Layer response object.
 */
class Able {
  /**
   * The input text.
   */
  var $textInput = "";
  /**
   * The simlified text (using Simplext).
   */
  var $textSimplified = "";
  /**
   * The list of pictograms (using Text2Picto).
   */
  var $pictos = array();
  /**
   * The text obtained from the pictogram list (using Picto2Text).
   */
  var $textFromPictos = "";
  /**
   * The url to the audio speech (using Text2Speech).
   */
  var $audioSpeech = "";
  /**
   * The response status to indicate if everything was right or not.
   * In case of error, the code indicates the cause.
   */
  var $status = 0;

  /**
   * Gets the input text.
   */
  function getTextInput() {
    return $this->textInput;
  }

  /**
   * Sets the input text.
   */
  function setTextInput($var) {
    $this->textInput = $var;
  }

  /**
   * Gets the simlified text.
   */
  function getTextSimplified() {
    return $this->textSimplified;
  }

  /**
   * Sets the simlified text.
   */
  function setTextSimplified($var) {
    $this->textSimplified = $var;
  }

  /**
   * Gets the list of pictograms.
   */
  function getPictos() {
    return $this->pictos;
  }

  /**
   * Sets the list of pictograms.
   */
  function setPictos($var) {
    $this->pictos = $var;
  }

  /**
   * Gets the text translated from the pictogram list.
   */
  function getTextFromPictos() {
    return $this->textFromPictos;
  }

  /**
   * Sets the text translated from the pictogram list.
   */
  function setTextFromPictos($var) {
    $this->textFromPictos = $var;
  }

  /**
   * Gets the url to the audio speech.
   */
  function getAudioSpeech() {
    return $this->audioSpeech;
  }

  /**
   * Sets the url to the audio speech.
   */
  function setAudioSpeech($var) {
    $this->audioSpeech = $var;
  }

  /**
   * Gets the response status.
   */
  function getStatus() {
    return $this->status;
  }

  /**
   * Sets the response status.
   */
  function setStatus($var) {
    $this->status = $var;
  }
}
?>
