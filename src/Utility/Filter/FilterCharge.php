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

use pgb_liv\php_ms\Core\Spectra\IonInterface;

/**
 * Creates an instance of a spectra filter than can be used with a list of spectra to
 * remove those which do not it the criteria.
 *
 * @author Andrew Collins
 */
class FilterCharge extends AbstractFilter
{

    /**
     * Minimum spectra charge, inclusive
     *
     * @var integer
     */
    private $minCharge = 1;

    /**
     * Maximum spectra charge, inclusive
     *
     * @var integer
     */
    private $maxCharge = 3;

    /**
     * Creates a new instance with the specified minimum and maximum charge values.
     *
     * @param int $minCharge
     *            Minimum spectra charge, inclusive
     * @param int $maxCharge
     *            Maximum spectra charge, inclusive
     */
    public function __construct($minCharge, $maxCharge)
    {
        if (! is_int($minCharge)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int. Value is of type ' . gettype($minCharge));
        }
        
        if (! is_int($maxCharge)) {
            throw new \InvalidArgumentException(
                'Argument 2 must be of type int. Value is of type ' . gettype($maxCharge));
        }
        
        $this->minCharge = $minCharge;
        $this->maxCharge = $maxCharge;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Filter\AbstractFilter::isValidSpectra()
     */
    public function isValidSpectra(IonInterface $spectra)
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
