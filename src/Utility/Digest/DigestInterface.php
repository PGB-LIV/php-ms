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

/**
 * Generic interface for all digestion algorithms
 *
 * @author Andrew Collins
 */
interface DigestInterface
{

    /**
     * Digest the protein and produce peptides matching the enzyme rules.
     *
     * @param Protein $protein
     *            Must contain a protein sequence
     *            
     * @return array
     */
    public function digest(Protein $protein);

    /**
     * Returns the name of this enzyme
     *
     * @return string
     */
    public function getName();

    /**
     * Set the maximum number of missed cleavages the algorithm should produce.
     * By default no missed cleavages are produced.
     *
     * @param int $maxMissedCleavage
     *            Maximum number of cleavages to account for
     */
    public function setMaxMissedCleavage($maxMissedCleavage);

    /**
     * Gets the maximum missed cleavage count value
     *
     * @return int max missed cleavage count
     */
    public function getMaxMissedCleavage();

    /**
     * Sets whether n-terminal methionine excision should be performed.
     * When enabled any methionine at the n-terminus of a protein will be removed.
     * Both the excised and non-excised peptide will be returned after
     * digestion. Defaults to true.
     *
     * @param bool $isNmeEnabled
     *            Set true to enable n-terminal methionine excision
     */
    public function setNmeEnabled($isNmeEnabled);

    /**
     * Tells whether n-terminal methionine excision will be performed or not.
     *
     * @return boolean true if NME is enabled, else false
     */
    public function isNmeEnabled();
}
