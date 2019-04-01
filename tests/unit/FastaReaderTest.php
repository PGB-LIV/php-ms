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
use pgb_liv\php_ms\Reader\FastaEntry\UniProtFastaEntry;

class FastaReaderTest extends \PHPUnit_Framework_TestCase
{

    private function createTestFile(&$fastaEntries, $whitespace = false)
    {
        $entry = UniProtFastaEntry::getProtein('sp|P31947|1433S_HUMAN',
            '14-3-3 protein sigma OS=Homo sapiens GN=SFN PE=1 SV=1');
        $entry->setSequence(
            'MERASLIQKAKLAEQAERYEDMAAFMKGAVEKGEELSCEERNLLSVAYKNVVGGQRAAWRVLSSIEQKSNEEGSEEKGPEVREYREKVETELQGVCDTVLGLLDSHLIKEAGDAESRVFYLKMKGDYYRYLAEVATGDDKKRIIDSARSAYQEAMDISKKEMPPTNPIRLGLALNFSVFHYEIANSPEEAISLAKTTFDEAMADLHTLSEDSYKDSTLIMQLLRDNLTLWTADNAGEEGGEAPQEPQS');
        $entry->setIdentifier('sp|P31947|1433S_HUMAN');
        $fastaEntries[] = $entry;

        $entry = UniProtFastaEntry::getProtein('sp|P63104|1433Z_HUMAN',
            '14-3-3 protein zeta/delta OS=Homo sapiens GN=YWHAZ PE=1 SV=1');
        $entry->setSequence(
            'MDKNELVQKAKLAEQAERYDDMAACMKSVTEQGAELSNEERNLLSVAYKNVVGARRSSWRVVSSIEQKTEGAEKKQQMAREYREKIETELRDICNDVLSLLEKFLIPNASQAESKVFYLKMKGDYYRYLAEVAAGDDKKGIVDQSQQAYQEAFEISKKEMQPTHPIRLGLALNFSVFYYEILNSPEKACSLAKTAFDEAIAELDTLSEESYKDSTLIMQLLRDNLTLWTSDTQGDEAEAGEGGEN');
        $entry->setIdentifier('sp|P63104|1433Z_HUMAN');
        $fastaEntries[] = $entry;

        $entry = UniProtFastaEntry::getProtein('sp|P18462|1A25_HUMAN',
            'HLA class I histocompatibility antigen, A-25 alpha chain OS=Homo sapiens GN=HLA-A PE=1 SV=1');
        $entry->setSequence(
            'MAVMAPRTLVLLLSGALALTQTWAGSHSMRYFYTSVSRPGRGEPRFIAVGYVDDTQFVRFDSDAASQRMEPRAPWIEQEGPEYWDRNTRNVKAHSQTDRESLRIALRYYNQSEDGSHTIQRMYGCDVGPDGRFLRGYQQDAYDGKDYIALNEDLRSWTAADMAAQITQRKWETAHEAEQWRAYLEGRCVEWLRRYLENGKETLQRTDAPKTHMTHHAVSDHEATLRCWALSFYPAEITLTWQRDGEDQTQDTELVETRPAGDGTFQKWASVVVPSGQEQRYTCHVQHEGLPKPLTLRWEPSSQPTIPIVGIIAGLVLFGAVIAGAVVAAVMWRRKSSDRKGGSYSQAASSDSAQGSDMSLTACKV');
        $entry->setIdentifier('sp|P18462|1A25_HUMAN');
        $fastaEntries[] = $entry;

        $entry = UniProtFastaEntry::getProtein('sp|P30512|1A29_HUMAN',
            'HLA class I histocompatibility antigen, A-29 alpha chain OS=Homo sapiens GN=HLA-A PE=1 SV=2');
        $entry->setSequence(
            'MAVMAPRTLLLLLLGALALTQTWAGSHSMRYFTTSVSRPGRGEPRFIAVGYVDDTQFVRFDSDAASQRMEPRAPWIEQEGPEYWDLQTRNVKAQSQTDRANLGTLRGYYNQSEAGSHTIQMMYGCHVGSDGRFLRGYRQDAYDGKDYIALNEDLRSWTAADMAAQITQRKWEAARVAEQLRAYLEGTCVEWLRRYLENGKETLQRTDAPKTHMTHHAVSDHEATLRCWALSFYPAEITLTWQRDGEDQTQDTELVETRPAGDGTFQKWASVVVPSGQEQRYTCHVQHEGLPKPLTLRWEPSSQPTIPIVGIIAGLVLFGAVFAGAVVAAVRWRRKSSDRKGGSYSQAASSDSAQGSDMSLTACKV');
        $entry->setIdentifier('sp|P30512|1A29_HUMAN');
        $fastaEntries[] = $entry;

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
     *
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
     *
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Reader\FastaReader::next
     * @covers pgb_liv\php_ms\Reader\FastaReader::key
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::valid
     * @covers pgb_liv\php_ms\Reader\FastaReader::peekLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::getLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::parseEntry
     * @covers pgb_liv\php_ms\Reader\FastaEntry\UniProtFastaEntry::getProtein
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Reader\FastaEntry\UniProtFastaEntry
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
     *
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Reader\FastaReader::next
     * @covers pgb_liv\php_ms\Reader\FastaReader::key
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::valid
     * @covers pgb_liv\php_ms\Reader\FastaReader::peekLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::getLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::parseEntry
     * @covers pgb_liv\php_ms\Reader\FastaEntry\UniProtFastaEntry::getProtein
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Reader\FastaEntry\UniProtFastaEntry
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
     *
     * @covers pgb_liv\php_ms\Reader\FastaReader::__construct
     * @covers pgb_liv\php_ms\Reader\FastaReader::current
     * @covers pgb_liv\php_ms\Reader\FastaReader::next
     * @covers pgb_liv\php_ms\Reader\FastaReader::key
     * @covers pgb_liv\php_ms\Reader\FastaReader::rewind
     * @covers pgb_liv\php_ms\Reader\FastaReader::valid
     * @covers pgb_liv\php_ms\Reader\FastaReader::peekLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::getLine
     * @covers pgb_liv\php_ms\Reader\FastaReader::parseEntry
     * @covers pgb_liv\php_ms\Reader\FastaEntry\UniProtFastaEntry::getProtein
     *
     * @uses pgb_liv\php_ms\Reader\FastaReader
     * @uses pgb_liv\php_ms\Reader\FastaEntry\UniProtFastaEntry
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
