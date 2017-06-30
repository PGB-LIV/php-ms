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
 * Trait for providing access to a sequence and set of modifications
 *
 * @author Andrew Collins
 */
trait ModifiableSequenceTrait
{

    /**
     * The amino-acid sequence that can be modified
     *
     * @var string
     */
    private $sequence;

    /**
     * Array of modifications on this protein sequence
     *
     * @var Modification[]
     */
    private $modifications = array();

    /**
     * Sets whether this sequence is a decoy or not
     *
     * @var bool
     */
    private $isDecoy;

    /**
     * Sets the sequence for this object
     *
     * @param string $sequence
     *            The amino-acid sequence to set
     */
    public function setSequence($sequence)
    {
        if (preg_match('/^[A-Z]+$/', $sequence) !== 1) {
            throw new \InvalidArgumentException('Argument 1 must be a valid peptide sequence.');
        }
        
        $this->sequence = $sequence;
    }

    /**
     * Gets the sequence for this object
     *
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence;
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

    /**
     * Sets whether this sequence is a decoy sequence
     *
     * @param bool $bool
     *            Value to set to
     */
    public function setIsDecoy($bool)
    {
        // TODO: Validate bool
        $this->isDecoy = $bool;
    }

    /**
     * Gets whether this sequence is a decoy sequence
     *
     * @return boolean
     */
    public function isDecoy()
    {
        return $this->isDecoy;
    }

    /**
     * Gets the length of the sequence in this object
     *
     * @return int
     */
    public function getLength()
    {
        return strlen($this->getSequence());
    }

    /**
     * Gets the theoretical neutral mass for this sequence
     *
     * @param string $sequence
     *            The peptide sequence to calculate for
     * @return The neutral mass of the sequence
     */
    public function getMass()
    {
        $acids = str_split($this->getSequence(), 1);
        
        $mass = Peptide::HYDROGEN_MASS + Peptide::HYDROGEN_MASS + Peptide::OXYGEN_MASS;
        
        foreach ($acids as $acid) {
            switch ($acid) {
                case 'X':
                case 'B':
                case 'Z':
                    continue;
                default:
                    $mass += AminoAcidMono::getMonoisotopicMass($acid);
                    break;
            }
        }
        
        return $mass;
    }
}
