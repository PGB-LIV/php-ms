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
 * Abstract database entry object, by default the identifier, description and sequence are required.
 * Extending classes may use the additional fields.
 *
 * @author Andrew Collins
 */
abstract class AbstractDatabaseEntry
{

    protected $description;

    protected $sequence;

    protected $identifier;

    protected $database;

    protected $accession;

    protected $entryName;

    protected $proteinName;

    protected $organismName;

    protected $geneName;

    protected $proteinExistence;

    protected $sequenceVersion;

    public function __construct($identifier, $description, $sequence)
    {
        $this->identifier = $identifier;
        $this->description = $description;
        $this->sequence = $sequence;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Retrieves the database full name.
     *
     * @return string Database name
     */
    public function getDatabase()
    {
        return $this->database;
    }

    public function getAccession()
    {
        return $this->accession;
    }

    public function getEntryName()
    {
        return $this->entryName;
    }

    public function getProteinName()
    {
        return $this->proteinName;
    }

    public function getOrganismName()
    {
        return $this->organismName;
    }

    public function getGeneName()
    {
        return $this->geneName;
    }

    public function getProteinExistence()
    {
        return $this->proteinExistence;
    }

    public function getSequenceVersion()
    {
        return $this->sequenceVersion;
    }
}
