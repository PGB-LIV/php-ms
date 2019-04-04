<?php
/**
 * Copyright 2019 University of Liverpool
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

use pgb_liv\php_ms\Writer\FastaWriter;
use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Reader\FastaReader;
use pgb_liv\php_ms\Core\Database\UniProtSpDatabase;
use pgb_liv\php_ms\Core\Entry\DatabaseEntry;

class FastaWriterTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @covers pgb_liv\php_ms\Writer\FastaWriter::__construct
     *
     * @uses pgb_liv\php_ms\Writer\FastaWriter
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $fasta = new FastaWriter(tempnam(sys_get_temp_dir(), 'FastaWriterTest'));
        $this->assertInstanceOf('pgb_liv\php_ms\Writer\FastaWriter', $fasta);

        return $fasta;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Writer\FastaWriter::__construct
     * @covers pgb_liv\php_ms\Writer\FastaWriter::write
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeHeader
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeDescription
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeSequence
     * @covers pgb_liv\php_ms\Writer\FastaWriter::close
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Writer\FastaWriter
     *       @group peff
     */
    public function testCanWritePeffEntry()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'FastaWriterTest');

        $protein = new Protein();
        $protein->setIdentifier('sp:Q12471');
        $database = UniProtSpDatabase::getInstance();
        $dbEntry = new DatabaseEntry($database);
        $dbEntry->setUniqueIdentifier('Q12471');

        $protein->setDatabaseEntry($dbEntry);

        $protein->setSequence(
            'MGGSSDSDSHDGYLTSEYNSSNSLFSLNTGNSYSSASLDRATLDCQDSVFFDNHKSSLLS' .
            'TEVPRFISNDPLHLPITLNYKRDNADPTYTNGKVNKFMIVLIGLPATGKSTISSHLIQCL' .
            'KNNPLTNSLRCKVFNAGKIRRQISCATISKPLLLSNTSSEDLFNPKNNDKKETYARITLQ' .
            'KLFHEINNDECDVGIFDATNSTIERRRFIFEEVCSFNTDELSSFNLVPIILQVSCFNRSF' .
            'IKYNIHNKSFNEDYLDKPYELAIKDFAKRLKHYYSQFTPFSLDEFNQIHRYISQHEEIDT' .
            'SLFFFNVINAGVVEPHSLNQSHYPSTCGKQIRDTIMVIENFINHYSQMFGFEYIEAVKLF' . 'FESFGNSSEETLTTLDSVVNDKFFDDLQSLIESNGFA');
        $protein->setDescription('\Pname=6-phosphofructo-2-kinase 2');

        $fasta = new FastaWriter($filePath);
        $fasta->write($protein);
        $fasta->close();

        $fastaReader = new FastaReader($filePath);
        $fastaReader->rewind();

        $this->assertEquals($protein, $fastaReader->current());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Writer\FastaWriter::__construct
     * @covers pgb_liv\php_ms\Writer\FastaWriter::write
     * @covers pgb_liv\php_ms\Writer\FastaWriter::__destruct
     *
     * @expectedException BadMethodCallException
     *
     * @uses pgb_liv\php_ms\Writer\FastaWriter
     */
    public function testCanDestruct()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'FastaWriterTest');

        $protein = new Protein();

        $fasta = new FastaWriter($filePath);
        $fasta->__destruct();
        $fasta->write($protein);
    }
}
