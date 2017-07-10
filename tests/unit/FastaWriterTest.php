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

use pgb_liv\php_ms\Writer\FastaWriter;
use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Reader\FastaReader;
use pgb_liv\php_ms\Core\Database\Fasta\PeffFastaEntry;
use pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry;

class FastaWriterTest extends \PHPUnit_Framework_TestCase
{

    /**
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
     * @covers pgb_liv\php_ms\Writer\FastaWriter::__construct
     * @covers pgb_liv\php_ms\Writer\FastaWriter::write
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeHeader
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeDescription
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeSequence
     * @covers pgb_liv\php_ms\Writer\FastaWriter::close
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Core\Database\Fasta\DefaultFastaEntry::getProtein
     * @covers pgb_liv\php_ms\Core\Database\Fasta\DefaultFastaEntry::getDescription
     * @covers pgb_liv\php_ms\Core\Database\Fasta\DefaultFastaEntry::getHeader
     *
     * @uses pgb_liv\php_ms\Core\Database\Fasta\DefaultFastaEntry
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Writer\FastaWriter
     */
    public function testCanWriteDefaultEntry()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'FastaWriterTest');
        
        $protein = new Protein();
        $protein->setUniqueIdentifier('sp|Q12471|6P22_YEAST');
        $protein->setDescription('6-phosphofructo-2-kinase 2');
        $protein->setSequence('MGGSSDSDSHDGYLTSEYNSSNSLFSLNTGNSYSSASLDRATLDCQDSVFFDNHKSSLLS' . 'TEVPRFISNDPLHLPITLNYKRDNADPTYTNGKVNKFMIVLIGLPATGKSTISSHLIQCL' . 'KNNPLTNSLRCKVFNAGKIRRQISCATISKPLLLSNTSSEDLFNPKNNDKKETYARITLQ' . 'KLFHEINNDECDVGIFDATNSTIERRRFIFEEVCSFNTDELSSFNLVPIILQVSCFNRSF' . 'IKYNIHNKSFNEDYLDKPYELAIKDFAKRLKHYYSQFTPFSLDEFNQIHRYISQHEEIDT' . 'SLFFFNVINAGVVEPHSLNQSHYPSTCGKQIRDTIMVIENFINHYSQMFGFEYIEAVKLF' . 'FESFGNSSEETLTTLDSVVNDKFFDDLQSLIESNGFA');
        
        $fasta = new FastaWriter($filePath);
        $fasta->write($protein);
        $fasta->close();
        
        $fastaReader = new FastaReader($filePath);
        $fastaReader->rewind();
        
        $this->assertEquals($protein, $fastaReader->current());
    }

    /**
     * @covers pgb_liv\php_ms\Writer\FastaWriter::__construct
     * @covers pgb_liv\php_ms\Writer\FastaWriter::write
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeHeader
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeDescription
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeSequence
     * @covers pgb_liv\php_ms\Writer\FastaWriter::close
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Core\Database\Fasta\DefaultFastaEntry::getHeader
     * @covers pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry::getProtein
     * @covers pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry::getDescription
     *
     * @uses pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry
     * @uses pgb_liv\php_ms\Core\Database\Fasta\DefaultFastaEntry
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Writer\FastaWriter
     */
    public function testCanWriteUniprotEntry()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'FastaWriterTest');
        
        $protein = new Protein();
        $protein->setUniqueIdentifier('sp|Q12471|6P22_YEAST');
        $protein->setDatabasePrefix('sp');
        $protein->setAccession('Q12471');
        $protein->setEntryName('6P22_YEAST');
        $protein->setName('6-phosphofructo-2-kinase 2');
        $protein->setSequence('MGGSSDSDSHDGYLTSEYNSSNSLFSLNTGNSYSSASLDRATLDCQDSVFFDNHKSSLLS' . 'TEVPRFISNDPLHLPITLNYKRDNADPTYTNGKVNKFMIVLIGLPATGKSTISSHLIQCL' . 'KNNPLTNSLRCKVFNAGKIRRQISCATISKPLLLSNTSSEDLFNPKNNDKKETYARITLQ' . 'KLFHEINNDECDVGIFDATNSTIERRRFIFEEVCSFNTDELSSFNLVPIILQVSCFNRSF' . 'IKYNIHNKSFNEDYLDKPYELAIKDFAKRLKHYYSQFTPFSLDEFNQIHRYISQHEEIDT' . 'SLFFFNVINAGVVEPHSLNQSHYPSTCGKQIRDTIMVIENFINHYSQMFGFEYIEAVKLF' . 'FESFGNSSEETLTTLDSVVNDKFFDDLQSLIESNGFA');
        $protein->setOrganismName('Saccharomyces cerevisiae (strain ATCC 204508 / S288c)');
        $protein->setGeneName('PFK27');
        $protein->setDescription('6-phosphofructo-2-kinase 2 OS=Saccharomyces cerevisiae (strain ATCC 204508 / S288c) GN=PFK27 PE=1 SV=1');
        $protein->setProteinExistence(1);
        $protein->setSequenceVersion(1);
        
        $fasta = new FastaWriter($filePath, new UniprotFastaEntry());
        $fasta->write($protein);
        $fasta->close();
        
        $fastaReader = new FastaReader($filePath);
        $fastaReader->rewind();
        
        $this->assertEquals($protein, $fastaReader->current());
    }

    /**
     * @covers pgb_liv\php_ms\Writer\FastaWriter::__construct
     * @covers pgb_liv\php_ms\Writer\FastaWriter::write
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeHeader
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeDescription
     * @covers pgb_liv\php_ms\Writer\FastaWriter::writeSequence
     * @covers pgb_liv\php_ms\Writer\FastaWriter::close
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Core\Database\Fasta\PeffFastaEntry::getProtein
     * @covers pgb_liv\php_ms\Core\Database\Fasta\PeffFastaEntry::getDescription
     * @covers pgb_liv\php_ms\Core\Database\Fasta\PeffFastaEntry::getHeader
     *
     * @uses pgb_liv\php_ms\Core\Database\Fasta\PeffFastaEntry
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Writer\FastaWriter
     *       @group peff
     */
    public function testCanWritePeffEntry()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'FastaWriterTest');
        
        $protein = new Protein();
        $protein->setUniqueIdentifier('sp:Q12471');
        $protein->setDatabasePrefix('sp');
        $protein->setAccession('Q12471');
        $protein->setEntryName('6P22_YEAST');
        $protein->setName('6-phosphofructo-2-kinase 2');
        $protein->setSequence('MGGSSDSDSHDGYLTSEYNSSNSLFSLNTGNSYSSASLDRATLDCQDSVFFDNHKSSLLS' . 'TEVPRFISNDPLHLPITLNYKRDNADPTYTNGKVNKFMIVLIGLPATGKSTISSHLIQCL' . 'KNNPLTNSLRCKVFNAGKIRRQISCATISKPLLLSNTSSEDLFNPKNNDKKETYARITLQ' . 'KLFHEINNDECDVGIFDATNSTIERRRFIFEEVCSFNTDELSSFNLVPIILQVSCFNRSF' . 'IKYNIHNKSFNEDYLDKPYELAIKDFAKRLKHYYSQFTPFSLDEFNQIHRYISQHEEIDT' . 'SLFFFNVINAGVVEPHSLNQSHYPSTCGKQIRDTIMVIENFINHYSQMFGFEYIEAVKLF' . 'FESFGNSSEETLTTLDSVVNDKFFDDLQSLIESNGFA');
        $protein->setOrganismName('Saccharomyces cerevisiae (strain ATCC 204508 / S288c)');
        $protein->setGeneName('PFK27');
        $protein->setDescription('\DbUniqueId=Q12471 \CC=6P22_YEAST \Pname=6-phosphofructo-2-kinase 2 \Gname=PFK27 \TaxName=Saccharomyces cerevisiae (strain ATCC 204508 / S288c) \SV=1 \PE=1');
        $protein->setProteinExistence('1');
        $protein->setSequenceVersion('1');
        
        $fasta = new FastaWriter($filePath, new PeffFastaEntry());
        $fasta->write($protein);
        $fasta->close();
        
        $fastaReader = new FastaReader($filePath);
        $fastaReader->rewind();
        
        $this->assertEquals($protein, $fastaReader->current());
    }

    /**
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
