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

use pgb_liv\php_ms\Reader\FastaReader;

class FastaReaderTest extends \PHPUnit_Framework_TestCase
{

    private function createTestFile(&$fastaEntries)
    {
        $fasta = '';
        for ($i = 0; $i < 5; $i ++) {
            $description = '>' . uniqid();
            $sequence = uniqid() . "\n";
            $sequence .= uniqid() . "\n";
            $sequence .= uniqid() . "\n";
            $sequence .= uniqid() . "\n";
            
            $fastaEntries[] = array(
                'description' => substr($description, 1),
                'sequence' => str_replace("\n", '', $sequence)
            );
            
            $fasta .= $description . "\n" . $sequence . "\n";
        }
        
        $tempFile = tempnam(sys_get_temp_dir(), 'FastaParserTest');
        
        file_put_contents($tempFile, $fasta);
        
        return $tempFile;
    }

    /**
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $fastaEntries = array();
        $fastaPath = $this->createTestFile($fastaEntries);
        $fasta = new FastaReader($fastaPath);
        $this->assertInstanceOf('\pgb_liv\php_ms\Reader\FastaReader', $fasta);
        
        return $fasta;
    }

    /**
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     */
    public function testCanRetrieveEntry()
    {
        $fastaEntries = array();
        $fastaPath = $this->createTestFile($fastaEntries);
        
        $fasta = new FastaReader($fastaPath);
        foreach ($fasta as $key => $entry) {
            $this->assertEquals($fastaEntries[$key - 1], $entry);
        }
    }
}
