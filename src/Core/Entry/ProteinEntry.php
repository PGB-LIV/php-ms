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
namespace pgb_liv\php_ms\Core\Entry;

use pgb_liv\php_ms\Core\Protein;

/**
 * A protein entity object for adding references to a protein object.
 * Allows items such as peptides to link to specific sections of a protein string
 *
 * @author Andrew Collins
 */
class ProteinEntry
{

    /**
     * The protein object to link
     *
     * @var Protein
     */
    private $protein;

    /**
     * The start position of object to sequence
     *
     * @var int
     */
    private $start;

    /**
     * The end position of object to sequence
     *
     * @var int
     */
    private $end;

    /**
     * Creates a new ProteinEntity object with the specified protein
     *
     * @param Protein $protein
     *            The protein object that will be referenced by the user of this instance
     */
    public function __construct(Protein $protein)
    {
        $this->protein = $protein;
    }

    /**
     * Gets the encapsulated protein
     *
     * @return Protein
     */
    public function getProtein()
    {
        return $this->protein;
    }

    /**
     * Sets the start position of the parent object inside the protein
     *
     * @param int $position
     * @throws \InvalidArgumentException If argument is non-integer
     */
    public function setStart($position)
    {
        if (! is_int($position)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type integer. Argument type is ' . gettype($position));
        }

        $this->start = $position;
    }

    /**
     * Gets the start position of the parent object inside the protein
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Sets the end position of the parent object inside the protein
     *
     * @param int $position
     * @throws \InvalidArgumentException If argument is non-integer
     */
    public function setEnd($position)
    {
        if (! is_int($position)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type integer. Argument type is ' . gettype($position));
        }

        $this->end = $position;
    }

    /**
     * Gets the end position of the parent object inside the protein
     *
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }
}
