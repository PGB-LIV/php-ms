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
use pgb_liv\php_ms\Core\Spectra\IonInterface;

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
     * @var float
     */
    private $minMass;

    /**
     * Maximum mass, inclusive
     *
     * @var float
     */
    private $maxMass;

    /**
     * Creates a new instance with the specified minimum and maximum mass values.
     *
     * @param float $minMass
     *            Minimum mass, inclusive
     * @param float $maxMass
     *            Maximum mass, inclusive
     */
    public function __construct($minMass, $maxMass)
    {
        if (! is_float($minMass)) {
            throw new \InvalidArgumentException('Argument 1 must be of type float. Value is of type ' . gettype($minMass));
        }
        
        if (! is_float($maxMass)) {
            throw new \InvalidArgumentException('Argument 2 must be of type float. Value is of type ' . gettype($maxMass));
        }
        
        $this->minMass = $minMass;
        $this->maxMass = $maxMass;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Filter\AbstractFilter::isValidSpectra()
     */
    public function isValidSpectra(IonInterface $spectra)
    {
        if ($spectra->getMass() < $this->minMass) {
            return false;
        } elseif ($spectra->getMass() > $this->maxMass) {
            return false;
        }
        
        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Filter\AbstractFilter::isValidPeptide()
     */
    public function isValidPeptide(Peptide $peptide)
    {
        // Mass is calculated at request so must be cached
        $mass = $peptide->getMass();
        if ($mass < $this->minMass) {
            return false;
        } elseif ($mass > $this->maxMass) {
            return false;
        }
        
        return true;
    }
}
