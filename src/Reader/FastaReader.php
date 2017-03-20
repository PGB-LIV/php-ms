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
namespace pgb_liv\php_ms\Reader;

use pgb_liv\php_ms\Core\Database\Fasta\FastaFactory;
use pgb_liv\php_ms\Core\Protein;

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

    private $current;

    private $key = 0;

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
        if ($this->current instanceof Protein) {
            return true;
        }
        
        return false;
    }

    /**
     * Gets the next line and increments the file iterator
     *
     * @return The next line in the file
     */
    private function getLine()
    {
        $ret = null;
        if ($this->filePeek != null) {
            $ret = $this->filePeek;
            $this->filePeek = null;
        } else {
            $ret = fgets($this->fileHandle);
        }
        
        return $ret;
    }

    /**
     * Gets the next line, though does not move the file iterator
     *
     * @return The next line in the file
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
        // Scan to first entry
        do {
            $line = trim($this->peekLine());
            
            if (strpos($line, '>') === 0) {
                break;
            }
        } while ($line = $this->getLine());
        
        $description = '';
        while ($line = $this->getLine()) {
            $line = trim($line);
            $description .= substr($line, 1);
            
            $nextLine = trim($this->peekLine());
            if (strpos($nextLine, '>') !== 0) {
                break;
            }
        }
        
        $identifier = substr($description, 0, strpos($description, ' '));
        $description = substr($description, strpos($description, ' ') + 1);
        
        $sequence = '';
        while ($line = $this->getLine()) {
            $sequence .= trim($line);
            
            $nextLine = trim($this->peekLine());
            if (strpos($nextLine, '>') === 0) {
                break;
            }
        }
        
        $entry = FastaFactory::getProtein($identifier, $description, $sequence);
        
        $this->key ++;
        
        return $entry;
    }
}
