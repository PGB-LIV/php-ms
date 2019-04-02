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
namespace pgb_liv\php_ms\Core;

/**
 * Class to encapsulate tolerance values with their unit type.
 *
 * @author Andrew Collins
 */
class Tolerance
{

    const DA = 'Da';

    const PPM = 'ppm';

    const PSI_PPM_ACCESSION = 'UO:0000169';

    const PSI_DA_ACCESSION = 'UO:0000221';

    private $tolerance;

    private $unit;

    /**
     * Creates a new instance of this object with a specified tolerance value and unit type
     *
     * @param float $tolerance
     *            Tolerance numeric value
     * @param string $unit
     *            Tolerance unit type (See Tolerance::DA and Tolerance::PPM)
     * @throws \InvalidArgumentException If Argument 1 is not a float or argument 2 is not an acceptable unit type
     */
    public function __construct($tolerance, $unit)
    {
        if (! is_float($tolerance) && ! is_int($tolerance)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be a float or int value. Valued passed is of type ' . gettype($tolerance));
        }

        $this->tolerance = $tolerance;

        switch (strtolower($unit)) {
            case strtolower(Tolerance::PPM):
            case strtolower(Tolerance::PSI_PPM_ACCESSION):
                $this->unit = Tolerance::PPM;
                break;
            case strtolower(Tolerance::DA):
            case strtolower(Tolerance::PSI_DA_ACCESSION):
                $this->unit = Tolerance::DA;
                break;
            default:
                throw new \InvalidArgumentException(
                    'Argument 2 must equal "Da" or "ppm". Valued passed is "' . $unit . '"');
        }
    }

    /**
     * Gets the numeric tolerance value.
     *
     * @return float
     */
    public function getTolerance()
    {
        return $this->tolerance;
    }

    /**
     * Gets the tolerance unit type, Tolerance::PPM or Tolerance::DA
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Calculates the Dalton tolerance value of this mass using the set tolerance value
     *
     * @param float $mass
     *            Mass to calculate tolerance for
     * @return float Tolerance value
     */
    public function getDaltonDelta($mass)
    {
        if ($this->unit == Tolerance::DA) {
            return $this->tolerance;
        }

        $toleranceRatio = $this->tolerance / 1000000;

        return $mass * $toleranceRatio;
    }

    /**
     * Calculates the ppm tolerance value of this mass using the set tolerance value
     *
     * @param float $mass
     *            Mass to calculate tolerance for
     * @return float Tolerance value
     */
    public function getPpmDelta($mass)
    {
        if ($this->unit == Tolerance::PPM) {
            return $this->tolerance;
        }

        $toleranceRatio = $this->tolerance / $mass;

        return $toleranceRatio * 1000000;
    }

    /**
     * Test if the observed and expected values are within the accepted tolerance
     *
     * @param float $observed
     *            The observed value
     * @param float $expected
     *            The expected value
     * @return boolean
     */
    public function isTolerable($observed, $expected)
    {
        $diff = 0;
        if ($this->unit == Tolerance::DA) {
            $diff = abs($observed - $expected);
        } else {
            $diff = abs(Tolerance::getDifferencePpm($observed, $expected));
        }

        if ($diff > $this->tolerance) {
            return false;
        }

        return true;
    }

    /**
     * Gets the ppm difference for the observed and expected value
     *
     * @param float $observed
     *            The observed value
     * @param float $expected
     *            The expected value
     * @return float
     */
    public static function getDifferencePpm($observed, $expected)
    {
        return (($observed - $expected) / $expected) * 1000000;
    }
}
