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
namespace pgb_liv\php_ms\Core;

/**
 * Abstract database entry object, by default the identifier, description and sequence are required.
 * Extending classes may use the additional fields.
 *
 * @author Andrew Collins
 */
class Protein
{

    private $description;

    private $sequence;

    private $uniqueIdentifier;

    private $databasePrefix;

    private $accession;

    private $entryName;

    private $proteinName;

    private $organismName;

    private $geneName;

    private $proteinExistence;

    private $sequenceVersion;

    /**
     * Array of modifications on this protein sequence
     *
     * @var Modification[]
     */
    private $modifications = array();

    public function setUniqueIdentifier($identifier)
    {
        $this->uniqueIdentifier = $identifier;
    }

    public function getUniqueIdentifier()
    {
        return $this->uniqueIdentifier;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    public function getSequence()
    {
        return $this->sequence;
    }

    public function setDatabasePrefix($database)
    {
        $this->databasePrefix = $database;
    }

    public function getDatabasePrefix()
    {
        return $this->databasePrefix;
    }

    /**
     * Attempts to map the database prefix to the full database name.
     *
     * @return string|null The full database name or null
     */
    public function getDatabaseName()
    {
        $databaseName = null;
        
        if ($this->databasePrefix == 'sp') {
            $this->databasePrefix = 'UniProtKB/Swiss-Prot';
        } elseif ($this->databasePrefix == 'tr') {
            $this->databasePrefix = 'UniProtKB/TrEMBL';
        }
        
        return $databaseName;
    }

    public function setAccession($accession)
    {
        $this->accession = $accession;
    }

    public function getAccession()
    {
        return $this->accession;
    }

    public function setEntryName($entryName)
    {
        $this->entryName = $entryName;
    }

    public function getEntryName()
    {
        return $this->entryName;
    }

    public function setProteinName($proteinName)
    {
        $this->proteinName = $proteinName;
    }

    public function getProteinName()
    {
        return $this->proteinName;
    }

    public function setOrganismName($organismName)
    {
        $this->organismName = $organismName;
    }

    public function getOrganismName()
    {
        return $this->organismName;
    }

    public function setGeneName($geneName)
    {
        $this->geneName = $geneName;
    }

    public function getGeneName()
    {
        return $this->geneName;
    }

    public function setProteinExistence($proteinExistence)
    {
        $this->proteinExistence = $proteinExistence;
    }

    public function getProteinExistence()
    {
        return $this->proteinExistence;
    }

    public function setSequenceVersion($version)
    {
        $this->sequenceVersion = $version;
    }

    public function getSequenceVersion()
    {
        return $this->sequenceVersion;
    }

    /**
     * Reverses the current protein sequence.
     * For creating decoy proteins.
     */
    public function reverseSequence()
    {
        $this->sequence = strrev($this->sequence);
    }

    /**
     * Adds the specified modification to this protein
     *
     * @param Modification $modification
     *            Modification object to apply
     */
    public function addModification(Modification $modification)
    {
        $this->modifications[] = $modification;
    }

    /**
     * Adds the specified modifications to this protein
     *
     * @param array $modifications
     *            Modifications to apply
     */
    public function addModifications(array $modifications)
    {
        foreach ($modifications as $modification) {
            $this->addModification($modification);
        }
    }

    /**
     * Gets the modifications
     *
     * @return Modification[]
     */
    public function getModifications()
    {
        return $this->modifications;
    }

    /**
     * Returns whether this protein contains modifications or not
     *
     * @return boolean True if the object contains modifications
     */
    public function isModified()
    {
        return count($this->modifications) != 0;
    }
}
