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
class PeffFastaEntry implements FastaInterface
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Core\Database\Fasta\FastaInterface::getHeader()
     */
    public function getHeader()
    {
        return '# PEFF 1.0draft24' . PHP_EOL;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Core\Database\Fasta\FastaInterface::getDescription()
     */
    public function getDescription(Protein $protein)
    {
        $description = '>' . $protein->getDatabasePrefix() . ':' . $protein->getAccession();
        
        if ($protein->getAccession()) {
            $description .= ' \DbUniqueId=' . $protein->getAccession();
        }
        
        if ($protein->getEntryName()) {
            $description .= ' \CC=' . $protein->getEntryName();
        }
        
        if ($protein->getName()) {
            $description .= ' \Pname=' . $protein->getName();
        }
        
        if ($protein->getGeneName()) {
            $description .= ' \Gname=' . $protein->getGeneName();
        }
        
        if ($protein->getOrganismName()) {
            $description .= ' \TaxName=' . $protein->getOrganismName();
        }
        
        if ($protein->getSequenceVersion()) {
            $description .= ' \SV=' . $protein->getSequenceVersion();
        }
        
        if ($protein->getProteinExistence()) {
            $description .= ' \PE=' . $protein->getProteinExistence();
        }
        
        return $description;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Core\Database\Fasta\FastaInterface::getProtein()
     */
    public function getProtein($identifier, $description, $sequence)
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
        preg_match_all('/\\\\(\\w+)=(.+?(?= \\\\|$))/', $description, $matches);
        
        $attributes = array();
        foreach ($matches[1] as $index => $key) {
            $attributes[$key] = $matches[2][$index];
        }
        
        $this->parseAttributes($protein, $attributes);
        
        return $protein;
    }

    /**
     * Parses the attribute array and inputs the data into the protein
     *
     * @param Protein $protein
     *            Object to input values to
     * @param array $attributes
     *            Array to read from
     * @return void
     */
    private function parseAttributes(Protein $protein, array $attributes)
    {
        foreach ($attributes as $key => $value) {
            switch (strtolower($key)) {
                case 'dbuniqueid':
                    $protein->setAccession($value);
                    break;
                case 'cc':
                    $protein->setEntryName($value);
                    break;
                case 'gname':
                    $protein->setGeneName($value);
                    break;
                case 'sv':
                    $protein->setSequenceVersion($value);
                    break;
                case 'pe':
                    $protein->setProteinExistence($value);
                    break;
                case 'pname':
                    $protein->setName($value);
                    break;
                case 'taxname':
                    $protein->setOrganismName($value);
                    break;
                case 'modrespsi':
                    $modifications = PeffFastaEntry::parseModifications($value);
                    $protein->addModifications($modifications);
                    break;
                default:
                    // Invalid or not yet supported fields
                    break;
            }
        }
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
}
