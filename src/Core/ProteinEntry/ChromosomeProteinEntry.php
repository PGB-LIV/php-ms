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
namespace pgb_liv\php_ms\Core\ProteinEntry;

use pgb_liv\php_ms\Core\Protein;

/**
 * A protein entity object for adding references to a protein object.
 * Allows items such as peptides to link to specific sections of a protein string
 *
 * @author Andrew Collins
 */
class ChromosomeProteinEntry extends ProteinEntry
{

    /**
     * Chromosome start positions
     *
     * @var array
     */
    private $starts = array();

    /**
     * Chromosome end position
     *
     * @var int
     */
    private $end;

    /**
     * Chromosome block count
     *
     * @var int
     */
    private $blockCount;

    /**
     * Chromosome block sizes
     *
     * @var array
     */
    private $blockSizes;

    /**
     * Gets the end position of the parent object inside the protein
     *
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    public function getChromosomePositionsStart()
    {
        return $this->starts;
    }

    public function getChromosomePositionEnd()
    {
        return $this->end;
    }

    public function getChromosomeBlockCount()
    {
        return $this->blockCount;
    }

    public function getChromosomeBlockSizes()
    {
        return $this->blockSizes;
    }

    public function setChromosomePositionsStart(array $positions)
    {
        foreach ($positions as $position) {
            if (! is_int($position)) {
                throw new \InvalidArgumentException(
                    'Argument 1 must be an array of type integer. Argument type is ' . gettype($position));
            }
        }
        
        $this->starts = $positions;
    }

    public function setChromosomePositionEnd($position)
    {
        if (! is_int($position)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type integer. Argument type is ' . gettype($position));
        }
        
        $this->end = $position;
    }

    public function setChromosomeBlockCount($count)
    {
        if (! is_int($count)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type integer. Argument type is ' . gettype($count));
        }
        
        $this->blockCount = $count;
    }

    public function setChromosomeBlockSizes($sizes)
    {
        if (! is_int($sizes)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type integer. Argument type is ' . gettype($sizes));
        }
        
        $this->blockSizes = $sizes;
    }
}
