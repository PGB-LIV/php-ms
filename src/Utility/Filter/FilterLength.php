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
    private $minLength;

    /**
     * Maximum peptide length, inclusive
     *
     * @var integer
     */
    private $maxLength;

    /**
     * Creates a new instance with the specified minimum and maximum length values.
     * Specify null for minimum or maximum for no limit.
     *
     * @param int $minCharge
     *            Minimum spectra charge, inclusive
     * @param int $maxCharge
     *            Maximum spectra charge, inclusive
     */
    public function __construct($minLength, $maxLength = null)
    {
        if (! is_int($minLength) && ! is_null($minLength)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int or null. Value is of type ' . gettype($minLength));
        }
        
        if (! is_int($maxLength) && ! is_null($maxLength)) {
            throw new \InvalidArgumentException(
                'Argument 2 must be of type int or null. Value is of type ' . gettype($maxLength));
        }
        
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Filter\AbstractFilter::isValidPeptide()
     */
    public function isValidPeptide(Peptide $peptide)
    {
        if (! is_null($this->minLength) && $peptide->getLength() < $this->minLength) {
            return false;
        }
        
        if (! is_null($this->maxLength) && $peptide->getLength() > $this->maxLength) {
            return false;
        }
        
        return true;
    }
}
