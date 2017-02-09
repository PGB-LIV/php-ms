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
 * Creates an instance of a filter than can be used with a list to
 * remove those which do not fit the criteria.
 *
 * @author Andrew Collins
 */
class FilterMass extends AbstractFilter
{

    /**
     * Minimum mass, inclusive
     *
     * @var integer
     */
    private $minMass;

    /**
     * Maximum mass, inclusive
     *
     * @var integer
     */
    private $maxMass;

    /**
     * Creates a new instance with the specified minimum and maximum mass values.
     *
     * @param int $minMass
     *            Minimum mass, inclusive
     * @param int $maxMass
     *            Maximum mass, inclusive
     */
    public function __construct($minMass, $maxMass)
    {
        if (! is_float($minMass)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type float. Value is of type ' . gettype($minMass));
        }
        
        if (! is_float($maxMass)) {
            throw new \InvalidArgumentException(
                'Argument 2 must be of type float. Value is of type ' . gettype($maxMass));
        }
        
        $this->minMass = $minMass;
        $this->maxMass = $maxMass;
    }

    /**
     * Returns true if the SpectraEntry matches the filter criteria, else false
     *
     * @param SpectraEntry $peptide
     *            Spectra object to filter
     */
    public function isValidSpectra(SpectraEntry $spectra)
    {
        if ($spectra->getMass() < $this->minMass) {
            return false;
        }
        
        if ($spectra->getMass() > $this->maxMass) {
            return false;
        }
        
        return true;
    }

    /**
     * Returns true if the Peptide matches the filter criteria, else false
     *
     * @param Peptide $peptide
     *            Peptide object to filter
     */
    public function isValidPeptide(Peptide $peptide)
    {
        throw new \BadMethodCallException("isValidPeptide is not defined for this instance.");
    }
}
