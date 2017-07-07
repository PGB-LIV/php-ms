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
namespace pgb_liv\php_ms\Core\Database\Fasta;

use pgb_liv\php_ms\Core\Protein;

/**
 * A sequence Database Entry object.
 * By default the identifier, description
 * and sequence are available. Additional fields will be available if the
 * description has been able to be parsed in the case of FASTA data.
 *
 * @author Andrew Collins
 */
class UniprotFastaEntry extends DefaultFastaEntry
{

    protected static function generateFasta(Protein $protein)
    {
        $description = '>' . $protein->getUniqueIdentifier();
        
        $description .= ' ' . $protein->getName();
        $description .= ' OS=' . $protein->getOrganismName();
        
        if (! is_null($protein->getGeneName())) {
            $description .= ' GN=' . $protein->getGeneName();
        }
        
        $description .= ' PE=' . $protein->getProteinExistence();
        $description .= ' SV=' . $protein->getSequenceVersion();
        
        return $description;
    }

    protected static function parseProtein($identifier, $description, $sequence)
    {
        // Parse identifier
        $identifierParts = explode('|', $identifier, 3);
        
        $protein = new Protein();
        $protein->setSequence($sequence);
        $protein->setUniqueIdentifier($identifier);
        $protein->setDatabasePrefix($identifierParts[0]);
        $protein->setAccession($identifierParts[1]);
        $protein->setEntryName($identifierParts[2]);
        
        $protein->setDescription($description);
        
        // Parse description
        $osPosition = strpos($description, ' OS=');
        $protein->setName(substr($description, 0, $osPosition));
        
        $matches = array();
        preg_match_all('/([OS|GN|PE|SV]{2})=(.+?(?=\s(GN=|PE=|SV=)|$))/', $description, $matches);
        
        foreach ($matches[1] as $key => $value) {
            if ($value == 'OS') {
                $protein->setOrganismName($matches[2][$key]);
            } elseif ($value == 'GN') {
                $protein->setGeneName($matches[2][$key]);
            } elseif ($value == 'PE') {
                $protein->setProteinExistence($matches[2][$key]);
            } elseif ($value == 'SV') {
                $protein->setSequenceVersion($matches[2][$key]);
            }
        }
        
        return $protein;
    }
}
