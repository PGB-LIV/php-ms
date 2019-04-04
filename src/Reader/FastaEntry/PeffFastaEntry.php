<?php
/**
 * Copyright 2019 University of Liverpool
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
namespace pgb_liv\php_ms\Reader\FastaEntry;

use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Modification;
use pgb_liv\php_ms\Core\Entry\DatabaseEntry;
use pgb_liv\php_ms\Core\Gene;
use pgb_liv\php_ms\Core\Organism;
use pgb_liv\php_ms\Core\Database\DatabaseFactory;
use pgb_liv\php_ms\Reader\HupoPsi\PsiVerb;

/**
 * FASTA entry parser to map generic PEFF headers to protein elements
 *
 * @author Andrew Collins
 */
class PeffFastaEntry implements FastaInterface
{

    public static function parseIdentifier($identifier)
    {
        $matches = null;
        $isMatched = preg_match('/^(\w+):([\w-]+)$/', $identifier, $matches);

        if (! $isMatched) {
            throw new \InvalidArgumentException($identifier . ' is not PEFF format');
        }

        return array(
            $matches[1],
            $matches[2]
        );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getProtein($identifier, $description)
    {
        $protein = new Protein();

        // Parse identifier
        $identifierParts = $this->parseIdentifier($identifier);
        $database = DatabaseFactory::getDatabase($identifierParts[0]);
        $dbEntry = new DatabaseEntry($database);
        $protein->setDatabaseEntry($dbEntry);

        $dbEntry->setUniqueIdentifier($identifierParts[1]);

        // Parse description
        $matches = null;
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
        if (isset($attributes[PsiVerb::NCBI_TAX_ID])) {
            $organism = Organism::getInstance($attributes[self::NCBI_TAX_ID]);
            $protein->setOrganism($organism);
        }

        if (isset($attributes[PsiVerb::TAX_NAME])) {
            if (! $protein->getOrganism()) {
                $protein->setOrganism(new Organism());
            }

            $protein->getOrganism()->setName($attributes[self::TAX_NAME]);
        }

        foreach ($attributes as $key => $value) {
            switch ($key) {
                case 'DbUniqueId':
                    $protein->setAccession($value);
                    break;
                case 'GName':
                    $gene = Gene::getInstance($value);
                    $protein->setGene($gene);
                    break;
                case 'SV':
                    $protein->getDatabaseEntry()->setSequenceVersion($value);
                    break;
                case 'EV':
                    $protein->getDatabaseEntry()->setEntryVersion($value);
                    break;
                case 'PE':
                    $protein->getDatabaseEntry()->setEvidence($value);
                    break;
                case 'PName':
                    $protein->setDescription($value);
                    break;
                case 'ModRes':
                case 'ModResPsi':
                case 'ModResUnimod':
                    $modifications = self::parseModifications($value);
                    $protein->addModifications($modifications);
                    break;
                case PsiVerb::NCBI_TAX_ID:
                case PsiVerb::TAX_NAME:
                    // Safe to ignore - already handled
                    break;
                case 'Length':
                case 'VariantSimple ':
                case 'VariantComplex':
                case 'Processed':
                    // Not supported
                    break;
                default:
                    // Not supported
                    break;
            }
        }
    }

    /**
     * Parses ModResPsi/ModResUnimod element and returns the parsed modifications
     *
     * @param string $value
     *            The ModResXXX value
     * @return Modification[]
     */
    private static function parseModifications($value)
    {
        $modifications = array();
        $matches = null;
        preg_match_all('/\(([^()]|(?R))*\)/', $value, $matches);

        foreach ($matches[0] as $modString) {
            $elements = null;
            preg_match('/\(([0-9,]+)\|([A-Z]+:[0-9]+)?\|(.*)\|?(.+)?\)/', $modString, $elements);

            $locations = explode(',', $elements[1]);
            foreach ($locations as $location) {
                $modification = new Modification();
                $modification->setLocation((int) $location);
                $modification->setName($elements[3]);
                $modification->setAccession($elements[2]);

                $modifications[] = $modification;
            }
        }

        return $modifications;
    }
}
