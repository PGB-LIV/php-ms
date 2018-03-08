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
     * Clears the modifications
     */
    public function clearModifications()
    {
        $this->modifications = array();
    }

    /**
     * Remove a modification
     */
    public function removeModification(Modification $searchModification)
    {
        foreach ($this->modifications as $key => $modification) {
            if ($modification !== $searchModification) {
                continue;
            }
            
            unset($this->modifications[$key]);
        }
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
        if (! is_bool($bool)) {
            throw new \InvalidArgumentException('Argument 1 must be a boolean value');
        }
        
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
     * Gets the theoretical monoisotopic neutral mass for this sequence and it's modifications
     *
     * @return double The neutral mass of the sequence
     * @deprecated Use getMonoisotopicMass() directly
     */
    public function getMass()
    {
        return $this->getMonoisotopicMass();
    }

    /**
     * Gets the theoretical monoisotopic neutral mass for this sequence and it's modifications
     *
     * @return double The neutral mass of the sequence
     */
    public function getMonoisotopicMass()
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
        
        // Add modification mass
        // Catch modification on position, residue or terminus
        foreach ($this->getModifications() as $modification) {
            if (! is_null($modification->getLocation())) {
                $mass += $modification->getMonoisotopicMass();
                continue;
            }
            
            foreach ($acids as $acid) {
                if (in_array($acid, $modification->getResidues())) {
                    $mass += $modification->getMonoisotopicMass();
                }
            }
            
            if (in_array('[', $modification->getResidues()) || in_array(']', $modification->getResidues())) {
                $mass += $modification->getMonoisotopicMass();
            }
        }
        
        return $mass;
    }

    /**
     * Calculates the theoretical mass/charge value for this sequence.
     * Note: To get the experimental value, check the PrecursorIon data that this peptide might be a child of.
     *
     * @param int $charge
     *            The charge value to use for the calculation
     */
    public function getMonoisotopicMassCharge($charge)
    {
        $massCharge = $this->getMonoisotopicMass();
        // TODO: Should use same Proton mass constant as IonTrait
        $massCharge += 1.007276466812 * $charge;
        
        return $massCharge / $charge;
    }

    /**
     * Reverses the current sequence.
     * Suitable for creating decoy sequences
     *
     * @todo This method does not yet respect modification absolute location data
     */
    public function reverseSequence()
    {
        $this->sequence = strrev($this->sequence);
    }
}
