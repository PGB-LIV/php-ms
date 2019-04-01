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
namespace pgb_liv\php_ms\Writer;

use pgb_liv\php_ms\Core\Protein;

/**
 * A file writer class for creating FASTA files.
 * Generates data in PEFF only.
 *
 * @author Andrew Collins
 */
class FastaWriter
{

    private $fileHandle = null;

    /**
     * Creates a new instance of a Fasta Writer.
     *
     * @param string $path
     *            The path to write data to
     */
    public function __construct($path)
    {
        $this->fileHandle = fopen($path, 'w');

        $this->writeHeader();
    }

    public function getDescription(Protein $protein)
    {
        $description = '>' . $protein->getDatabaseEntries()[0]->getDatabase()->getPrefix() . ':' .
            $protein->getDatabaseEntries()[0]->getUniqueIdentifier();

        if ($protein->getDescription()) {
            $description .= ' \Pname=' . $protein->getDescription();
        }

        if (! is_null($protein->getGene())) {
            $gene = $protein->getGene();

            if ($gene->getSymbol()) {
                $description .= ' \Gname=' . $gene->getSymbol();
            }
        }
        if (! is_null($protein->getOrganism())) {
            $organism = $protein->getOrganism();

            if (! is_null($organism->getName())) {
                $description .= ' \TaxName=' . $protein->getOrganism()->getName();
            }

            if (! is_null($organism->getIdentifier())) {
                $description .= ' \NcbiTaxId=' . $protein->getOrganism()->getIdentifier();
            }
        }

        if ($protein->getDatabaseEntries()[0]->getVersion()) {

            $description .= ' \SV=' . $protein->getDatabaseEntries()[0]->getVersion();
        }

        if ($protein->getDatabaseEntries()[0]->getEvidence()) {

            $description .= ' \PE=' . $protein->getDatabaseEntries()[0]->getEvidence();
        }

        return $description;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getHeader()
    {
        return '# PEFF 1.0' . PHP_EOL;
    }

    public function write(Protein $protein)
    {
        if (is_null($this->fileHandle)) {
            throw new \BadMethodCallException('File handle is not open, write cannot be called after close');
        }

        $this->writeDescription($protein);
        $this->writeSequence($protein);
    }

    public function close()
    {
        if (! is_null($this->fileHandle)) {
            fclose($this->fileHandle);
            $this->fileHandle = null;
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    private function writeHeader()
    {
        $output = $this->getHeader();

        fwrite($this->fileHandle, $output);
    }

    private function writeDescription(Protein $protein)
    {
        $output = $this->getDescription($protein);

        fwrite($this->fileHandle, $output);
    }

    private function writeSequence(Protein $protein)
    {
        fwrite($this->fileHandle, PHP_EOL . wordwrap($protein->getSequence(), 60, PHP_EOL, true) . PHP_EOL);
    }
}
