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

use pgb_liv\php_ms\Core\Entry\DatabaseEntry;
use pgb_liv\php_ms\Core\Gene;
use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Chromosome;
use pgb_liv\php_ms\Core\Transcript;
use pgb_liv\php_ms\Core\Database\EnsembleTDatabase;
use pgb_liv\php_ms\Core\Database\DatabaseFactory;

/**
 * FASTA entry parser to map Ensemble header to protein elements
 *
 * @author Andrew Collins
 */
class EnsembleFastaEntry implements FastaInterface
{

    public static function parseIdentifier($identifier)
    {
        $matches = null;
        $isMatched = preg_match('/^(ENSP|GENSCAN)([0-9]+).([0-9]+)$/', $identifier, $matches);

        if (! $isMatched) {
            throw new \InvalidArgumentException($identifier . ' is not Ensemble format');
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
        $protein = new Protein();

        $identifierParts = self::parseIdentifier($identifier);

        $dbEntry = null;

        $database = DatabaseFactory::getDatabase($identifierParts[0]);
        $dbEntry = new DatabaseEntry($database);
        $protein->setDatabaseEntry($dbEntry);

        $dbEntry->setUniqueIdentifier($identifierParts[1]);
        $dbEntry->setVersion($identifierParts[2]);

        $matches = array();
        preg_match_all('/(\w+):(.*?(?=\s\[|\s\w+:))/', $description, $matches);

        $keyValues = array();

        foreach ($matches[1] as $key => $value) {
            switch ($value) {
                case 'chromosome':
                case 'gene':
                case 'transcript':
                case 'gene_biotype':
                case 'transcript_biotype':
                case 'gene_symbol':
                case 'description':
                    $keyValues[$value] = $matches[2][$key];
                    break;
                default:
                    // Unknown
                    break;
            }
        }

        if (isset($keyValues['chromosome'])) {
            $chromosome = new Chromosome();
            $chromosome->setName($keyValues['chromosome']);

            $protein->setChromosome($chromosome);
        }

        if (isset($keyValues['gene_symbol'])) {
            $gene = Gene::getInstance($keyValues['gene_symbol']);
            $protein->setGene($gene);

            if (isset($keyValues['gene_biotype'])) {
                $gene->setType($keyValues['gene_biotype']);
            }
        }

        if (isset($keyValues['transcript'])) {
            $transcript = new Transcript();
            $transcriptEntry = new DatabaseEntry(EnsembleTDatabase::getInstance());
            $transcriptEntry->setUniqueIdentifier($keyValues['transcript']);
            $transcript->setDatabaseEntry($transcriptEntry);
            $protein->setTranscript($transcript);

            if (isset($keyValues['transcript_biotype'])) {
                $transcript->setType($keyValues['transcript_biotype']);
            }
        }

        if (isset($keyValues['description'])) {
            $protein->setDescription($keyValues['description']);
        }

        return $protein;
    }
}
