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

use pgb_liv\php_ms\Core\Spectra\SpectraEntry;

/**
 * Creates an instance of a peptide filter than can be used with a list of peptides to
 * remove those which do not it the criteria.
 *
 * @author Andrew Collins
 */
class FilterCharge extends AbstractFilter
{

    /**
     * Minimum peptide length, inclusive
     *
     * @var integer
     */
    private $minCharge = 1;

    /**
     * Maximum peptide length, inclusive
     *
     * @var integer
     */
    private $maxCharge = 3;

    /**
     * Creates a new instance with the specified minimum and maximum charge values.
     *
     * @param int $minCharge
     *            Minimum peptide length, inclusive
     * @param int $maxCharge
     *            Maximum peptide length, inclusive
     */
    public function __construct($minCharge, $maxCharge)
    {
        if (! is_int($minCharge)) {
            throw new \InvalidArgumentException('Argument 1 must be of type int. Value is of type ' . gettype($minCharge));
        }
        
        if (! is_int($maxCharge)) {
            throw new \InvalidArgumentException('Argument 2 must be of type int. Value is of type ' . gettype($maxCharge));
        }
        
        $this->minCharge = $minCharge;
        $this->maxCharge = $maxCharge;
    }

    /**
     * Returns true if the SpectraEntry matches the filter criteria, else false
     *
     * @param SpectraEntry $peptide
     *            Spectra object to filter
     */
    public function isValidSpectra(SpectraEntry $spectra)
    {
        if ($spectra->getCharge() < $this->minCharge) {
            return false;
        }
        
        if ($spectra->getCharge() > $this->maxCharge) {
            return false;
        }
        
        return true;
    }
}
