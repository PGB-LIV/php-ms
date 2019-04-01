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
namespace pgb_liv\php_ms\Core\Entry;

use pgb_liv\php_ms\Core\Database\DatabaseInterface;

/**
 * A database entry element, allows for assigning an object to a specific database reference
 *
 * @author Andrew Collins
 */
class DatabaseEntry
{

    /**
     * The database object to link
     *
     * @var DatabaseInterface
     */
    private $database;

    /**
     * The level of evidence of that this database on this entry.
     *
     * @var string
     */
    private $evidence;

    /**
     * The version number of this entry.
     *
     * @var int
     */
    private $version;

    /**
     * The unique identifier associated with the database entry.
     *
     * @var string
     */
    private $uniqueIdentifier;

    /**
     * Tne name of this entry
     *
     * @var string
     */
    private $name;

    /**
     * Creates a new DatabaseEntry object with the specified database
     *
     * @param DatabaseInterface $protein
     *            The database object that will be referenced by the user of this instance
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * Gets the database
     *
     * @return DatabaseInterface
     */
    public function getDatabase()
    {
        return $this->database;
    }

    public function setEvidence($proteinExistence)
    {
        $this->evidence = $proteinExistence;
    }

    public function getEvidence()
    {
        return $this->evidence;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setUniqueIdentifier($identifier)
    {
        $this->uniqueIdentifier = $identifier;
    }

    public function getUniqueIdentifier()
    {
        return $this->uniqueIdentifier;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
