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
namespace pgb_liv\php_ms\experimental;

/**
 * Performs the merging of two or more MzML files into a single MzML file.
 * Note this class is built for speed and does not correctly validate all fields.
 *
 * @author Andrew Collins
 */
class MzMlMerge
{
    const CV_MINUTE = 'UO:0000031';
    
    private $timeOffset;

    private $indexOffset;

    private $idOffset;

    private $spectrumIdRef = array();

    private $dataFiles = array();

    private $outputFiles = array();

    private $fractionOffsets = array();

    private $spectrumCount = array();

    /**
     * The number of seconds that should be used as padding between scans.
     * This should be high enough that image recognition alignment tools can identify a distinct boundary
     * 
     * @var integer
     */
    private $paddingBetweenScans = 600;

    /**
     * Sets the output path for a specified replicate
     *
     * @param int $replicate
     *            The replicate ID
     * @param string $path
     *            The path to write to
     */
    public function setOutputPath($replicate, $path)
    {
        $this->outputFiles[$replicate] = $path;
    }

    /**
     * Adds a data file for processing.
     * The index is the fraction order which should be consistent across replicates
     *
     * @param int $replicate            
     * @param string $file            
     * @param int $index            
     */
    public function addDataFile($replicate, $index, $file)
    {
        $this->dataFiles[$replicate][$index] = array(
            'path' => $file,
            'endTime' => - 1,
            'endIndex' => - 1,
            'endScans' => - 1,
            'spectra' => 0
        );
    }

    public function analyseData()
    {
        // TODO: Validate input and output
        
        // Perform first pass on each data file to identify start, stop RT
        foreach ($this->dataFiles as $replicate => $fractions) {
            foreach ($fractions as $index => $file) {
                $this->dataFiles[$replicate][$index] = $this->analyseFile($file);
            }
        }
        
        // Set replicate start time
        foreach ($this->dataFiles as $replicate => $fractions) {
            foreach ($fractions as $index => $file) {
                if (! isset($this->fractionOffsets[$index]) || $file['endTime'] > $this->fractionOffsets[$index]) {
                    $this->fractionOffsets[$index] = $file['endTime'];
                }
                
                if (! isset($this->spectrumCount[$replicate])) {
                    $this->spectrumCount[$replicate] = 0;
                }
                
                $this->spectrumCount[$replicate] += $file['spectra'];
            }
        }
        
        // Push forward
        $sum = 0;
        foreach ($this->fractionOffsets as $index => $time) {
            // Add time to force seperation in alignment tools
            $this->fractionOffsets[$index] = $sum;
            $sum += $time + $this->paddingBetweenScans;
        }
        
        return $this->dataFiles;
    }

    public function getFractionOffsets()
    {
        return $this->fractionOffsets;
    }

    private function analyseFile($file)
    {
        $reader = fopen($file['path'], 'r');
        
        $isSpectrumList = false;
        
        while (! feof($reader)) {
            $line = fgets($reader);
            
            if (stripos($line, '<spectrumList') !== false) {
                $isSpectrumList = true;
                
                if (preg_match('/<spectrumList(?=.*count="([0-9.]+)")/', $line, $matches)) {
                    $file['spectra'] = $matches[1];
                }
                
                continue;
            }
            
            if (! $isSpectrumList) {
                continue;
            }
            
            if (stripos($line, '</spectrumList') !== false) {
                break;
            }
            
            if (preg_match('/<spectrum(?=.*(index="([0-9.]+)"))(?=.*(id=".*(scan=([0-9]+)).*?"))/', $line, $matches)) {
                $index = $matches[2];
                
                if ($index > $file['endIndex']) {
                    $file['endIndex'] = $index;
                }
                
                $scan = $matches[5];
                
                if ($scan > $file['endScans']) {
                    $file['endScans'] = $scan;
                }
            }
            
            if (preg_match('/accession="MS:1000016"(?=.*(value="([0-9.]+))")(?=.*unitAccession="([A-Z0-9:]+)")/', $line, 
                $matches)) {
                $scanTime = $matches[2];
                if ($matches[3] == self::CV_MINUTE) {
                    $scanTime *= 60;
                }
                
                if ($scanTime > $file['endTime']) {
                    $file['endTime'] = $scanTime;
                }
                
                if ($matches[3] == self::CV_MINUTE) {
                    $scanTime /= 60;
                }
            }
        }
        
        return $file;
    }

    /**
     * Merges the MzML files specified in the constructor into a single MzML file and writes the data to the output file specified in the constructor
     */
    public function merge()
    {
        // TODO: verify analysis phase run
        foreach ($this->dataFiles as $replicate => $fractions) {
            $firstFile = current($fractions);
            // Write header
            $this->writeHeader($firstFile['path'], $this->spectrumCount[$replicate], $this->outputFiles[$replicate]);
            
            // Resets vars
            $this->spectrumIdRef = array();
            $this->timeOffset = 0;
            $this->indexOffset = 0;
            $this->idOffset = 0;
            
            foreach ($fractions as $fractionIndex => $file) {
                $this->writeSpectrum($file['path'], $this->outputFiles[$replicate], 
                    $this->fractionOffsets[$fractionIndex]);
            }
            
            $this->writeFooter($firstFile['path'], $this->outputFiles[$replicate]);
        }
    }

    private function writeHeader($file, $spectrumCount, $outputFile)
    {
        $reader = fopen($file, 'r');
        $writer = fopen($outputFile, 'w');
        
        while (! feof($reader)) {
            $line = fgets($reader);
            
            if (preg_match('/<spectrumList(?=.*count="([0-9.]+)")/', $line, $matches)) {
                $line = str_replace($matches[1], $spectrumCount, $line);
            }
            
            fwrite($writer, $line);
            
            if (stripos($line, '<spectrumList') !== false) {
                break;
            }
        }
        
        fclose($reader);
        fclose($writer);
    }

    private function writeFooter($file, $outputFile)
    {
        $reader = fopen($file, 'r');
        $writer = fopen($outputFile, 'a');
        
        $isPastSpectrumList = false;
        while (! feof($reader)) {
            $line = fgets($reader);
            
            if (stripos($line, '</spectrumList') !== false) {
                $isPastSpectrumList = true;
            }
            
            if ($isPastSpectrumList) {
                fwrite($writer, $line);
            }
        }
        
        fclose($reader);
        fclose($writer);
    }

    private function writeSpectrum($file, $outputFile, $timeOffset)
    {
        $reader = fopen($file, 'r');
        $writer = fopen($outputFile, 'a');
        
        $isSpectrumList = false;
        // Local offsets
        $localIndexOffset = $this->indexOffset;
        $localIdOffset = $this->idOffset;
        
        while (! feof($reader)) {
            $line = fgets($reader);
            
            if (stripos($line, '<spectrumList') !== false) {
                $isSpectrumList = true;
                continue;
            }
            
            if (! $isSpectrumList) {
                continue;
            }
            
            if (stripos($line, '</spectrumList') !== false) {
                break;
            }
            
            if (preg_match('/<spectrum(?=.*(index="([0-9.]+)"))(?=.*(id=".*(scan=([0-9]+)).*?"))/', $line, $matches)) {
                $index = $matches[2];
                $index += $localIndexOffset;
                
                if ($index > $this->indexOffset) {
                    $this->indexOffset = $index;
                }
                
                $scan = $matches[5];
                $scan += $localIdOffset;
                
                if ($scan > $this->idOffset) {
                    $this->idOffset = $scan;
                }
                
                $line = str_replace($matches[1], 'index="' . $index . '"', $line);
                $idChunk = str_replace($matches[4], 'scan=' . $scan, $matches[3]);
                
                $this->spectrumIdRef[substr($matches[3], 4, - 1)] = substr($idChunk, 4, - 1);
                
                $line = str_replace($matches[3], $idChunk, $line);
            }
            
            if (preg_match('/<precursor(?=.*(spectrumRef="(.*?)"))/', $line, $matches)) {
                $line = str_replace($matches[2], $this->spectrumIdRef[$matches[2]], $line);
            }
            
            if (preg_match('/accession="MS:1000016"(?=.*(value="([0-9.]+))")(?=.*unitAccession="([A-Z0-9:]+)")/', $line, 
                $matches)) {
                $scanTime = $matches[2];
                if ($matches[3] == self::CV_MINUTE) {
                    $scanTime *= 60;
                }
                
                $scanTime += $timeOffset;
                
                if ($matches[3] == self::CV_MINUTE) {
                    $scanTime /= 60;
                }
                
                $line = str_replace($matches[2], $scanTime, $line);
            }
            
            fwrite($writer, $line);
        }
        
        fclose($reader);
        fclose($writer);
    }
}
