<?php
/**
 * Copyright 2018 University of Liverpool
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
namespace pgb_liv\php_ms\Core;

/**
 * Trait for providing access to setter/getter of monoisotopic and average mass.
 *
 * @author Andrew Collins
 */
trait MassTrait
{

    /**
     *
     * @var float
     */
    private $monoisotopicMass;

    /**
     *
     * @var float
     */
    private $averageMass;

    /**
     * Sets the monoisotopic mass for this object
     *
     * @param float $mass
     *            The monoisotopic mass to set
     * @throws \InvalidArgumentException If argument 1 is not of type float
     */
    public function setMonoisotopicMass($mass)
    {
        if (! is_float($mass) && ! is_int($mass)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be a float or integer value. Valued passed is of type ' . gettype($mass));
        }
        
        $this->monoisotopicMass = $mass;
    }

    /**
     * Gets the monoisotopic mass of this object
     *
     * @return float
     */
    public function getMonoisotopicMass()
    {
        return $this->monoisotopicMass;
    }

    /**
     * Sets the average mass for this object
     *
     * @param float $mass
     *            The average mass to set
     * @throws \InvalidArgumentException If argument 1 is not of type float
     */
    public function setAverageMass($mass)
    {
        if (! is_float($mass) && ! is_int($mass)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be a float or integer value. Valued passed is of type ' . gettype($mass));
        }
        
        $this->averageMass = $mass;
    }

    /**
     * Gets the average mass of this object
     *
     * @return float
     */
    public function getAverageMass()
    {
        return $this->averageMass;
    }
}
