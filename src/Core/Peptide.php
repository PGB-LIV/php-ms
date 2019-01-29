<?php
/**
 * Copyright 2018 University of Liverpool
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

use pgb_liv\php_ms\Constant\ChemicalConstants;
use pgb_liv\php_ms\Constant\PhysicalConstants;

/**
 * A peptide object that encapsulates a modifiable sequence and provides additional properties
 *
 * @author Andrew Collins
 */
class Peptide implements ModifiableSequenceInterface
{
    use ModifiableSequenceTrait, ProteinTrait;

    const AMINO_ACID_X_MASS = 0;

    const AMINO_ACID_B_MASS = 0;

    const AMINO_ACID_Z_MASS = 0;

    /**
     *
     * @deprecated Use ChemicalConstants
     * @var float
     */
    const HYDROGEN_MASS = ChemicalConstants::HYDROGEN_MASS;

    /**
     *
     * @deprecated Use ChemicalConstants
     * @var float
     */
    const OXYGEN_MASS = ChemicalConstants::OXYGEN_MASS;

    /**
     *
     * @deprecated Use ChemicalConstants
     * @var float
     */
    const NITROGEN_MASS = ChemicalConstants::NITROGEN_MASS;

    /**
     *
     * @deprecated Use PhysicalConstants
     * @var float
     */
    const PROTON_MASS = PhysicalConstants::PROTON_MASS;
    
    /**
     *
     * @deprecated Use ChemicalConstants::HYDROGEN_MASS
     * @var float
     */
    const N_TERM_MASS = 1.007875;
    
    /**
     *
     * @deprecated Use ChemicalConstants::HYDROGEN_MASS+ChemicalConstants::OXYGEN_MASS
     * @var float
     */
    const C_TERM_MASS = 17.00278;
    
    private $missedCleavageCount;

    public function __construct($sequence = null)
    {
        if (! is_null($sequence)) {
            $this->setSequence($sequence);
        }
    }

    public function setMissedCleavageCount($count)
    {
        if (! is_int($count)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type integer. Argument type is ' . gettype($count));
        }

        $this->missedCleavageCount = $count;
    }

    public function getMissedCleavageCount()
    {
        return $this->missedCleavageCount;
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
            preg_match_all('/([A-Z][a-z]?)([0-9]*)/', $composition, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $chemical = $match[1];
                $count = $match[2];

                if (! isset($frequency[$chemical])) {
                    $frequency[$chemical] = 0;
                }

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
