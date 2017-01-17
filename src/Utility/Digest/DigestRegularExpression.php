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
namespace pgb_liv\php_ms\Utility\Digest;

use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Peptide;

/**
 * Trypsin digestion for generated trypsinated peptides.
 *
 * @author Andrew Collins
 */
class DigestRegularExpression extends AbstractDigest implements DigestInterface
{

    /**
     * Creates a new instance with the provided regular expression as the cleavage rule.
     *
     * @param unknown $regularExpression            
     */
    public function __construct($regularExpression)
    {
        $this->cleavageRule = $regularExpression;
    }

    /**
     * Cleavage rule regular expresion.
     * Split R or K when not before P.
     *
     * @var string
     */
    private $cleavageRule;

    /**
     * Digest the protein and produce peptides matching the enzyme rules.
     *
     * @param Protein $protein
     *            Must contain a protein sequence
     */
    public function digest(Protein $protein)
    {
        $peptideSequences = preg_split($this->cleavageRule, $protein->getSequence());
        
        $peptides = array();
        $position = 0;
        foreach ($peptideSequences as $peptideSequence) {
            if (strlen($peptideSequence) == 0) {
                continue;
            }
            
            $peptide = new Peptide($peptideSequence);
            $peptide->setProtein($protein);
            $peptide->setPositionStart($position);
            $endPosition = $position + strlen($peptideSequence) - 1;
            $peptide->setPositionEnd($endPosition);
            $peptide->setMissedCleavageCount(0);
            
            $peptides[] = $peptide;
            $position = $endPosition + 1;
        }
        
        $missedCleaveges = array();
        
        // Factor in missed cleaves
        for ($index = 0; $index < count($peptides); $index ++) {
            // Copy peptide
            $basePeptide = $peptides[$index];
            
            $comulativeSequence = $peptides[$index]->getSequence();
            for ($missedCleave = 1; $missedCleave <= $this->maxMissedCleavage; $missedCleave ++) {
                if ($index + $missedCleave >= count($peptides)) {
                    continue;
                }
                
                $comulativeSequence .= $peptides[$index + $missedCleave]->getSequence();
                
                $peptide = new Peptide($comulativeSequence);
                $peptide->setProtein($basePeptide->getProtein());
                $peptide->setPositionStart($basePeptide->getPositionStart());
                $peptide->setPositionEnd($peptide->getPositionStart() + strlen($comulativeSequence) - 1);
                $peptide->setMissedCleavageCount($missedCleave);
                $missedCleaveges[] = $peptide;
            }
        }
        
        return array_merge($peptides, $missedCleaveges);
    }
}
