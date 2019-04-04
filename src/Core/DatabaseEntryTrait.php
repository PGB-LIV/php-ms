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
namespace pgb_liv\php_ms\Core;

use pgb_liv\php_ms\Core\Entry\DatabaseEntry;

/**
 * Trait for providing access to add and get the list of database entries associated with the parent object
 *
 * @author Andrew Collins
 */
trait DatabaseEntryTrait
{

    /**
     * Sets the database entry for this instance
     *
     * @var DatabaseEntry
     */
    private $database = array();

    public function setDatabaseEntry(DatabaseEntry $dbEntry)
    {
        $this->database = $dbEntry;
    }

    /**
     * Gets the database entry for this instance
     *
     * @return DatabaseEntry
     */
    public function getDatabaseEntry()
    {
        return $this->database;
    }
}
