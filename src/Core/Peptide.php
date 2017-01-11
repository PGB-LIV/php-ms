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
 * Abstract database entry object, by default the identifier, description and sequence are required.
 * Extending classes may use the additional fields.
 *
 * @author Andrew Collins
 */
class Peptide
{

    const HYDROGEN_MASS = 1.007825;

    const OXYGEN_MASS = 15.994915;

    private $sequence;

    private $protein;

    private $positionStart;

    private $positionEnd;

    private $missedCleavageCount;

    public function __construct($sequence)
    {
        $this->sequence = $sequence;
    }

    public function getSequence()
    {
        return $this->sequence;
    }

    public function setPositionStart($position)
    {
        $this->positionStart = $position;
    }

    public function setPositionEnd($position)
    {
        $this->positionEnd = $position;
    }

    public function setMissedCleavageCount($count)
    {
        $this->missedCleavageCount = $count;
    }

    public function getMissedCleavageCount()
    {
        return $this->missedCleavageCount;
    }

    public function setProtein(Protein $protein)
    {
        $this->protein = $protein;
    }

    public function getProtein()
    {
        return $this->protein;
    }

    public function getPositionStart()
    {
        return $this->positionStart;
    }

    public function getPositionEnd()
    {
        return $this->positionEnd;
    }

    public function getLength()
    {
        return strlen($this->getSequence());
    }

    /**
     * Calculates the neutral mass of a sequence
     *
     * @param string $sequence
     *            The peptide sequence to calculate for
     * @return The neutral mass of the sequence
     */
    public function calculateMass()
    {
        $acids = str_split($this->getSequence(), 1);
        
        $mass = static::HYDROGEN_MASS + static::HYDROGEN_MASS + static::OXYGEN_MASS;
        foreach ($acids as $acid) {
            $mass += AminoAcidMono::getMonoisotopicMass($acid);
        }
        
        return $mass;
    }
}
