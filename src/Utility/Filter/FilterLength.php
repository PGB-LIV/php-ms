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
namespace pgb_liv\php_ms\Utility\Filter;

use pgb_liv\php_ms\Core\Peptide;

/**
 * Creates an instance of a peptide filter than can be used with a list of peptides to
 * remove those which do not it the criteria.
 *
 * @author Andrew Collins
 */
class FilterLength extends AbstractFilter
{

    /**
     * Minimum peptide length, inclusive
     *
     * @var integer
     */
    private $minLength = 6;

    /**
     * Maximum peptide length, inclusive
     *
     * @var integer
     */
    private $maxLength = 60;

    public function __construct($minLength, $maxLength)
    {
        $this->minLength = $minLength;
        
        $this->maxLength = $maxLength;
    }

    /**
     * Returns true if the Peptide matches the filter criteria, else false
     *
     * @param Peptide $peptide
     *            Must contain a peptide sequence
     */
    public function isValid(Peptide $peptide)
    {
        if ($peptide->getLength() < $this->minLength) {
            return false;
        }
        
        if ($peptide->getLength() > $this->maxLength) {
            return false;
        }
        
        return true;
    }
}
