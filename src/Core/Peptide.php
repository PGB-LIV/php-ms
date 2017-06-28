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
class Peptide
{
    use ModifiableSequenceTrait;

    const AMINO_ACID_X_MASS = 0;

    const AMINO_ACID_B_MASS = 0;

    const AMINO_ACID_Z_MASS = 0;

    const HYDROGEN_MASS = 1.007825;

    const OXYGEN_MASS = 15.994915;

    const NITROGEN_MASS = 14.00307;

    const PROTON_MASS = 1.007276;

    const N_TERM_MASS = 1.007875;

    const C_TERM_MASS = 17.00278;

    /**
     * The parent protein of this peptide
     *
     * @var Protein
     */
    private $protein;

    private $positionStart;

    private $positionEnd;

    private $missedCleavageCount;

    public function setPositionStart($position)
    {
        if (! is_int($position)) {
            throw new \InvalidArgumentException('Argument 1 must be of type integer. Argument type is ' . gettype($position));
        }
        
        $this->positionStart = $position;
    }

    public function setPositionEnd($position)
    {
        if (! is_int($position)) {
            throw new \InvalidArgumentException('Argument 1 must be of type integer. Argument type is ' . gettype($position));
        }
        
        $this->positionEnd = $position;
    }

    public function setMissedCleavageCount($count)
    {
        if (! is_int($count)) {
            throw new \InvalidArgumentException('Argument 1 must be of type integer. Argument type is ' . gettype($count));
        }
        
        $this->missedCleavageCount = $count;
    }

    public function getMissedCleavageCount()
    {
        return $this->missedCleavageCount;
    }

    public function setProtein(Protein $protein)
    {
        $this->protein = $protein;
    }

    /**
     * Gets the parent protein of this peptide
     *
     * @return Protein
     */
    public function getProtein()
    {
        return $this->protein;
    }

    public function getPositionStart()
    {
        return $this->positionStart;
    }

    public function getPositionEnd()
    {
        return $this->positionEnd;
    }

    /**
     * Calculates the neutral mass of a sequence
     *
     * @param string $sequence
     *            The peptide sequence to calculate for
     * @return The neutral mass of the sequence
     */
    public function calculateMass()
    {
        $acids = str_split($this->getSequence(), 1);
        
        $mass = static::HYDROGEN_MASS + static::HYDROGEN_MASS + static::OXYGEN_MASS;
        foreach ($acids as $acid) {
            switch ($acid) {
                case 'X':
                    $mass += Peptide::AMINO_ACID_X_MASS;
                    break;
                case 'B':
                    $mass += Peptide::AMINO_ACID_B_MASS;
                    break;
                case 'Z':
                    $mass += Peptide::AMINO_ACID_Z_MASS;
                    break;
                default:
                    $mass += AminoAcidMono::getMonoisotopicMass($acid);
                    break;
            }
        }
        
        return $mass;
    }

    public function getIonsB()
    {
        // TODO: Add modification support
        $ions = array();
        $sequence = $this->getSequence();
        $sum = 0;
        
        for ($i = 0; $i < $this->getLength(); $i ++) {
            $aa = $sequence[$i];
            $mass = AminoAcidMono::getMonoisotopicMass($aa);
            
            if ($i == 0) {
                $mass += Peptide::N_TERM_MASS;
                $mass -= Peptide::HYDROGEN_MASS;
                $mass += Peptide::PROTON_MASS;
            }
            
            $sum += $mass;
            $ions[$i + 1] = $sum;
        }
        
        return $ions;
    }

    public function getIonsY()
    {
        // TODO: Add modification support
        $ions = array();
        $sequence = $this->getSequence();
        $sum = 0;
        
        for ($i = $this->getLength() - 1; $i >= 0; $i --) {
            $aa = $sequence[$i];
            $mass = AminoAcidMono::getMonoisotopicMass($aa);
            
            if ($i == $this->getLength() - 1) {
                $mass += Peptide::C_TERM_MASS;
                $mass += Peptide::HYDROGEN_MASS;
                $mass += Peptide::PROTON_MASS;
            }
            
            $sum += $mass;
            $ions[($this->getLength() - $i)] = $sum;
        }
        
        return $ions;
    }

    public function getIonsC()
    {
        // TODO: Add modification support
        $ions = array();
        $sequence = $this->getSequence();
        $sum = 0;
        
        for ($i = 0; $i < $this->getLength(); $i ++) {
            $aa = $sequence[$i];
            $mass = AminoAcidMono::getMonoisotopicMass($aa);
            
            if ($i == 0) {
                $mass += Peptide::N_TERM_MASS;
                $mass += Peptide::NITROGEN_MASS + Peptide::HYDROGEN_MASS + Peptide::HYDROGEN_MASS;
                $mass += Peptide::PROTON_MASS;
            }
            
            $sum += $mass;
            $ions[$i + 1] = $sum;
        }
        
        return $ions;
    }

    public function getIonsZ()
    {
        // TODO: Add modification support
        $ions = array();
        $sequence = $this->getSequence();
        $sum = 0;
        
        for ($i = $this->getLength() - 1; $i >= 0; $i --) {
            $aa = $sequence[$i];
            $mass = AminoAcidMono::getMonoisotopicMass($aa);
            
            if ($i == $this->getLength() - 1) {
                $mass += Peptide::C_TERM_MASS;
                $mass -= Peptide::NITROGEN_MASS + Peptide::HYDROGEN_MASS + Peptide::HYDROGEN_MASS;
                $mass += Peptide::PROTON_MASS;
                
                // Add electrons??
                $mass += 0.00054858 * 2;
            }
            
            $sum += $mass;
            $ions[($this->getLength() - $i)] = $sum;
        }
        
        return $ions;
    }

    public function __clone()
    {
        // Create new instances of objects
        $oldMods = $this->modifications;
        $this->modifications = array();
        
        foreach ($oldMods as $modification) {
            $this->modifications[] = clone $modification;
        }
    }

    /**
     * Gets the molecular formula for this peptide string.
     *
     * @return string Molecular formula
     */
    public function getMolecularFormula()
    {
        $acids = str_split($this->getSequence(), 1);
        
        $frequency = array(
            'C' => 0,
            'H' => 0,
            'N' => 0,
            'O' => 0,
            'S' => 0
        );
        
        foreach ($acids as $acid) {
            $composition = AminoAcidComposition::getFormula($acid);
            
            $matches = array();
            preg_match('/([A-Z])([0-9]*)([A-Z]?)([0-9]*)([A-Z]?)([0-9]*)([A-Z]?)([0-9]*)([A-Z]?)([0-9]*)/', $composition, $matches);
            
            for ($i = 1; $i < count($matches); $i += 2) {
                if ($matches[$i] == '') {
                    continue;
                }
                
                $chemical = $matches[$i];
                $count = $matches[$i + 1];
                
                $frequency[$chemical] += $count == '' ? 1 : $count;
            }
        }
        
        // Remove hydrogen and oxygen from C-TERM
        $frequency['H'] -= count($acids) - 1;
        $frequency['O'] -= count($acids) - 1;
        
        // Remove hydrogen from N-TERM.
        $frequency['H'] -= count($acids) - 1;
        
        $formula = '';
        foreach ($frequency as $chemical => $count) {
            if ($count == 0) {
                continue;
            }
            
            $formula .= $chemical;
            
            if ($count > 1) {
                $formula .= $count;
            }
        }
        
        return $formula;
    }
}
