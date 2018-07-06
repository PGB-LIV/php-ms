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

use pgb_liv\php_ms\Constant\PhysicalConstants;

/**
 * Trait for providing access to setter/getter of monoisotopic and average mass-to-charge values.
 * Does not store an mass-to-charge ratio but calculates on demand from neutral mass and charge values.
 *
 * @author Andrew Collins
 */
trait ChargedMassTrait
{
    use MassTrait;

    /**
     * The charge value for this instance
     *
     * @var int
     */
    private $charge;

    /**
     * Sets the monoisotopic mass-to-charge ratio for this instance.
     *
     * @param float $massCharge
     *            The mass-to-charge ratio to set to
     * @param int $charge
     *            The charge associated with the $massCharge
     * @throws \InvalidArgumentException If $mz is not a valid floating point value
     */
    public function setMonoisotopicMassCharge($massCharge, $charge)
    {
        $this->setMonoisotopicMass($this->getNeutralMass($massCharge, $charge));
        $this->setCharge($charge);
    }

    /**
     * Sets the average mass-to-charge ratio for this instance
     *
     * @param float $massCharge
     *            The mass-to-charge ratio to set to
     * @param int $charge
     *            The charge associated with the $massCharge
     * @throws \InvalidArgumentException If $mz is not a valid floating point value
     */
    public function setAverageMassCharge($massCharge, $charge)
    {
        $this->setAverageMass($this->getNeutralMass($massCharge, $charge));
        $this->setCharge($charge);
    }

    /**
     * Gets the monoisotopic mass-to-charge ratio for this instance
     *
     * @return float
     */
    public function getMonoisotopicMassCharge()
    {
        return $this->getMassCharge($this->getMonoisotopicMass(), $this->charge);
    }

    /**
     * Gets the average mass-to-charge ratio for this ion
     *
     * @return float
     */
    public function getAverageMassCharge()
    {
        return $this->getMassCharge($this->getAverageMass(), $this->charge);
    }

    /**
     * Sets the charge of this instance
     *
     * @param int $charge
     *            The positive or negative charge to set
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;
    }

    /**
     * Gets the charge value associated with this instance
     *
     * @return int charge value
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Gets the mass-to-charge value for the specified mass and charge
     *
     * @param float $mass
     * @param int $charge
     * @return float
     */
    public static function getMassCharge($mass, $charge)
    {
        if (! is_float($mass)) {
            throw new \InvalidArgumentException('Argument 1 must be of type float. Value is of type ' . gettype($mass));
        }

        if (! is_int($charge)) {
            throw new \InvalidArgumentException('Argument 2 must be of type int. Value is of type ' . gettype($charge));
        }

        return ($mass + ($charge * PhysicalConstants::PROTON_MASS)) / $charge;
    }

    /**
     * gets the neutral mass for the specified mass-to-charge ratio and charge
     *
     * @param float $massCharge
     * @param int $charge
     * @throws \InvalidArgumentException
     * @return float
     */
    public static function getNeutralMass($massCharge, $charge)
    {
        if (! is_float($massCharge)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type float. Value is of type ' . gettype($massCharge));
        }

        if (! is_int($charge)) {
            throw new \InvalidArgumentException('Argument 2 must be of type int. Value is of type ' . gettype($charge));
        }

        return ($massCharge * $charge) - (PhysicalConstants::PROTON_MASS * $charge);
    }
}
