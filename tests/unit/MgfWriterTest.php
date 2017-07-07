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

use pgb_liv\php_ms\Core\Spectra\PrecursorIon;
use pgb_liv\php_ms\Core\Spectra\FragmentIon;
use pgb_liv\php_ms\Writer\MgfWriter;
use pgb_liv\php_ms\Reader\MgfReader;

class MgfWriterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Writer\MgfWriter::__construct
     *
     * @uses pgb_liv\php_ms\Writer\MgfWriter
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $mgf = new MgfWriter(tempnam(sys_get_temp_dir(), 'MgfWriterTest'));
        $this->assertInstanceOf('pgb_liv\php_ms\Writer\MgfWriter', $mgf);
        
        return $mgf;
    }

    /**
     * @covers pgb_liv\php_ms\Writer\MgfWriter::__construct
     * @covers pgb_liv\php_ms\Writer\MgfWriter::write
     * @covers pgb_liv\php_ms\Writer\MgfWriter::close
     * @covers pgb_liv\php_ms\Reader\MgfReader::__construct
     * @covers pgb_liv\php_ms\Reader\MgfReader::rewind
     * @covers pgb_liv\php_ms\Reader\MgfReader::current
     *
     * @uses pgb_liv\php_ms\Reader\MgfReader
     * @uses pgb_liv\php_ms\Writer\MgfWriter
     */
    public function testCanWriteShortEntry()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'MgfWriterTest');
        
        $precursor = new PrecursorIon();
        $precursor->setMassCharge(mt_rand(1000000, 3000000) / 1000);
        $precursor->setCharge(2);
        
        $frag = new FragmentIon();
        $frag->setMassCharge(mt_rand(100000, 200000) / 1000);
        $frag->setIntensity(mt_rand(100000, 200000));
        
        $precursor->addFragmentIon($frag);
        
        $mgf = new MgfWriter($filePath);
        $mgf->write($precursor);
        $mgf->close();
        
        $mgfReader = new MgfReader($filePath);
        $mgfReader->rewind();
        
        $this->assertEquals($precursor, $mgfReader->current());
    }

    /**
     * @covers pgb_liv\php_ms\Writer\MgfWriter::__construct
     * @covers pgb_liv\php_ms\Writer\MgfWriter::write
     * @covers pgb_liv\php_ms\Writer\MgfWriter::close
     * @covers pgb_liv\php_ms\Reader\MgfReader::__construct
     * @covers pgb_liv\php_ms\Reader\MgfReader::rewind
     * @covers pgb_liv\php_ms\Reader\MgfReader::current
     *
     * @uses pgb_liv\php_ms\Reader\MgfReader
     * @uses pgb_liv\php_ms\Writer\MgfWriter
     */
    public function testCanWriteLongEntry()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'MgfWriterTest');
        
        $precursor = new PrecursorIon();
        $precursor->setMassCharge(mt_rand(1000000, 3000000) / 1000);
        $precursor->setCharge(2);
        $precursor->setRetentionTime(mt_rand(1000, 90000) / 1000);
        $precursor->setScan(mt_rand(1, 3000));
        $precursor->setTitle('Mgf scan entry');
        
        $frag = new FragmentIon();
        $frag->setMassCharge(mt_rand(100000, 200000) / 1000);
        $frag->setIntensity(mt_rand(100000, 200000));
        $frag->setCharge(2);
        
        $precursor->addFragmentIon($frag);
        
        $mgf = new MgfWriter($filePath);
        $mgf->write($precursor);
        $mgf->close();
        
        $mgfReader = new MgfReader($filePath);
        $mgfReader->rewind();
        
        $this->assertEquals($precursor, $mgfReader->current());
    }

    /**
     * @covers pgb_liv\php_ms\Writer\MgfWriter::__construct
     * @covers pgb_liv\php_ms\Writer\MgfWriter::write
     * @covers pgb_liv\php_ms\Writer\MgfWriter::__destruct
     *
     * @expectedException BadMethodCallException
     *
     * @uses pgb_liv\php_ms\Writer\MgfWriter
     */
    public function testCanDestruct()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'MgfWriterTest');
        
        $precursor = new PrecursorIon();
        
        $mgf = new MgfWriter($filePath);
        $mgf->__destruct();
        $mgf->write($precursor);
    }
}
