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

use pgb_liv\php_ms\Core\Spectra\SpectraEntry;

class MgfWriter
{

    private $fileHandle = null;

    public function __construct($path, $searchType = 'MIS', $massType = 'Monoisotopic')
    {
        $this->fileHandle = fopen($path, 'w');
        fwrite($this->fileHandle, 'SEARCH=' . $searchType . PHP_EOL);
        fwrite($this->fileHandle, 'MASS=' . $massType . PHP_EOL);
    }

    public function write(SpectraEntry $spectra)
    {
        // TODO: Verify file handle open
        // TODO: Validate mandatory/optional fields
        fwrite($this->fileHandle, 'BEGIN IONS' . PHP_EOL);
        fwrite($this->fileHandle, 'TITLE=' . $spectra->getTitle() . PHP_EOL);
        fwrite($this->fileHandle, 'PEPMASS=' . $spectra->getMass() . PHP_EOL);
        fwrite($this->fileHandle, 'CHARGE=' . $spectra->getCharge() . '+' . PHP_EOL);
        fwrite($this->fileHandle, 'SCANS=' . $spectra->getScans() . PHP_EOL);
        fwrite($this->fileHandle, 'RTINSECONDS=' . $spectra->getRetentionTime() . PHP_EOL);
        
        foreach ($spectra->getIons() as $ion) {
            fwrite($this->fileHandle, $ion->getMassCharge() . ' ' . $ion->getIntensity() . PHP_EOL);
        }
        
        fwrite($this->fileHandle, 'END IONS' . PHP_EOL);
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
