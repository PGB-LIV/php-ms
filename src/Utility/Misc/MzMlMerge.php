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
namespace pgb_liv\php_ms\Utility\Misc;

/**
 * Performs the merging of two or more MzML files into a single MzML file.
 * Note this class is built for speed and does not correctly validate all fields.
 *
 * @author Andrew Collins
 */
class MzMlMerge
{

    private $fileList;

    private $outputPath;

    private $timeOffset;

    private $indexOffset;

    private $idOffset;

    /**
     * Creates a new instance of this class with a set of files to merge and a target output file
     *
     * @param array $files
     *            List of files to merge, files are merged in order of array
     * @param string $outputPath
     *            Output target file path
     */
    public function __construct(array $files, $outputPath)
    {
        if (count($files) < 2) {
            throw new \InvalidArgumentException('At least 2 MzML files must be specified');
        }
        
        $this->fileList = $files;
        $this->outputPath = $outputPath;
    }

    /**
     * Merges the MzML files specified in the constructor into a single MzML file and writes the data to the output file specified in the constructor
     */
    public function merge()
    {
        $spectrumCount = 0;
        foreach ($this->fileList as $file) {
            $spectrumCount += $this->countSpectrum($file);
        }
        
        reset($this->fileList);
        
        $firstFile = current($this->fileList);
        // Write header
        $this->writeHeader($firstFile, $spectrumCount);
        
        $this->timeOffset = 0;
        $this->indexOffset = 0;
        $this->idOffset = 0;
        
        foreach ($this->fileList as $file) {
            $this->writeSpectrum($file);
        }
        
        $this->writeFooter($firstFile);
    }

    private function writeHeader($file, $spectrumCount)
    {
        $reader = fopen($file, 'r');
        $writer = fopen($this->outputPath, 'w');
        
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

    private function writeFooter($file)
    {
        $reader = fopen($file, 'r');
        $writer = fopen($this->outputPath, 'a');
        
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

    private function writeSpectrum($file)
    {
        $reader = fopen($file, 'r');
        $writer = fopen($this->outputPath, 'a');
        
        $isSpectrumList = false;
        // Local offsets
        $timeOffset = $this->timeOffset;
        $indexOffset = $this->indexOffset;
        $idOffset = $this->idOffset;
        
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
            
            if (preg_match('/<spectrum(?=.*(index="([0-9.]+)"))(?=.*(id=".*(scan=([0-9]+)).*"))/', $line, $matches)) {
                $index = $matches[2];
                $index += $indexOffset;
                
                if ($index > $this->indexOffset) {
                    $this->indexOffset = $index;
                }
                
                $scan = $matches[5];
                $scan += $idOffset;
                
                if ($scan > $this->idOffset) {
                    $this->idOffset = $scan;
                }
                
                $line = str_replace($matches[1], 'index="' . $index . '"', $line);
                $idChunk = str_replace($matches[4], 'scan=' . $scan, $matches[3]);
                
                $line = str_replace($matches[3], $idChunk, $line);
            }
            
            if (preg_match('/accession="MS:1000016"(?=.*(value="([0-9.]+))")(?=.*unitAccession="([A-Z0-9:]+)")/', $line, 
                $matches)) {
                $scanTime = $matches[2];
                if ($matches[3] == 'UO:0000031') {
                    $scanTime *= 60;
                }
                
                $scanTime += $timeOffset;
                
                if ($scanTime > $this->timeOffset) {
                    $this->timeOffset = $scanTime;
                }
                
                if ($matches[3] == 'UO:0000031') {
                    $scanTime /= 60;
                }
                
                $line = str_replace($matches[2], $scanTime, $line);
            }
            
            fwrite($writer, $line);
        }
        
        fclose($reader);
        fclose($writer);
    }

    private function countSpectrum($file)
    {
        $reader = fopen($file, 'r');
        
        while (! feof($reader)) {
            $line = fgets($reader);
            
            if (preg_match('/<spectrumList(?=.*count="([0-9.]+)")/', $line, $matches)) {
                return $matches[1];
            }
        }
        
        return 0;
    }
}
