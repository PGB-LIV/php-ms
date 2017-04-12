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

    private $location;

    private $mass;

    private $name;

    private $residues;

    private $type;

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setMass($mass)
    {
        $this->mass = $mass;
    }

    public function getMass()
    {
        return $this->mass;
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
    
    public function isFixed()
    {
        return $this->type == Modification::TYPE_FIXED;
    }
    
    public function isVariable()
    {
        return $this->type == Modification::TYPE_VARIABLE;
    }
}
