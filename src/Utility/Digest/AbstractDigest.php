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
 * Abstract class for digestion algorithms.
 *
 * @author Andrew Collins
 */
abstract class AbstractDigest
{

    /**
     * Whether to perform n-terminus methionine excision when generating peptides
     *
     * @var bool
     */
    private $isNmeEnabled = true;

    /**
     * Maximum number of missed cleavages a peptide may contain
     *
     * @var integer
     */
    private $maxMissedCleavage = 0;

    /**
     * The name for this enzyme
     *
     * @var string
     */
    private $name = 'Unknown';

    /**
     * Set the maximum number of missed cleavages the algorithm should produce.
     * By default no missed cleavages are produced.
     *
     * @param int $maxMissedCleavage
     *            Maximum number of cleavages to account for
     */
    public function setMaxMissedCleavage($maxMissedCleavage)
    {
        if (! is_int($maxMissedCleavage)) {
            throw new \InvalidArgumentException(
                'Invalid argument type, integer expected. Received ' . gettype($maxMissedCleavage));
        }
        
        $this->maxMissedCleavage = $maxMissedCleavage;
    }

    /**
     * Gets the maximum missed cleavage count value
     *
     * @return int max missed cleavage count
     */
    public function getMaxMissedCleavage()
    {
        return $this->maxMissedCleavage;
    }

    /**
     * Sets whether n-terminal methionine excision should be performed.
     * When enabled any methionine at the n-terminus of a protein will be removed.
     * Both the excised and non-excised peptide will be returned after
     * digestion. Defaults to true.
     *
     * @param bool $isNmeEnabled
     *            Set true to enable n-terminal methionine excision
     */
    public function setNmeEnabled($isNmeEnabled)
    {
        if (! is_bool($isNmeEnabled)) {
            throw new \InvalidArgumentException(
                'Invalid argument type, bool expected. Received ' . gettype($isNmeEnabled));
        }
        
        $this->isNmeEnabled = $isNmeEnabled;
    }

    /**
     * Tells whether n-terminal methionine excision will be performed or not.
     *
     * @return boolean true if NME is enabled, else false
     */
    public function isNmeEnabled()
    {
        return $this->isNmeEnabled;
    }

    /**
     * Digest the protein and produce peptides matching the enzyme rules.
     *
     * @param Protein $protein
     *            Must contain a protein sequence
     */
    public function digest(Protein $protein)
    {
        $peptides = $this->performDigestion($protein);
        
        if ($this->isNmeEnabled) {
            $peptides = $this->performMethionineExcision($peptides);
        }
        
        return $peptides;
    }

    private function performMethionineExcision(array $peptides)
    {
        $nmePeptides = array();
        foreach ($peptides as $peptide) {
            if ($peptide->getPositionStart() > 0) {
                continue;
            }
            
            $sequence = $peptide->getSequence();
            if ($sequence[0] != 'M') {
                continue;
            }
            
            $nmePeptide = new Peptide(substr($sequence, 1));
            $nmePeptide->setProtein($peptide->getProtein());
            $nmePeptide->setPositionStart(1);
            $nmePeptide->setPositionEnd($peptide->getPositionEnd());
            $nmePeptide->setMissedCleavageCount($peptide->getMissedCleavageCount());
            
            $nmePeptides[] = $nmePeptide;
        }
        
        return array_merge($peptides, $nmePeptides);
    }

    abstract protected function performDigestion(Protein $protein);

    protected function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
