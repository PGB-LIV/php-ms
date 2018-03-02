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

use pgb_liv\php_ms\Core\Spectra\PrecursorIon;

/**
 * A file writer class for creating Mascot Generic Format (MGF) files.
 *
 * @author Andrew Collins
 */
class MgfWriter
{

    private $fileHandle = null;

    /**
     * Creates a new instance of an MGF file writer.
     * A close() should be called once all entries have been written.
     *
     * @param string $path
     *            The path to the file to save to
     * @param string $searchType
     *            The type of search (Default: MIS)
     * @param string $massType
     *            The mass type (Default: Monoisotopic)
     */
    public function __construct($path, $searchType = 'MIS', $massType = 'Monoisotopic')
    {
        $this->fileHandle = fopen($path, 'w');
        fwrite($this->fileHandle, 'SEARCH=' . $searchType . PHP_EOL);
        fwrite($this->fileHandle, 'MASS=' . $massType . PHP_EOL);
    }

    /**
     * Writes the precursor ion and it's associated fragments to the file associated with this instance
     *
     * @param PrecursorIon $precursor
     *            The precursor ion to write
     */
    public function write(PrecursorIon $precursor)
    {
        if (is_null($this->fileHandle)) {
            throw new \BadMethodCallException('The file handle is closed. Cannot write after close() has been called.');
        }
        
        // TODO: Validate mandatory/optional fields
        fwrite($this->fileHandle, 'BEGIN IONS' . PHP_EOL);
        fwrite($this->fileHandle, 'TITLE=' . $precursor->getTitle() . PHP_EOL);
        fwrite($this->fileHandle, 'PEPMASS=' . $precursor->getMassCharge());
        if (! is_null($precursor->getIntensity())) {
            fwrite($this->fileHandle, ' ' . $precursor->getIntensity());
        }
        
        fwrite($this->fileHandle, PHP_EOL);
        fwrite($this->fileHandle, 'CHARGE=' . $precursor->getCharge() . '+' . PHP_EOL);
        
        if (! is_null($precursor->getScan())) {
            fwrite($this->fileHandle, 'SCANS=' . $precursor->getScan() . PHP_EOL);
        }
        
        if (! is_null($precursor->getRetentionTime())) {
            if ($precursor->hasRetentionTimeWindow()) {
                fwrite($this->fileHandle, 'RTINSECONDS=' . implode(',', $precursor->getRetentionTimeWindow()) . PHP_EOL);
            } else {
                fwrite($this->fileHandle, 'RTINSECONDS=' . $precursor->getRetentionTime() . PHP_EOL);
            }
        }
        
        foreach ($precursor->getFragmentIons() as $ion) {
            fwrite($this->fileHandle, $ion->getMassCharge() . ' ');
            fwrite($this->fileHandle, $ion->getIntensity());
            
            if (! is_null($ion->getCharge())) {
                fwrite($this->fileHandle, ' ' . $ion->getCharge());
            }
            
            fwrite($this->fileHandle, PHP_EOL);
        }
        
        fwrite($this->fileHandle, 'END IONS' . PHP_EOL);
    }

    /**
     * Closes the file handle for this instance and releases resources.
     */
    public function close()
    {
        if (! is_null($this->fileHandle)) {
            fclose($this->fileHandle);
            $this->fileHandle = null;
        }
    }

    /**
     * Finalise method to ensure the instance is correctly closed.
     */
    public function __destruct()
    {
        $this->close();
    }
}
