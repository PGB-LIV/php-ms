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
 * Creates an instance of a filter than can be used with a list to
 * remove those which do not fit the criteria.
 *
 * @author Andrew Collins
 */
class FilterRetentionTime extends AbstractFilter
{

    /**
     * Minimum retention time, inclusive
     *
     * @var double
     */
    private $minRetentionTime;

    /**
     * Maximum retention time, inclusive
     *
     * @var double
     */
    private $maxRetentionTime;

    /**
     * Creates a new instance with the specified minimum and maximum retention time values.
     *
     * @param double $minRetentionTime
     *            Minimum retention time, inclusive
     * @param double $maxRetentionTime
     *            Maximum retention time, inclusive
     */
    public function __construct($minRetentionTime, $maxRetentionTime = null)
    {
        if (! is_float($minRetentionTime) && ! is_int($minRetentionTime) && ! is_null($minRetentionTime)) {
            throw new \InvalidArgumentException('Argument 1 must be type numeric or null. Value is of type ' . gettype($minRetentionTime));
        }
        
        if (! is_float($maxRetentionTime) && ! is_int($maxRetentionTime) && ! is_null($maxRetentionTime)) {
            throw new \InvalidArgumentException('Argument 2 must be of type numeric or null. Value is of type ' . gettype($maxRetentionTime));
        }
        
        $this->minRetentionTime = $minRetentionTime;
        $this->maxRetentionTime = $maxRetentionTime;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Filter\AbstractFilter::isValidSpectra()
     */
    public function isValidSpectra(IonInterface $spectra)
    {
        if (! is_null($this->minRetentionTime) && $spectra->getRetentionTime() < $this->minRetentionTime) {
            return false;
        }
        
        if (! is_null($this->maxRetentionTime) && $spectra->getRetentionTime() > $this->maxRetentionTime) {
            return false;
        }
        
        return true;
    }
}
