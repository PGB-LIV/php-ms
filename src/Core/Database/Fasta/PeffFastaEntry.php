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
use pgb_liv\php_ms\Core\Modification;

/**
 * A sequence Database Entry object.
 * By default the identifier, description
 * and sequence are available. Additional fields will be available if the
 * description has been able to be parsed in the case of FASTA data.
 *
 * @author Andrew Collins
 */
class PeffFastaEntry extends DefaultFastaEntry
{

    protected static function parseProtein($identifier, $description, $sequence)
    {
        // Parse identifier
        $identifierParts = explode(':', $identifier, 3);
        
        $protein = new Protein();
        $protein->setUniqueIdentifier($identifier);
        $protein->setSequence($sequence);
        $protein->setDatabasePrefix($identifierParts[0]);
        $protein->setAccession($identifierParts[1]);
        
        $protein->setDescription($description);
        
        // Parse description
        preg_match_all('/\\\\(\\w+)=(.+?(?=\\\\|$))/', $description, $matches);
        
        $attr = array();
        foreach ($matches[1] as $index => $key) {
            $attr[$key] = $matches[2][$index];
        }
        
        foreach ($attr as $key => $value) {
            switch ($key) {
                case 'DbUniqueId':
                    $protein->setAccession($value);
                    break;
                case 'Gname':
                    $protein->setGeneName($value);
                    break;
                case 'SV':
                    $protein->setSequenceVersion($value);
                    break;
                case 'PE':
                    $protein->setProteinExistence($value);
                    break;
                case 'Pname':
                    $protein->setProteinName($value);
                    break;
                case 'TaxName':
                    $protein->setOrganismName($value);
                    break;
                case 'ModResPsi':
                    $modifications = PeffFastaEntry::parseModifications($value);
                    $protein->addModifications($modifications);
                    break;
                default:
                    // TODO: Not yet supported fields
                    break;
            }
        }
        
        return $protein;
    }

    /**
     * Parses ModResPsi element and returns the parsed modifications
     *
     * @param string $value
     *            The ModResXXX value
     * @return Modification[]
     */
    private static function parseModifications($value)
    {
        preg_match_all('/\(([0-9]+)\|(MOD:[0-9]+)\)/', $value, $matches);
        
        $modifications = array();
        foreach ($matches[1] as $key => $location) {
            $modification = new Modification();
            $modification->setLocation((int) $location);
            $modification->setName($matches[2][$key]);
            
            $modifications[] = $modification;
        }
        
        return $modifications;
    }

    protected static function generateFasta(Protein $protein)
    {
        $description = '>' . $protein->getDatabasePrefix() . ':' . $protein->getAccession();
        
        if ($protein->getAccession()) {
            $description .= ' /DbUniqueId=' . $protein->getAccession();
        }
        
        if ($protein->getEntryName()) {
            $description .= ' /CC=' . $protein->getEntryName();
        }
        
        if ($protein->getProteinName()) {
            $description .= ' /Pname=' . $protein->getProteinName();
        }
        
        if ($protein->getGeneName()) {
            $description .= ' /Gname=' . $protein->getGeneName();
        }
        
        if ($protein->getOrganismName()) {
            $description .= ' /TaxName=' . $protein->getOrganismName();
        }
        
        if ($protein->getSequenceVersion()) {
            $description .= ' /SV=' . $protein->getSequenceVersion();
        }
        
        if ($protein->getProteinExistence()) {
            $description .= ' /PE=' . $protein->getProteinExistence();
        }
        
        return $description;
    }
}
