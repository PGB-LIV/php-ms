<?php
/**
 * Copyright 2016 University of Liverpool
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace pgb_liv\php_ms\Reader;

/**
 *
 * @author Andrew Collins
 */
class MzIdentMlReaderFactory
{

    private $xmlReader;

    /**
     * Parses the XML file to identify the specification version and then returns the appropriate reader
     *
     * @param string $filePath
     *            Path to the location of the mzIdentML file
     * @return \pgb_liv\php_ms\Reader\MzIdentMlReader1_0|\pgb_liv\php_ms\Reader\MzIdentMlReader1_1|\pgb_liv\php_ms\Reader\MzIdentMlReader1_2
     */
    public static function getReader($filePath)
    {
        $xmlReader = new \SimpleXMLElement($filePath, null, true);
        
        switch ($xmlReader->attributes()->version) {
            case '1.0.0':
                throw new \UnexpectedValueException('Version 1.0.0 is not supported');
            case '1.1.0':
                return new MzIdentMlReader1_1($filePath);
            case '1.2.0':
                return new MzIdentMlReader1_2($filePath);
        }
    }
}
