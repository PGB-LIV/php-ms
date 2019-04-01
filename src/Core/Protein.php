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

/**
 * A protein object that encapsulates a modifiable sequence and provides additional properties
 *
 * @author Andrew Collins
 */
class Protein implements ModifiableSequenceInterface
{
    use ModifiableSequenceTrait;
    use DatabaseEntryTrait;

    /**
     * The unique identifier for this sequence.
     *
     * @var string
     */
    private $identifier;

    /**
     * The description or name of this sequence.
     *
     * @var string
     */
    private $description;

    /**
     *
     * @var Gene
     */
    private $gene;

    /**
     *
     * @var Transcript
     */
    private $transcript;

    /**
     *
     * @var Organism
     */
    private $organism;

    /**
     *
     * @var Chromosome
     */
    private $chromosome;

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the parent gene of this protein
     *
     * @param Gene $gene
     */
    public function setGene($gene)
    {
        $this->gene = $gene;
    }

    /**
     * Gets the parent gene of this protein
     *
     * @return Gene
     */
    public function getGene()
    {
        return $this->gene;
    }

    /**
     * Sets the parent transcript of this protein
     *
     * @param Gene $gene
     */
    public function setTranscript($transcript)
    {
        $this->transcript = $transcript;
    }

    /**
     * Gets the parent transcript of this protein
     *
     * @return Transcript
     */
    public function getTranscript()
    {
        return $this->transcript;
    }

    public function setOrganism(Organism $organism)
    {
        $this->organism = $organism;
    }

    /**
     *
     * @return Organism
     */
    public function getOrganism()
    {
        return $this->organism;
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

    /**
     * This will get the unique identifier for this sequence.
     * This field should match the complete FASTA identifier.
     *
     * @return string
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * This will get the unique identifier for this sequence.
     * This field should match the complete FASTA identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
