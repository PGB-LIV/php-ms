<?php
/**
 * Copyright 2018 University of Liverpool
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

use pgb_liv\php_ms\Core\Spectra\PrecursorIon;
use pgb_liv\php_ms\Core\Spectra\FragmentIon;

/**
 * An MGF reader that creates a new iterable object that will return a raw
 * entry on each iteration.
 *
 * @author Andrew Collins
 */
class MgfReader implements \Iterator
{

    private $filePath;

    private $fileHandle;

    private $filePeek;

    private $current;

    private $key = 0;

    private $mz;

    private $charge;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

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
            $this->current = $this->parseEntry();
        }
    }

    public function rewind()
    {
        // Reset file parsing to start
        if ($this->fileHandle != null) {
            fclose($this->fileHandle);
        }
        
        $this->fileHandle = fopen($this->filePath, 'r');
        $this->key = 0;
        $this->current = $this->parseEntry();
    }

    public function valid()
    {
        if ($this->current instanceof PrecursorIon) {
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

    private function parseEntry()
    {
        $entry = new PrecursorIon();
        
        // Scan to BEGIN IONS
        $isFound = false;
        while ($line = $this->getLine()) {
            $line = trim($line);
            if (strpos($line, 'BEGIN IONS') !== 0) {
                continue;
            }
            
            $isFound = true;
            break;
        }
        
        if (! $isFound) {
            return null;
        }
        
        $this->mz = null;
        $this->charge = null;
        
        // Scan for key=value pairs
        while ($line = $this->peekLine()) {
            if (strpos($line, '=') === false) {
                break;
            }
            
            $this->parseMeta($entry);
        }
        
        $entry->setMonoisotopicMassCharge($this->mz, $this->charge);
        
        // Scan for [m/z] [intensity] [charge]
        while ($line = $this->peekLine()) {
            if (strpos($line, 'END IONS') !== false) {
                break;
            }
            
            $this->parseFragments($entry);
        }
        
        $this->key ++;
        
        return $entry;
    }

    /**
     * Parses the meta information from the scan and writes it to the precursor entry
     *
     * @param PrecursorIon $precursor
     *            The precursor to append to
     */
    private function parseMeta(PrecursorIon $precursor)
    {
        $line = trim($this->getLine());
        $pair = explode('=', $line, 2);
        
        $value = $pair[1];
        if (is_numeric($value)) {
            $value += 0;
        }
        
        if ($pair[0] == 'TITLE') {
            $precursor->setTitle($pair[1]);
        } elseif ($pair[0] == 'PEPMASS') {
            $chunks = explode(' ', $pair[1]);
            if (count($chunks) > 1) {
                $precursor->setIntensity((float) $chunks[1] + 0);
            }
            
            $this->mz = (float) $chunks[0] + 0;
        } elseif ($pair[0] == 'CHARGE') {
            $this->charge = (int) $pair[1];
        } elseif ($pair[0] == 'SCANS') {
            $precursor->setScan((int) $pair[1] + 0);
        } elseif ($pair[0] == 'RTINSECONDS') {
            $window = explode(',', $pair[1]);
            if (count($window) == 1) {
                $precursor->setRetentionTime((float) $window[0] + 0);
            } else {
                $precursor->setRetentionTimeWindow((float) $window[0] + 0, (float) $window[1] + 0);
            }
        }
    }

    /**
     * Parses the fragment information from the scan and writes it to the precursor entry
     *
     * @param PrecursorIon $precursor
     *            The precursor to append to
     */
    private function parseFragments(PrecursorIon $precursor)
    {
        $line = trim($this->getLine());
        
        if (strlen($line) == 0) {
            return;
        }
        
        $pair = preg_split('/\\s/', $line, 3);
        
        $ion = new FragmentIon();
        $fragmentMz = (float) $pair[0];
        $fragmentCharge = $this->charge;
        if (count($pair) > 1) {
            $ion->setIntensity((float) $pair[1]);
        }
        
        if (count($pair) > 2) {
            $fragmentCharge = (int) $pair[2];
        }
        
        $ion->setMonoisotopicMassCharge($fragmentMz, $fragmentCharge);
        
        $precursor->addFragmentIon($ion);
    }
}
