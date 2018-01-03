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
    private $minCharge;

    /**
     * Maximum spectra charge, inclusive
     *
     * @var integer
     */
    private $maxCharge;

    /**
     * Creates a new instance with the specified minimum and maximum charge values.
     * Specify null for minimum or maximum for no limit.
     *
     * @param int $minCharge
     *            Minimum spectra charge, inclusive
     * @param int $maxCharge
     *            Maximum spectra charge, inclusive
     */
    public function __construct($minCharge, $maxCharge = null)
    {
        if (! is_int($minCharge) && ! is_null($minCharge)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int or null. Value is of type ' . gettype($minCharge));
        }
        
        if (! is_int($maxCharge) && ! is_null($maxCharge)) {
            throw new \InvalidArgumentException(
                'Argument 2 must be of type int or null. Value is of type ' . gettype($maxCharge));
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
        if (! is_null($this->minCharge) && $spectra->getCharge() < $this->minCharge) {
            return false;
        }
        
        if (! is_null($this->maxCharge) && $spectra->getCharge() > $this->maxCharge) {
            return false;
        }
        
        return true;
    }
}
