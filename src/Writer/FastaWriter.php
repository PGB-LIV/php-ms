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
use pgb_liv\php_ms\Reader\HupoPsi\PsiVerb;

/**
 * A file writer class for creating FASTA files.
 * Generates data in PEFF only.
 *
 * @author Andrew Collins
 */
class FastaWriter
{

    const DECOY_COUNT = '_DecoyCount';

    const UNKNOWN_PLACEHOLDER = 'Unknown';

    private $tmpHandle = null;

    private $outputHandle = null;

    private $databases = array();

    private $conversion = null;

    /**
     * Creates a new instance of a Fasta Writer.
     *
     * @param string $path
     *            The path to write data to
     */
    public function __construct($path)
    {
        $this->tmpHandle = tmpfile();
        $this->outputHandle = fopen($path, 'w');
    }

    public function write(Protein $protein)
    {
        if (is_null($this->tmpHandle)) {
            throw new \BadMethodCallException('File handle is not open, write cannot be called after close');
        }

        $this->writeDescription($protein);
        $this->writeSequence($protein);
    }

    public function close()
    {
        if (is_null($this->tmpHandle)) {
            return;
        }

        $this->writeHeader();

        fseek($this->tmpHandle, 0);

        while ($line = fgets($this->tmpHandle)) {
            fwrite($this->outputHandle, $line);
        }

        fclose($this->outputHandle);
        fclose($this->tmpHandle);

        $this->outputHandle = null;
        $this->tmpHandle = null;
    }

    public function __destruct()
    {
        $this->close();
    }

    private function writeHeader()
    {
        $header = '# PEFF 1.0' . PHP_EOL;
        $header .= '# GeneralComment=Generated by phpMs (http://pgb.liv.ac.uk/phpMs)' . PHP_EOL;
        $header .= '# //' . PHP_EOL;

        foreach ($this->databases as $prefix => $database) {
            if ($prefix == '') {
                continue;
            }

            $header .= '# Prefix=' . $prefix . PHP_EOL;
            if ($database[self::DECOY_COUNT] == $database[PsiVerb::NUMBER_OF_ENTRIES]) {
                $database['Decoy'] = 'true';
            } elseif ($database[self::DECOY_COUNT] == 0) {
                $database['Decoy'] = 'false';
            }

            unset($database[self::DECOY_COUNT]);

            foreach ($database as $key => $value) {
                $header .= '# ' . $key . '=' . $value . PHP_EOL;
            }

            if (! is_null($this->conversion)) {
                $header .= '# Conversion=Converted from ' . $this->conversion . PHP_EOL;
            }

            $header .= '# //' . PHP_EOL;
        }

        fwrite($this->outputHandle, $header);
    }

    private function writeDescription(Protein $protein)
    {
        $this->recordDatabase($protein);

        $description = '>' . $protein->getDatabaseEntry()
            ->getDatabase()
            ->getPrefix() . ':' . $protein->getDatabaseEntry()->getUniqueIdentifier();

        if ($protein->getDescription()) {
            $description .= ' \PName=' . $protein->getDescription();
        }

        if (! is_null($protein->getGene())) {
            $gene = $protein->getGene();

            if ($gene->getSymbol()) {
                $description .= ' \GName=' . $gene->getSymbol();
            }
        }
        if (! is_null($protein->getOrganism())) {
            $organism = $protein->getOrganism();

            if (! is_null($organism->getName())) {
                $description .= ' \\' . PsiVerb::TAX_NAME . '=' . $protein->getOrganism()->getName();
            }

            if (! is_null($organism->getIdentifier())) {
                $description .= ' \\' . PsiVerb::NCBI_TAX_ID . '=' . $protein->getOrganism()->getIdentifier();
            }
        }

        if ($protein->getDatabaseEntry()->getSequenceVersion()) {
            $description .= ' \SV=' . $protein->getDatabaseEntry()->getSequenceVersion();
        }

        if ($protein->getDatabaseEntry()->getEntryVersion()) {
            $description .= ' \EV=' . $protein->getDatabaseEntry()->getEntryVersion();
        }

        if ($protein->getDatabaseEntry()->getEvidence()) {
            $description .= ' \PE=' . $protein->getDatabaseEntry()->getEvidence();
        }

        $description .= ' \Length=' . $protein->getLength();

        fwrite($this->tmpHandle, $description);
    }

    private function writeSequence(Protein $protein)
    {
        fwrite($this->tmpHandle, PHP_EOL . wordwrap($protein->getSequence(), 60, PHP_EOL, true) . PHP_EOL);
    }

    private function recordDatabase(Protein $protein)
    {
        $database = $protein->getDatabaseEntry()->getDatabase();
        $prefix = $database->getPrefix();

        $this->initialiseDatabase($prefix);

        if ($this->databases[$prefix][PsiVerb::DB_NAME] == self::UNKNOWN_PLACEHOLDER && ! is_null($database->getName())) {
            $this->setHeader($prefix, PsiVerb::DB_NAME, $database->getName());
        }

        if ($this->databases[$prefix][PsiVerb::DB_SOURCE] == self::UNKNOWN_PLACEHOLDER &&
            ! is_null($database->getSource())) {
            $this->setHeader($prefix, PsiVerb::DB_SOURCE, $database->getSource());
        }

        $this->databases[$prefix][PsiVerb::NUMBER_OF_ENTRIES] ++;

        if ($protein->isDecoy()) {
            $this->databases[$prefix][self::DECOY_COUNT] ++;
        }
    }

    private function initialiseDatabase($prefix)
    {
        if (isset($this->databases[$prefix])) {
            return;
        }

        $this->databases[$prefix] = array();
        $this->databases[$prefix][PsiVerb::DB_NAME] = self::UNKNOWN_PLACEHOLDER;
        $this->databases[$prefix][PsiVerb::DB_VERSION] = self::UNKNOWN_PLACEHOLDER;
        $this->databases[$prefix][PsiVerb::DB_SOURCE] = self::UNKNOWN_PLACEHOLDER;
        $this->databases[$prefix][PsiVerb::SEQUENCE_TYPE] = 'AA';
        $this->databases[$prefix][PsiVerb::NUMBER_OF_ENTRIES] = 0;
        $this->databases[$prefix][self::DECOY_COUNT] = 0;
    }

    public function setHeader($prefix, $key, $value)
    {
        $this->initialiseDatabase($prefix);

        $this->databases[$prefix][$key] = $value;
    }

    public function setConversionSource($sourceFile)
    {
        $this->conversion = $sourceFile;
    }

    public function isConversion()
    {
        return $this->conversion;
    }
}
