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
namespace pgb_liv\php_ms\Writer;

use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Database\Fasta\DefaultFastaEntry;

class FastaWriter
{

    private $fileHandle = null;

    /**
     * FASTA Format to use for description line
     *
     * @var callable
     */
    private $format;

    public function __construct($path, $format = 'DefaultFastaEntry')
    {
        $this->fileHandle = fopen($path, 'w');
        $this->format = $format;
    }

    private function writeDescription(Protein $protein)
    {
        $output = call_user_func(array(
            $this->format,
            'toFasta'
        ), $protein);
        
        fwrite($this->fileHandle, $output);
    }

    private function writeSequence(Protein $protein)
    {
        fwrite($this->fileHandle, PHP_EOL . wordwrap($protein->getSequence(), 60, PHP_EOL, true) . PHP_EOL);
    }

    public function write(Protein $protein)
    {
        if (is_null($this->fileHandle)) {
            throw new \UnexpectedValueException('File handle is not open, write cannot be called after close');
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
}
