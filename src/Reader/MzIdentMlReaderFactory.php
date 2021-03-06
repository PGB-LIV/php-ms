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

    /**
     * Parses the XML file to identify the specification version and then returns the appropriate reader
     *
     * @param string $filePath
     *            Path to the location of the mzIdentML file
     * @return MzIdentMlReader1Interface
     */
    public static function getReader($filePath)
    {
        $xmlReader = new \SimpleXMLElement($filePath, null, true);
        
        switch ($xmlReader->attributes()->version) {
            case '1.1.0':
                return new MzIdentMlReader1r1($filePath);
            case '1.2.0':
                return new MzIdentMlReader1r2($filePath);
            default:
                throw new \UnexpectedValueException('Version ' . $xmlReader->attributes()->version . ' is not supported');
        }
    }
}
