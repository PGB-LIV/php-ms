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
use pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry;

class FastaReaderTest extends \PHPUnit_Framework_TestCase
{

    private function createTestFile(&$fastaEntries, $whitespace = false)
    {
        $fastaEntries[] = UniprotFastaEntry::getProtein('sp|P31947|1433S_HUMAN', '14-3-3 protein sigma OS=Homo sapiens GN=SFN PE=1 SV=1', 'MERASLIQKAKLAEQAERYEDMAAFMKGAVEKGEELSCEERNLLSVAYKNVVGGQRAAWRVLSSIEQKSNEEGSEEKGPEVREYREKVETELQGVCDTVLGLLDSHLIKEAGDAESRVFYLKMKGDYYRYLAEVATGDDKKRIIDSARSAYQEAMDISKKEMPPTNPIRLGLALNFSVFHYEIANSPEEAISLAKTTFDEAMADLHTLSEDSYKDSTLIMQLLRDNLTLWTADNAGEEGGEAPQEPQS');
        $fastaEntries[] = UniprotFastaEntry::getProtein('sp|P63104|1433Z_HUMAN', '14-3-3 protein zeta/delta OS=Homo sapiens GN=YWHAZ PE=1 SV=1', 'MDKNELVQKAKLAEQAERYDDMAACMKSVTEQGAELSNEERNLLSVAYKNVVGARRSSWRVVSSIEQKTEGAEKKQQMAREYREKIETELRDICNDVLSLLEKFLIPNASQAESKVFYLKMKGDYYRYLAEVAAGDDKKGIVDQSQQAYQEAFEISKKEMQPTHPIRLGLALNFSVFYYEILNSPEKACSLAKTAFDEAIAELDTLSEESYKDSTLIMQLLRDNLTLWTSDTQGDEAEAGEGGEN');
        $fastaEntries[] = UniprotFastaEntry::getProtein('sp|P18462|1A25_HUMAN', 'HLA class I histocompatibility antigen, A-25 alpha chain OS=Homo sapiens GN=HLA-A PE=1 SV=1', 'MAVMAPRTLVLLLSGALALTQTWAGSHSMRYFYTSVSRPGRGEPRFIAVGYVDDTQFVRFDSDAASQRMEPRAPWIEQEGPEYWDRNTRNVKAHSQTDRESLRIALRYYNQSEDGSHTIQRMYGCDVGPDGRFLRGYQQDAYDGKDYIALNEDLRSWTAADMAAQITQRKWETAHEAEQWRAYLEGRCVEWLRRYLENGKETLQRTDAPKTHMTHHAVSDHEATLRCWALSFYPAEITLTWQRDGEDQTQDTELVETRPAGDGTFQKWASVVVPSGQEQRYTCHVQHEGLPKPLTLRWEPSSQPTIPIVGIIAGLVLFGAVIAGAVVAAVMWRRKSSDRKGGSYSQAASSDSAQGSDMSLTACKV');
        $fastaEntries[] = UniprotFastaEntry::getProtein('sp|P30512|1A29_HUMAN', 'HLA class I histocompatibility antigen, A-29 alpha chain OS=Homo sapiens GN=HLA-A PE=1 SV=2', 'MAVMAPRTLLLLLLGALALTQTWAGSHSMRYFTTSVSRPGRGEPRFIAVGYVDDTQFVRFDSDAASQRMEPRAPWIEQEGPEYWDLQTRNVKAQSQTDRANLGTLRGYYNQSEAGSHTIQMMYGCHVGSDGRFLRGYRQDAYDGKDYIALNEDLRSWTAADMAAQITQRKWEAARVAEQLRAYLEGTCVEWLRRYLENGKETLQRTDAPKTHMTHHAVSDHEATLRCWALSFYPAEITLTWQRDGEDQTQDTELVETRPAGDGTFQKWASVVVPSGQEQRYTCHVQHEGLPKPLTLRWEPSSQPTIPIVGIIAGLVLFGAVFAGAVVAAVRWRRKSSDRKGGSYSQAASSDSAQGSDMSLTACKV');
        
        $fasta = '';
        if ($whitespace) {
            $fasta .= "\n";
        }
        
        $fasta .= '>sp|P31947|1433S_HUMAN 14-3-3 protein sigma OS=Homo sapiens GN=SFN PE=1 SV=1
MERASLIQKAKLAEQAERYEDMAAFMKGAVEKGEELSCEERNLLSVAYKNVVGGQRAAWR
VLSSIEQKSNEEGSEEKGPEVREYREKVETELQGVCDTVLGLLDSHLIKEAGDAESRVFY
LKMKGDYYRYLAEVATGDDKKRIIDSARSAYQEAMDISKKEMPPTNPIRLGLALNFSVFH
YEIANSPEEAISLAKTTFDEAMADLHTLSEDSYKDSTLIMQLLRDNLTLWTADNAGEEGG
EAPQEPQS
>sp|P63104|1433Z_HUMAN 14-3-3 protein zeta/delta OS=Homo sapiens GN=YWHAZ PE=1 SV=1
MDKNELVQKAKLAEQAERYDDMAACMKSVTEQGAELSNEERNLLSVAYKNVVGARRSSWR
VVSSIEQKTEGAEKKQQMAREYREKIETELRDICNDVLSLLEKFLIPNASQAESKVFYLK
MKGDYYRYLAEVAAGDDKKGIVDQSQQAYQEAFEISKKEMQPTHPIRLGLALNFSVFYYE
ILNSPEKACSLAKTAFDEAIAELDTLSEESYKDSTLIMQLLRDNLTLWTSDTQGDEAEAG
EGGEN
>sp|P18462|1A25_HUMAN HLA class I histocompatibility antigen, A-25 alpha chain OS=Homo sapiens GN=HLA-A PE=1 SV=1
MAVMAPRTLVLLLSGALALTQTWAGSHSMRYFYTSVSRPGRGEPRFIAVGYVDDTQFVRF
DSDAASQRMEPRAPWIEQEGPEYWDRNTRNVKAHSQTDRESLRIALRYYNQSEDGSHTIQ
RMYGCDVGPDGRFLRGYQQDAYDGKDYIALNEDLRSWTAADMAAQITQRKWETAHEAEQW
RAYLEGRCVEWLRRYLENGKETLQRTDAPKTHMTHHAVSDHEATLRCWALSFYPAEITLT
WQRDGEDQTQDTELVETRPAGDGTFQKWASVVVPSGQEQRYTCHVQHEGLPKPLTLRWEP
SSQPTIPIVGIIAGLVLFGAVIAGAVVAAVMWRRKSSDRKGGSYSQAASSDSAQGSDMSL
TACKV
>sp|P30512|1A29_HUMAN HLA class I histocompatibility antigen, A-29 alpha chain
> OS=Homo sapiens GN=HLA-A PE=1 SV=2
MAVMAPRTLLLLLLGALALTQTWAGSHSMRYFTTSVSRPGRGEPRFIAVGYVDDTQFVRF
DSDAASQRMEPRAPWIEQEGPEYWDLQTRNVKAQSQTDRANLGTLRGYYNQSEAGSHTIQ
MMYGCHVGSDGRFLRGYRQDAYDGKDYIALNEDLRSWTAADMAAQITQRKWEAARVAEQL
RAYLEGTCVEWLRRYLENGKETLQRTDAPKTHMTHHAVSDHEATLRCWALSFYPAEITLT
WQRDGEDQTQDTELVETRPAGDGTFQKWASVVVPSGQEQRYTCHVQHEGLPKPLTLRWEP
SSQPTIPIVGIIAGLVLFGAVFAGAVVAAVRWRRKSSDRKGGSYSQAASSDSAQGSDMSL
TACKV
';
        
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
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Reader\FastaReader::next
     * @covers pgb_liv\php_ms\Reader\FastaReader::key
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::valid
     * @covers pgb_liv\php_ms\Reader\FastaReader::peekLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::getLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::parseEntry
     * @covers pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry::getProtein
     * @covers pgb_liv\php_ms\Core\Database\Fasta\FastaFactory::getProtein
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry
     * @uses pgb_liv\php_ms\Core\Database\Fasta\FastaFactory
     */
    public function testCanRetrieveEntry()
    {
        $fastaEntries = array();
        $fastaPath = $this->createTestFile($fastaEntries);
        
        $fasta = new FastaReader($fastaPath);
        
        $i = 0;
        foreach ($fasta as $key => $entry) {
            $this->assertEquals($fastaEntries[$key - 1], $entry);
            $i ++;
        }
        
        $this->assertEquals($i, count($fastaEntries));
    }

    /**
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Reader\FastaReader::next
     * @covers pgb_liv\php_ms\Reader\FastaReader::key
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::valid
     * @covers pgb_liv\php_ms\Reader\FastaReader::peekLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::getLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::parseEntry
     * @covers pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry::getProtein
     * @covers pgb_liv\php_ms\Core\Database\Fasta\FastaFactory::getProtein
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry
     * @uses pgb_liv\php_ms\Core\Database\Fasta\FastaFactory
     */
    public function testCanRewind()
    {
        $fastaEntries = array();
        $fastaPath = $this->createTestFile($fastaEntries);
        
        $fasta = new FastaReader($fastaPath);
        
        $i = 0;
        foreach ($fasta as $key => $entry) {
            $this->assertEquals($fastaEntries[$key - 1], $entry);
            $i ++;
        }
        
        $this->assertEquals($i, count($fastaEntries));
        
        $i = 0;
        foreach ($fasta as $key => $entry) {
            $this->assertEquals($fastaEntries[$key - 1], $entry);
            $i ++;
        }
        
        $this->assertEquals($i, count($fastaEntries));
    }

    /**
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Reader\FastaReader::next
     * @covers pgb_liv\php_ms\Reader\FastaReader::key
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::valid
     * @covers pgb_liv\php_ms\Reader\FastaReader::peekLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::getLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::parseEntry
     * @covers pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry::getProtein
     * @covers pgb_liv\php_ms\Core\Database\Fasta\FastaFactory::getProtein
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Core\Database\Fasta\UniprotFastaEntry
     * @uses pgb_liv\php_ms\Core\Database\Fasta\FastaFactory
     */
    public function testCanSkipWhitespace()
    {
        $fastaEntries = array();
        $fastaPath = $this->createTestFile($fastaEntries, true);
        
        $fasta = new FastaReader($fastaPath);
        
        $i = 0;
        foreach ($fasta as $key => $entry) {
            $this->assertEquals($fastaEntries[$key - 1], $entry);
            $i ++;
        }
        
        $this->assertEquals($i, count($fastaEntries));
    }
}
