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
namespace pgb_liv\php_ms\Core\Spectra;

use pgb_liv\php_ms\Core\Identification;

/**
 * Precursor Ion class.
 *
 * @author Andrew Collins
 */
class PrecursorIon implements IonInterface
{
    use IonTrait;

    /**
     * The retention time for this object
     *
     * @var float
     */
    private $retentionTime;

    /**
     * The title for this object
     *
     * @var string
     */
    private $title;

    /**
     * The scan number for this precursor
     *
     * @var int
     */
    private $scan;

    /**
     * A list of fragment ions associated with this precursor ion
     *
     * @var FragmentIon[]
     */
    private $fragmentIons = array();

    /**
     * A list of identifications associated with precursor ion
     *
     * @var Identification[]
     */
    private $identifications;

    /**
     * Sets the spectra elements retention time.
     *
     * @param float $retentionTime
     *            Column retention time in seconds.
     */
    public function setRetentionTime($retentionTime)
    {
        if (! (is_int($retentionTime) || is_float($retentionTime))) {
            throw new \InvalidArgumentException('Argument 1 must be of type int or float. Value is of type ' . gettype($retentionTime));
        }
        
        $this->retentionTime = $retentionTime;
    }

    /**
     * Gets the retention time in seconds
     *
     * @return float
     */
    public function getRetentionTime()
    {
        return $this->retentionTime;
    }

    /**
     * Sets the title name for this precursor
     *
     * @param string $title            
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Gets the title name for this precursor
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the scan number for this precursor
     *
     * @param int $scan
     *            Scan number to set
     * @throws \InvalidArgumentException
     */
    public function setScan($scan)
    {
        if (! (is_int($scan) || is_float($scan))) {
            throw new \InvalidArgumentException('Argument 1 must be of type int or float. Value is of type ' . gettype($scan));
        }
        
        $this->scan = $scan;
    }

    /**
     * Gets the scan number for this precursor
     *
     * @return int
     */
    public function getScan()
    {
        return $this->scan;
    }

    /**
     * Adds a fragment ion to this precursor
     *
     * @param FragmentIon $ion
     *            Fragment ion object to add
     */
    public function addFragmentIon(FragmentIon $ion)
    {
        $this->fragmentIons[] = $ion;
    }

    /**
     * Gets the fragment ions for this precursor
     *
     * @return FragmentIon[]
     */
    public function getFragmentIons()
    {
        return $this->fragmentIons;
    }

    /**
     * Clears the fragment ion list stored by this instance.
     */
    public function clearFragmentIons()
    {
        $this->fragmentIons = array();
    }

    /**
     * Adds an identification to this precursor
     *
     * @param Identification $identification
     *            Identification object to add
     */
    public function addIdentification(Identification $identification)
    {
        $this->identifications[] = $identification;
    }

    /**
     * Gets the list of identifications for this spectra object
     *
     * @return Identification[]
     */
    public function getIdentifications()
    {
        return $this->identifications;
    }

    /**
     * Clears the identification list stored by this instance.
     */
    public function clearIdentifications()
    {
        $this->identifications = array();
    }
}
