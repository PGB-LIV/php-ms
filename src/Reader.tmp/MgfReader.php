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
        if (is_array($this->current)) {
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
        $entry = array();
        
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
        
        // Scan for key=value pairs
        $entry['meta'] = array();
        while ($line = $this->peekLine()) {
            if (strpos($line, '=') === false) {
                break;
            }
            
            $line = trim($this->getLine());
            $pair = explode('=', $line, 2);
            
            $value = $pair[1];
            if (is_numeric($value)) {
                $value += 0;
            }
            
            $entry['meta'][$pair[0]] = $value;
        }
        
        // Scan for [m/z] [intensity]
        $entry['ions'] = array();
        while ($line = $this->peekLine()) {
            if (strpos($line, 'END IONS') !== false) {
                break;
            }
            
            $line = trim($this->getLine());
            $pair = explode(' ', $line, 2);
            
            $ion = array();
            $ion['mz'] = (float) $pair[0];
            if (count($pair) > 1) {
                $ion['intensity'] = (float) $pair[1];
            }
            
            if (count($pair) > 2) {
                $ion['charge'] = $pair[2];
            }
            
            $entry['ions'][] = $ion;
        }
        
        $this->key ++;
        
        return $entry;
    }
}
