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

use pgb_liv\php_ms\Core\AminoAcidMono;
use pgb_liv\php_ms\Core\ModifiableSequenceInterface;

/**
 * Abstract class containing generic filtering methods
 *
 * @author Andrew Collins
 */
abstract class AbstractFragmentReverse extends AbstractFragment implements FragmentInterface
{

    public function __construct(ModifiableSequenceInterface $sequence)
    {
        $this->setIsReversed(true);
        parent::__construct($sequence);
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
        $sequence = $this->sequence->getSequence();
        
        $sum = 0;
        
        $cTermMass = $this->getCTerminalMass();
        $nTermMass = $this->getNTerminalMass();
        
        for ($i = $this->getEnd(); $i > $this->getStart(); $i --) {
            $residue = $sequence[$i - 1];
            $mass = AminoAcidMono::getMonoisotopicMass($residue);
            
            // Add mass
            if ($i == $this->getEnd()) {
                $mass += $this->getAdditiveMass();
                $mass += $cTermMass;
            }
            
            // Add modification mass
            // Catch modification on position or residue
            foreach ($this->sequence->getModifications() as $modification) {
                // Check every position or residue
                if ($modification->getLocation() === $i || in_array($residue, $modification->getResidues())) {
                    // Residue is modified
                    $mass += $modification->getMonoisotopicMass();
                }
            }
            
            if ($i == 1) {
                $mass += $nTermMass;
            }
            
            $sum += $mass;
            $ions[($this->getEnd() - $i) + 1] = $sum;
        }
        
        return $ions;
    }
}
