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
namespace pgb_liv\php_ms\Reader;

use Exception;
use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Reader\FastaEntry\FastaInterface;
use pgb_liv\php_ms\Reader\FastaEntry\PeffFastaEntry;
use pgb_liv\php_ms\Reader\FastaEntry\DefaultFastaEntry;
use pgb_liv\php_ms\Reader\FastaEntry\FastaEntryFactory;

/**
 * A FASTA parser that creates a new iterable object that will return a database
 * entry on each iteration.
 *
 * @author Andrew Collins
 */
class FastaReader implements \Iterator
{

    private $filePath;

    private $fileHandle;

    private $filePeek;

    /**
     * The current protein that will be returned by the current() method
     *
     * @var Protein
     */
    private $current;

    private $key = 0;

    /**
     * The FASTA format engine to use for parsing
     *
     * @var FastaInterface
     */
    private $format;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Iterator::current()
     * @return Protein
     */
    public function current()
    {
        return $this->current;
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        $this->current = null;
        if (! feof($this->fileHandle)) {
            try {
                $this->current = $this->parseEntry();
            } catch (\InvalidArgumentException $ex) {
                $this->next();
            }
        }
    }

    public function rewind()
    {
        // Reset file parsing to start
        if ($this->fileHandle != null) {
            fclose($this->fileHandle);
        }

        $this->fileHandle = fopen($this->filePath, 'r');

        if (stripos($this->peekLine(), '# PEFF') === 0) {
            $this->format = new PeffFastaEntry();
        }

        $this->key = 0;
        $this->next();
    }

    public function valid()
    {
        if ($this->current instanceof Protein) {
            return true;
        }

        return false;
    }

    /**
     * Gets the next line and increments the file iterator
     *
     * @return string The next line in the file
     */
    private function getLine()
    {
        if ($this->filePeek == null) {
            return fgets($this->fileHandle);
        }

        $ret = $this->filePeek;
        $this->filePeek = null;

        return $ret;
    }

    /**
     * Gets the next line, though does not move the file iterator
     *
     * @return string The next line in the file
     */
    private function peekLine()
    {
        if ($this->filePeek == null) {
            $this->filePeek = fgets($this->fileHandle);
        }

        return $this->filePeek;
    }

    /**
     * Parses the current chunk into a Protein object
     *
     * @return Protein
     */
    private function parseEntry()
    {
        // Scan to first entry
        do {
            $line = trim($this->peekLine());

            if (strpos($line, '>') === 0) {
                break;
            }
        } while ($this->getLine());

        $identifier = '';
        while ($line = $this->getLine()) {
            $line = trim($line);
            $identifier .= substr($line, 1);

            $nextLine = trim($this->peekLine());
            if (strpos($nextLine, '>') !== 0) {
                break;
            }
        }

        $description = '';
        $separator = strpos($identifier, ' ');

        if ($separator !== false) {
            $description = substr($identifier, $separator + 1);
            $identifier = substr($identifier, 0, $separator);
        }

        try {
            if ($this->format == null || $this->format instanceof DefaultFastaEntry) {
                $this->format = FastaEntryFactory::getParser($identifier);
            }

            $protein = $this->format->getProtein($identifier, $description);
        } catch (Exception $e) {
            $this->format = FastaEntryFactory::getParser($identifier);
            $protein = $this->format->getProtein($identifier, $description);
        }

        $protein->setIdentifier($identifier);
        $protein->setSequence($this->parseSequence());

        $this->key ++;

        return $protein;
    }

    /**
     * Parses the sequence block from the FASTA file and returns the sequence without any line ending or formatting
     *
     * @return string
     */
    private function parseSequence()
    {
        $sequence = '';

        while ($line = $this->getLine()) {
            $sequence .= trim($line);

            $nextLine = trim($this->peekLine());

            if (strpos($nextLine, '>') === 0) {
                break;
            }
        }

        // Remove stop codon in IRGSP FASTA
        if (strrpos($sequence, '*', - 1) !== false) {
            $sequence = substr($sequence, 0, - 1);
        }

        return $sequence;
    }
}
