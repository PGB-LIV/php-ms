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
namespace pgb_liv\php_ms\Search\Parameters;

/**
 * Encapsulation class for MS-GF+ modification elements
 *
 * @author Andrew Collins
 */
class MsgfPlusModification
{

    const MOD_TYPE_FIXED = 'fix';

    const MOD_TYPE_VARIABLE = 'opt';

    const POSITION_ANY = 'any';

    const POSITION_NTERM = 'N-term';

    const POSITION_CTERM = 'C-term';

    const POSITION_PROTEIN_NTERM = 'Prot-N-term';

    const POSITION_PROTEIN_CTERM = 'Prot-C-term';

    private $mass;

    private $residues;

    private $modificationType;

    private $position;

    private $name;

    public function __construct($mass, $residues, $modType, $position, $name)
    {
        // TODO: Composition string support
        if (! is_float($mass)) {
            throw new \InvalidArgumentException('Argument 1 must be a float. Composition strings currently no support');
        }
        
        $this->mass = $mass;
        
        if (! preg_match('/^([A-Z]+|\*)$/', $residues)) {
            throw new \InvalidArgumentException('Argument 2 must be a valid string of amino acids or *');
        }
        
        // Save as uppercase
        $this->residues = strtoupper($residues);
        
        if ($modType != MsgfPlusModification::MOD_TYPE_FIXED && $modType != MsgfPlusModification::MOD_TYPE_VARIABLE) {
            throw new \InvalidArgumentException('Argument 3 must be either "fix" (Fixed) or "opt" (Variable)');
        }
        
        $this->modificationType = $modType;
        
        switch ($position) {
            case MsgfPlusModification::POSITION_ANY:
            case MsgfPlusModification::POSITION_NTERM:
            case MsgfPlusModification::POSITION_CTERM:
            case MsgfPlusModification::POSITION_PROTEIN_NTERM:
            case MsgfPlusModification::POSITION_PROTEIN_CTERM:
                $this->position = $position;
                
                break;
            default:
                throw new \InvalidArgumentException('Postion must be any or terminus (see POSITION_XXXX)');
        }
        
        // TODO: Validate against PSI?
        $this->name = $name;
    }

    public function getMass()
    {
        return $this->mass;
    }

    public function getResidues()
    {
        return $this->residues;
    }

    public function getModificationType()
    {
        return $this->modificationType;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function createModificationFile(array $modifications, $numMods = 2)
    {
        // TODO:
        // All array must be this class
        // NumMods must be uint
        $data = 'NumMods=' . $numMods . PHP_EOL;
        
        foreach ($modifications as $modification) {
            $entry = $modification->getMass() . ',';
            $entry .= $modification->getResidues() . ',';
            $entry .= $modification->getModificationType() . ',';
            $entry .= $modification->getPosition() . ',';
            $entry .= $modification->getName();
            
            $data .= $entry . PHP_EOL;
        }
        
        $modFile = tempnam(sys_get_temp_dir(), 'phpMs') . '.txt';
        
        file_put_contents($modFile, $data);
        
        return $modFile;
    }
}
