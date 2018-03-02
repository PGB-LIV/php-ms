<?php
/**
 * Copyright 2017 University of Liverpool
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
 * A protein object that encapsulates a modifiable sequence and provides additional properties
 *
 * @author Andrew Collins
 */
class Protein implements ModifiableSequenceInterface
{
    use ModifiableSequenceTrait;

    private $description;

    private $uniqueIdentifier;

    private $databasePrefix;

    private $accession;

    private $entryName;

    private $name;

    private $organismName;

    private $geneName;

    private $proteinExistence;

    private $sequenceVersion;

    /**
     *
     * @var Chromosome
     */
    private $chromosome;

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
            $databaseName = 'UniProtKB/Swiss-Prot';
        } elseif ($this->databasePrefix == 'tr') {
            $databaseName = 'UniProtKB/TrEMBL';
        } elseif ($this->databasePrefix == 'nxp') {
            $databaseName = 'NeXtProt';
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

    /**
     * Sets the protein name.
     *
     * @param string $name
     *            name of the protein
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the protein name.
     */
    public function getName()
    {
        return $this->name;
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

    public function setChromosome(Chromosome $chromosome)
    {
        $this->chromosome = $chromosome;
    }

    /**
     *
     * @return Chromosome
     */
    public function getChromosome()
    {
        return $this->chromosome;
    }
}
