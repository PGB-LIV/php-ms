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
namespace pgb_liv\php_ms\Reader\FastaEntry;

/**
 * Factory method attempts to find the correct parser for known FASTA entry headers
 *
 * @author Andrew Collins
 */
class FastaEntryFactory
{

    private static $classes = array(
        '\pgb_liv\php_ms\Reader\FastaEntry\UniProtFastaEntry',
        '\pgb_liv\php_ms\Reader\FastaEntry\EnsembleFastaEntry',
        '\pgb_liv\php_ms\Reader\FastaEntry\PeffFastaEntry'
    );

    private static $defaultClass = 'pgb_liv\php_ms\Reader\FastaEntry\DefaultFastaEntry';

    public static function getParser($identifier)
    {
        foreach (self::$classes as $class) {
            try {
                $identifier = $class::parseIdentifier($identifier);

                return new $class();
            } catch (\Exception $e) {
                // Empty - try next parser
            }
        }

        return new self::$defaultClass();
    }
}
