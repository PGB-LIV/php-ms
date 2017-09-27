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
namespace pgb_liv\php_ms\Utility\Fragment;

use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\AminoAcidMono;

/**
 * Abstract class containing generic filtering methods
 *
 * @author Andrew Collins
 */
abstract class AbstractFragment
{
    protected $peptide;

    /**
     * Creates a new instance of this fragmenter using the specified peptide
     *
     * @param Peptide $peptide
     *            Peptide object which must contain a sequence
     *            
     * @throws \InvalidArgumentException If the peptide object does not contain a sequence
     */
    public function __construct(Peptide $peptide)
    {
        if (is_null($peptide->getSequence()) || strlen($peptide->getSequence()) == 0) {
            throw new \InvalidArgumentException('Null or empty sequence received.');
        }
        
        $this->peptide = $peptide;
    }

    /**
     * Gets the fragmentation ions for this instances peptide sequence
     *
     * @return number[]
     */
    public function getIons()
    {
        $ions = array();
        $sequence = $this->peptide->getSequence();
        
        $sum = 0;
        
        $cTermMass = $this->getCTerminalMass();
        $nTermMass = $this->getNTerminalMass();
        
        for ($i = 0; $i < $this->getLength(); $i ++) {
            $aa = $sequence[$i];
            $mass = AminoAcidMono::getMonoisotopicMass($aa);
            
            // Add mass
            if ($i == 0) {
                $mass += $this->getAdditiveMass();
                $mass += $nTermMass;
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
            
            if ($i + 1 == $this->peptide->getLength()) {
                $mass += $cTermMass;
            }
            
            $sum += $mass;
            $ions[$i + 1] = $sum;
        }
        
        return $ions;
    }

    protected function getNTerminalMass()
    {
        $mass = 0;
        foreach ($this->peptide->getModifications() as $modification) {
            if ($modification->getLocation() === 0 || in_array('[', $modification->getResidues())) {
                $mass += $modification->getMonoisotopicMass();
            }
        }
        
        return $mass;
    }

    protected function getCTerminalMass()
    {
        $mass = 0;
        foreach ($this->peptide->getModifications() as $modification) {
            
            if ($modification->getLocation() === $this->peptide->getLength() + 1 ||
                 in_array(']', $modification->getResidues())) {
                $mass += $modification->getMonoisotopicMass();
            }
        }
        
        return $mass;
    }

    /**
     * Gets the length of the fragment chain
     *
     * @return int
     */
    protected function getLength()
    {
        return $this->peptide->getLength();
    }

    /**
     * Gets the additional mass gained in fragmentation
     *
     * @return double
     */
    abstract protected function getAdditiveMass();

    protected function setIsReversed($bool)
    {
        $this->isReversed = $bool;
    }

    /**
     * Gets the direction ions should be read
     *
     * @return boolean
     */
    public function isReversed()
    {
        return $this->isReversed;
    }
}
