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
use pgb_liv\php_ms\Core\Spectra\PrecursorIon;
use pgb_liv\php_ms\Core\Spectra\FragmentIon;
use pgb_liv\php_ms\Writer\MgfWriter;

class MgfReaderTest extends \PHPUnit_Framework_TestCase
{

    private function createTestFile(&$mgfEntries)
    {
        for ($entryIndex = 0; $entryIndex < 10; $entryIndex ++) {
            $entry = new PrecursorIon();
            $entry->setTitle('MY TEST RUN  (intensity=192543543.5801)');
            $entry->setMassCharge(rand(10000000, 1000000000) / 100000);
            $entry->setCharge(3);
            $entry->setScan(rand(1000, 10000));
            $entry->setRetentionTime(rand(1000, 90000) / 100);
            
            for ($ionIndex = 0; $ionIndex < 15; $ionIndex ++) {
                $ion = new FragmentIon();
                
                $ion->setMassCharge(rand(10000, 100000) / 100.0);
                $ion->setIntensity(rand(100000, 10000000) / 100);
                $ion->setCharge(rand(1, 3));
                
                $entry->addFragmentIon($ion);
            }
            
            $mgfEntries[] = $entry;
        }
        
        $tempFile = tempnam(sys_get_temp_dir(), 'MgfReaderTest');
        $mgfWriter = new MgfWriter($tempFile);
        
        foreach ($mgfEntries as $entry) {
            $mgfWriter->write($entry);
        }
        
        $mgfWriter->close();
        
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
     * @covers pgb_liv\php_ms\Reader\MgfReader::current
     * @covers pgb_liv\php_ms\Reader\MgfReader::next
     * @covers pgb_liv\php_ms\Reader\MgfReader::key
     * @covers pgb_liv\php_ms\Reader\MgfReader::rewind
     * @covers pgb_liv\php_ms\Reader\MgfReader::valid
     * @covers pgb_liv\php_ms\Reader\MgfReader::peekLine
     * @covers pgb_liv\php_ms\Reader\MgfReader::getLine
     * @covers pgb_liv\php_ms\Reader\MgfReader::parseEntry
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

    /**
     * @covers pgb_liv\php_ms\Reader\MgfReader::__construct
     * @covers pgb_liv\php_ms\Reader\MgfReader::current
     * @covers pgb_liv\php_ms\Reader\MgfReader::next
     * @covers pgb_liv\php_ms\Reader\MgfReader::key
     * @covers pgb_liv\php_ms\Reader\MgfReader::rewind
     * @covers pgb_liv\php_ms\Reader\MgfReader::valid
     * @covers pgb_liv\php_ms\Reader\MgfReader::peekLine
     * @covers pgb_liv\php_ms\Reader\MgfReader::getLine
     * @covers pgb_liv\php_ms\Reader\MgfReader::parseEntry
     *
     * @uses pgb_liv\php_ms\Reader\MgfReader
     */
    public function testCanRewind()
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
        
        // Ensure rewind fires correctly
        $i = 0;
        foreach ($mgf as $key => $entry) {
            $this->assertEquals($mgfEntries[$key - 1], $entry);
            $i ++;
        }
        
        $this->assertEquals($i, count($mgfEntries));
    }
}
