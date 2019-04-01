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
use pgb_liv\php_ms\Core\Entry\DatabaseEntry;
use pgb_liv\php_ms\Core\Organism;
use pgb_liv\php_ms\Core\Gene;
use pgb_liv\php_ms\Core\Database\UniProtSpDatabase;
use pgb_liv\php_ms\Core\Database\UniProtTrDatabase;

/**
 * FASTA entry parser to map UniProt header to protein elements
 *
 * @author Andrew Collins
 */
class UniProtFastaEntry implements FastaInterface
{

    public static function parseIdentifier($identifier)
    {
        $matches = null;
        $isMatched = preg_match('/^(sp|tr)\|(\w+)\|(\w+)$/', $identifier, $matches);

        if (! $isMatched) {
            throw new \InvalidArgumentException($identifier . ' is not UniProt format');
        }

        return array(
            $matches[1],
            $matches[2],
            $matches[3]
        );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getProtein($identifier, $description)
    {
        // Parse identifier
        $identifierParts = $this->parseIdentifier($identifier);

        $protein = new Protein();

        $dbEntry = null;

        if ($identifierParts[0] == 'sp') {
            $dbEntry = new DatabaseEntry(UniProtSpDatabase::getInstance());
        } elseif ($identifierParts[0] == 'tr') {
            $dbEntry = new DatabaseEntry(UniProtTrDatabase::getInstance());
        }
        $protein->addDatabaseEntry($dbEntry);

        $dbEntry->setUniqueIdentifier($identifierParts[1]);
        $dbEntry->setName($identifierParts[2]);

        // Parse description
        $osPosition = strpos($description, ' OS=');
        $protein->setDescription(substr($description, 0, $osPosition));

        $matches = array();
        preg_match_all('/(\w{2})=([\w\s]+)(?![\w=])/', $description, $matches);

        $keyValues = array();

        foreach ($matches[1] as $key => $value) {
            switch ($value) {
                case 'OS':
                case 'OX':
                case 'GN':
                case 'PE':
                case 'SV':
                    $keyValues[$value] = trim($matches[2][$key]);
                    break;
                default:
                    // Unknown
                    break;
            }
        }

        if (isset($keyValues['OX'])) {
            $organism = Organism::getInstance($keyValues['OX']);
            $protein->setOrganism($organism);

            if (isset($keyValues['OS'])) {
                $organism->setName($keyValues['OS']);
            }
        }

        if (isset($keyValues['GN'])) {
            $gene = Gene::getInstance($keyValues['GN']);
            $protein->setGene($gene);
        }

        if (isset($keyValues['PE'])) {
            $dbEntry->setEvidence($keyValues['PE']);
        }

        if (isset($keyValues['SV'])) {
            $dbEntry->setVersion($keyValues['SV']);
        }

        return $protein;
    }
}
