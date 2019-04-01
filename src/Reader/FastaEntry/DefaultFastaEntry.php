<?php
/**
 * Copyright 2019 University of Liverpool
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

use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Database\DefaultDatabase;
use pgb_liv\php_ms\Core\Entry\DatabaseEntry;

/**
 * A fallback object to use if unable to safely parse fasta data
 *
 * @author Andrew Collins
 */
class DefaultFastaEntry implements FastaInterface
{

    public static function parseIdentifier($identifier)
    {
        return array(
            $identifier
        );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getProtein($identifier, $description)
    {
        $protein = new Protein();

        $database = new DefaultDatabase();
        $dbEntry = new DatabaseEntry($database);
        $dbEntry->setUniqueIdentifier($identifier);
        $protein->addDatabaseEntry($dbEntry);

        $protein->setDescription($description);

        return $protein;
    }
}
