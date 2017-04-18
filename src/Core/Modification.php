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

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setMonoisotopicMass($mass)
    {
        $this->monoisotopicMass = $mass;
    }

    public function getMonoisotopicMass()
    {
        return $this->monoisotopicMass;
    }

    public function setAverageMass($mass)
    {
        $this->$averageMass = $mass;
    }

    public function getAverageMass()
    {
        return $this->$averageMass;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setResidues($residues)
    {
        // TODO: Should be array of single chars?
        $this->residues = $residues;
    }

    public function getResidues()
    {
        return $this->residues;
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
