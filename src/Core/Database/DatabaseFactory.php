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
namespace pgb_liv\php_ms\Core\Database;

/**
 * Factory method to identify correct class for a given prefix that may appear in a FASTA
 *
 * @author Andrew Collins
 */
class DatabaseFactory
{

    private static $classes = array(
        'pgb_liv\php_ms\Core\Database\UniProtSpDatabase',
        'pgb_liv\php_ms\Core\Database\UniProtTrDatabase',
        'pgb_liv\php_ms\Core\Database\EnsemblePDatabase',
        'pgb_liv\php_ms\Core\Database\EnsembleTDatabase',
        'pgb_liv\php_ms\Core\Database\NeXtProtDatabase'
    );

    public static function getDatabase($prefix)
    {
        foreach (self::$classes as $class) {
            if ($class::PREFIX == $prefix) {
                return $class::getInstance();
            }
        }

        $database = new DefaultDatabase();
        $database->setPrefix($prefix);

        return $database;
    }
}
