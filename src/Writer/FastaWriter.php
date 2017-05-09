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

class FastaWriter
{

    private $fileHandle = null;

    public function __construct($path)
    {
        $this->fileHandle = fopen($path, 'w');
    }

    protected function writeDescription(Protein $protein)
    {
        // TODO: Verify file handle open
        fwrite($this->fileHandle, '>' . $protein->getUniqueIdentifier());
        
        if (! is_null($protein->getDescription())) {
            fwrite($this->fileHandle, ' ' . $protein->getDescription());
        }
    }

    protected function writeSequence(Protein $protein)
    {
        fwrite($this->fileHandle, PHP_EOL . wordwrap($protein->getSequence(), 60, PHP_EOL, true) . PHP_EOL);
    }

    public function write(Protein $protein)
    {
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
