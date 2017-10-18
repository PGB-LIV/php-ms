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
use pgb_liv\php_ms\Core\Spectra\PrecursorIon;
use pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry;
use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Core\Peptide;

class ProBedWriter
{

    private $fileHandle = null;

    private $name;

    private $uniqueId = 0;

    /**
     * Creates a new instance of a ProBed Writer.
     *
     * @param string $path
     *            The path to write data to
     */
    public function __construct($path, $name, array $headers = array())
    {
        $this->fileHandle = fopen($path, 'w');
        $this->name = $name;
        
        $this->writeHeader($headers);
    }

    public function write(PrecursorIon $spectra)
    {
        if (is_null($this->fileHandle)) {
            throw new \BadMethodCallException('File handle is not open, write cannot be called after close');
        }
        
        foreach ($spectra->getIdentifications() as $identification) {
            $this->writeIdentification($spectra, $identification);
        }
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

    private function writeHeader(array $headers)
    {
        fwrite($this->fileHandle, '# proBed-version' . "\t" . '1.0' . PHP_EOL);
        fwrite($this->fileHandle, '# Created on ' . date('r') . ' by phpMs' . PHP_EOL);
        
        foreach ($headers as $header) {
            fwrite($this->fileHandle, '# '. $header . PHP_EOL);
        }
    }

    private function writeIdentification(PrecursorIon $spectra, Identification $identification)
    {
        $peptide = $identification->getPeptide();
        
        if ($peptide->isDecoy()) {
            return;
        }
        
        foreach ($peptide->getProteins() as $proteinEntry) {
            // Verify suitable for output
            if (! $this->isValid($proteinEntry)) {
                continue;
            }
            
            $protein = $proteinEntry->getProtein();
            
            $minStart = min($proteinEntry->getChromosomePositionsStart());
            $relPositions = array();
            foreach ($proteinEntry->getChromosomePositionsStart() as $position) {
                $relPositions[] = $position - $minStart;
            }
            
            $relPositions = implode(',', $relPositions);
            
            // chrom
            fwrite($this->fileHandle, $protein->getChromosome()->getName() . "\t");
            
            // chromStart
            fwrite($this->fileHandle, ($minStart - 1) . "\t");
            
            // chromEnd
            fwrite($this->fileHandle, ($proteinEntry->getChromosomePositionEnd() + 1) . "\t");
            
            // name
            fwrite($this->fileHandle, ($protein->getAccession() . '_' . $this->uniqueId) . "\t");
            
            // score
            fwrite($this->fileHandle, '1000' . "\t");
            
            // strand
            fwrite($this->fileHandle, $protein->getChromosome()->getStrand() . "\t");
            
            // thickStart
            fwrite($this->fileHandle, ($minStart - 1) . "\t");
            
            // thickEnd
            fwrite($this->fileHandle, ($proteinEntry->getChromosomePositionEnd() + 1) . "\t");
            
            // reserved
            fwrite($this->fileHandle, '0' . "\t");
            
            // blockCount
            fwrite($this->fileHandle, $proteinEntry->getChromosomeBlockCount() . "\t");
            
            // blockSizes
            fwrite($this->fileHandle, $proteinEntry->getChromosomeBlockSizes() . "\t");
            
            // chromStarts
            fwrite($this->fileHandle, $relPositions . "\t");
            
            // proteinAccession
            fwrite($this->fileHandle, $protein->getAccession() . "\t");
            
            // peptideSequence
            fwrite($this->fileHandle, $peptide->getSequence() . "\t");
            
            // uniqueness
            fwrite($this->fileHandle, (count($peptide->getProteins()) == 1 ? 'unique' : 'not-unique[unknown]') . "\t");
            
            // genomeReferenceVersion
            fwrite($this->fileHandle, 
                (is_null($protein->getChromosome()->getGenomeReferenceVersion()) ? '.' : $protein->getChromosome()->getGenomeReferenceVersion()) .
                     "\t");
            
            // TODO: psmScore
            fwrite($this->fileHandle, '.' . "\t");
            
            // fdr
            fwrite($this->fileHandle, $identification->getScore('MS:1002356') . "\t");
            
            // modifications
            fwrite($this->fileHandle, $this->getModificationString($peptide) . "\t");
            
            // charge
            fwrite($this->fileHandle, $spectra->getCharge() . "\t");
            
            // expMassToCharge
            fwrite($this->fileHandle, $spectra->getMassCharge() . "\t");
            
            // calcMassToCharge
            fwrite($this->fileHandle, $peptide->getMonoisotopicMassCharge($spectra->getCharge()) . "\t");
            
            // psmRank
            fwrite($this->fileHandle, $identification->getRank() . "\t");
            
            // datasetID
            fwrite($this->fileHandle, $this->name . "\t");
            
            // uri - not implementable?
            fwrite($this->fileHandle, '.' . "\n");
            
            $this->uniqueId ++;
        }
    }

    private function getModificationString(Peptide $peptide)
    {
        $mods = array();
        foreach ($peptide->getModifications() as $modification) {
            $modStr = $modification->getLocation() . '-';
            if (is_null($modification->getAccession())) {
                // Spec states mass value should be specified?
                $modStr = 'MS:1001460';
            } else {
                $modStr .= $modification->getAccession();
            }
            
            $mods[] = $modStr;
        }
        
        return count($mods) > 0 ? implode(',', $mods) : '.';
    }

    private function isValid(ProteinEntry $proteinEntry)
    {
        if (! is_a($proteinEntry, '\pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry')) {
            return false;
        }
        
        $protein = $proteinEntry->getProtein();
        $chromosome = $protein->getChromosome();
        
        // Possible unmapped protein
        if (is_null($chromosome) || is_null($chromosome->getGenomeReferenceVersion())) {
            return false;
        }
        
        return true;
    }
}
