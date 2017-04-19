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
class Modification
{

    const TYPE_FIXED = 0;

    const TYPE_VARIABLE = 1;

    const POSITION_ANY = 'any';

    const POSITION_NTERM = 'N-term';

    const POSITION_CTERM = 'C-term';

    const POSITION_PROTEIN_NTERM = 'Prot-N-term';

    const POSITION_PROTEIN_CTERM = 'Prot-C-term';

    private $location;

    private $monoisotopicMass;

    private $averageMass;

    private $name;

    private $residues;

    private $type = Modification::TYPE_VARIABLE;

    private $position = Modification::POSITION_ANY;

    /**
     * Sets the location for this modification
     *
     * @param int $location
     *            The location to set this modification at
     * @throws \InvalidArgumentException If argument 1 is not of type int
     */
    public function setLocation($location)
    {
        if (! is_int($location)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be an int value. Valued passed is of type ' . gettype($location));
        }
        
        $this->location = $location;
    }

    /**
     * Gets the location of this modification
     *
     * @return int
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the monoisotopic mass for this modification
     *
     * @param float $mass
     *            The monoisotopic mass to set
     * @throws \InvalidArgumentException If argument 1 is not of type float
     */
    public function setMonoisotopicMass($mass)
    {
        if (! is_float($mass)) {
            throw new \InvalidArgumentException(
                'Argument 1 must be a float value. Valued passed is of type ' . gettype($mass));
        }
        
        $this->monoisotopicMass = $mass;
    }

    /**
     * Gets the monoisotopic mass
     *
     * @return float
     */
    public function getMonoisotopicMass()
    {
        return $this->monoisotopicMass;
    }

    public function setAverageMass($mass)
    {
        $this->averageMass = $mass;
    }

    public function getAverageMass()
    {
        return $this->averageMass;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Set residues for this modification
     *
     * @param array $residues
     *            Array of residues this modification may occur on
     * @throws \InvalidArgumentException If argument 1 is not of type float
     */
    public function setResidues(array $residues)
    {
        // TODO: Validate for * or chars
        if (empty($residues)) {
            throw new \InvalidArgumentException('Argument 1 must not be empty.');
        } else {
            foreach ($residues as $residue) {
                if (strlen($residue) != 1) {
                    throw new \InvalidArgumentException(
                        'Argument 1 must be an array of single char values. Value passed is of length ' .
                             strlen($residue));
                }
            }
        }
        
        // Force sort order
        sort($residues);
        
        // Force unique residue positions
        $this->residues = array_combine($residues, $residues);
    }

    /**
     * Gets the residues the modification is assosciated with
     *
     * @return array
     */
    public function getResidues()
    {
        return array_values($this->residues);
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isFixed()
    {
        return $this->type == Modification::TYPE_FIXED;
    }

    public function isVariable()
    {
        return $this->type == Modification::TYPE_VARIABLE;
    }

    /**
     * Sets the position this modification can occur on within the peptide or protein.
     * Default is 'Any'.
     *
     * @param int $position
     *            Position the modification can occur, see POSITION_ for list of options.
     * @throws \InvalidArgumentException If unknown position specified
     */
    public function setPosition($position)
    {
        switch ($position) {
            case Modification::POSITION_ANY:
            case Modification::POSITION_NTERM:
            case Modification::POSITION_CTERM:
            case Modification::POSITION_PROTEIN_NTERM:
            case Modification::POSITION_PROTEIN_CTERM:
                $this->position = $position;
                
                break;
            default:
                throw new \InvalidArgumentException('Postion must be any or terminus (see POSITION_XXXX)');
        }
    }

    public function getPosition()
    {
        return $this->position;
    }
}
