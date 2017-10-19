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
namespace pgb_liv\php_ms\Utility\Fragment;

use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\AminoAcidMono;

/**
 * Abstract class containing generic filtering methods
 *
 * @author Andrew Collins
 */
abstract class AbstractFragmentReverse extends AbstractFragment
{

    public function __construct(Peptide $peptide)
    {
        $this->setIsReversed(true);
        parent::__construct($peptide);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getIons()
     */
    public function getIons()
    {
        $ions = array();
        $sequence = $this->peptide->getSequence();
        
        $sum = 0;
        
        $cTermMass = $this->getCTerminalMass();
        $nTermMass = $this->getNTerminalMass();
        
        for ($i = $this->getEnd() - 1; $i >= $this->getStart(); $i --) {
            $aa = $sequence[$i];
            $mass = AminoAcidMono::getMonoisotopicMass($aa);
            
            // Add mass
            if ($i == $this->getEnd() - 1) {
                $mass += $this->getAdditiveMass();
                $mass += $cTermMass;
            }
            
            // Add modification mass
            // Catch modification on position or residue
            foreach ($this->peptide->getModifications() as $modification) {
                // Check every position or residue
                if ($modification->getLocation() === $i + 1 || in_array($aa, $modification->getResidues())) {
                    // Residue is modified
                    $mass += $modification->getMonoisotopicMass();
                }
            }
            
            if ($i == 0) {
                $mass += $nTermMass;
            }
            
            $sum += $mass;
            $ions[$this->getEnd() - $i] = $sum;
        }
        
        return $ions;
    }
}
