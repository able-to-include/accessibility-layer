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
 * Everything was ok.
 */
define("OK", 200);
/**
 * The selected service (Simplext, Text2Speech or Text2Picto) is not working
 * properly (There is no response or the response is erroneus).
 */
define("SERVICE_NOT_WORKING", 408);
/**
 * The client has not indicated any input text.
 */
define("EMPTY_INPUT_TEXT", 451);
/**
 * The client has not indicated the input text language.
 */
define("EMPTY_LANGUAJE", 452);
/**
 * The client has not indicated the pictograms type (base) to use.
 */
define("EMPTY_TYPE", 453);
/**
 * The client has not indicated neither the input text nor the language.
 */
define("EMPTY_INPUT_TEXT_AND_LANGUAJE", 454);
/**
 * The client has not indicated neither the input text nor the language and the
 * type.
 */
define("EMPTY_INPUT_TEXT_LANGUAJE_AND_TYPE", 455);
/**
 * The client hs not indicated neither the language nor the pictogram base.
 */
define("EMPTY_LANGUAJE_AND_PICTO", 456);
/**
 * The client hs not indicated neither the input text nor the pictogram base.
 */
define("EMPTY_INPUT_TEXT_AND_PICTO", 457);
/**
 * The language is not supported for the selected service.
 */
define("LANGUAGE_NOT_SUPPORTED", 458);
/**
 * The type is not supported. Must be "beta" or "sclera".
 */
define("TYPE_NOT_SUPPORTED", 459);
/**
 * The parallel parameter must be "true" or "false".
 */
define("PARALLEL_MUST_BE_TRUE_OR_FALSE",460);
?>
