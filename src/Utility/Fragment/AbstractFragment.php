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

    private $isReversed = false;

    private $peptide;

    public function __construct(Peptide $peptide)
    {
        $this->peptide = $peptide;
    }

    public function getIons()
    {
        // TODO: Add modification support
        $ions = array();
        $sequence = $this->peptide->getSequence();
        
        if ($this->isReversed) {
            $sequence = strrev($sequence);
        }
        
        $sum = 0;
        
        for ($i = 0; $i < $this->getLength(); $i ++) {
            $aa = $sequence[$i];
            $mass = AminoAcidMono::getMonoisotopicMass($aa);
            
            // Add mass
            if (! $this->isReversed && $i == 0) {
                $mass += $this->getAdditiveMass();
            } elseif ($this->isReversed && $i == 0) {
                $mass += $this->getAdditiveMass();
            }
            
            $sum += $mass;
            $ions[$i + 1] = $sum;
        }
        
        return $ions;
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
}
