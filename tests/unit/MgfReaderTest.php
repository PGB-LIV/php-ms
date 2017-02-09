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
namespace pgb_liv\php_ms\Test\Unit;

use pgb_liv\php_ms\Reader\MgfReader;
use pgb_liv\php_ms\Core\Spectra\SpectraEntry;

class MgfReaderTest extends \PHPUnit_Framework_TestCase
{

    private function createTestFile(&$mgfEntries)
    {
        for ($entryIndex = 0; $entryIndex < 10; $entryIndex ++) {
            $entry = new SpectraEntry();
            $entry->setTitle('MY TEST RUN  (intensity=192543543.5801)');
            $entry->setMassCharge(rand(10000000, 1000000000) / 100000);
            $entry->setCharge(3);
            $entry->setScans(rand(1000, 10000));
            $entry->setRetentionTime(rand(1000, 90000) / 100);
            
            for ($ionIndex = 0; $ionIndex < 15; $ionIndex ++) {
                $ion = new SpectraEntry();
                
                $ion->setMassCharge(rand(10000, 100000) / 100.0);
                $ion->setIntensity(rand(100000, 10000000) / 100);
                
                $entry->addIon($ion);
            }
            
            $mgfEntries[] = $entry;
        }
        
        // Header
        $mgf = 'SEARCH=MIS';
        $mgf .= 'MASS=Monoisotopic' . "\n";
        
        foreach ($mgfEntries as $entry) {
            $mgf .= 'BEGIN IONS' . "\n";
            $mgf .= 'TITLE=' . $entry->getTitle() . "\n";
            $mgf .= 'PEPMASS=' . $entry->getMassCharge() . "\n";
            $mgf .= 'CHARGE=' . $entry->getCharge() . "\n";
            $mgf .= 'SCANS=' . $entry->getScans() . "\n";
            $mgf .= 'RTINSECONDS=' . $entry->getRetentionTime() . "\n";
            
            foreach ($entry->getIons() as $ion) {
                $mgf .= $ion->getMassCharge();
                $mgf .= ' ';
                $mgf .= $ion->getIntensity();
                $mgf .= "\n";
            }
            
            $mgf .= 'END IONS' . "\n";
        }
        
        $tempFile = tempnam(sys_get_temp_dir(), 'MgfReaderTest');
        
        file_put_contents($tempFile, $mgf);
        
        return $tempFile;
    }

    /**
     * @covers pgb_liv\php_ms\Reader\MgfReader::__construct
     *
     * @uses pgb_liv\php_ms\Reader\MgfReader
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $mgfEntries = array();
        $mgfPath = $this->createTestFile($mgfEntries);
        $mgf = new MgfReader($mgfPath);
        $this->assertInstanceOf('pgb_liv\php_ms\Reader\MgfReader', $mgf);
        
        return $mgf;
    }

    /**
     * @covers pgb_liv\php_ms\Reader\MgfReader::__construct
     *
     * @uses pgb_liv\php_ms\Reader\MgfReader
     */
    public function testCanRetrieveEntry()
    {
        $mgfEntries = array();
        $mgfPath = $this->createTestFile($mgfEntries);
        
        $mgf = new MgfReader($mgfPath);
        
        $i = 0;
        foreach ($mgf as $key => $entry) {
            $this->assertEquals($mgfEntries[$key - 1], $entry);
            $i ++;
        }
        
        $this->assertEquals($i, count($mgfEntries));
    }
}
