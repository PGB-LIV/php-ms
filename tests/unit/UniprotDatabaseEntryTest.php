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

use pgb_liv\php_ms\Core\Database\UniprotDatabaseEntry;

class UniprotDatabaseEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\Database\UniProtDatabaseEntry::__construct
     *
     * @uses pgb_liv\php_ms\Core\Database\UniProtDatabaseEntry
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $uniprot = new UniprotDatabaseEntry('sp|P31947|1433S_HUMAN', '14-3-3 protein sigma OS=Homo sapiens GN=SFN PE=1 SV=1', 'MERASLIQKAKLAEQAERYEDMAAFMKGAVEKGEELSCEERNLLSVAYKNVVGGQRAAWRVLSSIEQKSNEEGSEEKGPEVREYREKVETELQGVCDTVLGLLDSHLIKEAGDAESRVFYLKMKGDYYRYLAEVATGDDKKRIIDSARSAYQEAMDISKKEMPPTNPIRLGLALNFSVFHYEIANSPEEAISLAKTTFDEAMADLHTLSEDSYKDSTLIMQLLRDNLTLWTADNAGEEGGEAPQEPQS');
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Core\Database\UniProtDatabaseEntry', $uniprot);
        
        return $uniprot;
    }

    /**
     * @covers pgb_liv\php_ms\Core\Database\UniProtDatabaseEntry::__construct
     *
     * @uses pgb_liv\php_ms\Core\Database\UniProtDatabaseEntry
     */
    public function testCanRetrieveEntry()
    {
        $database = 'sp';
        $accession = 'P31947';
        $entryName = '1433S_HUMAN';
        $identifier = $database . '|' . $accession . '|' . $entryName;
        
        $organism = 'Homo sapiens';
        $geneName = 'SFN';
        $pe = 1;
        $sv = 1;
        
        $description = '14-3-3 protein sigma OS=' . $organism . ' GN=' . $geneName . ' PE=' . $pe . ' SV=' . $sv;
        $sequence = 'MERASLIQKAKLAEQAERYEDMAAFMKGAVEKGEELSCEERNLLSVAYKNVVGGQRAAWRVLSSIEQKSNEEGSEEKGPEVREYREKVETELQGVCDTVLGLLDSHLIKEAGDAESRVFYLKMKGDYYRYLAEVATGDDKKRIIDSARSAYQEAMDISKKEMPPTNPIRLGLALNFSVFHYEIANSPEEAISLAKTTFDEAMADLHTLSEDSYKDSTLIMQLLRDNLTLWTADNAGEEGGEAPQEPQS';
        
        $uniprot = new UniprotDatabaseEntry($identifier, $description, $sequence);
        var_dump($uniprot);
        
        $this->assertEquals($identifier, $uniprot->getIdentifier());
        $this->assertEquals($description, $uniprot->getDescription());
        $this->assertEquals($sequence, $uniprot->getSequence());
        
        $this->assertEquals('UniProtKB/Swiss-Prot', $uniprot->getDatabase());
        $this->assertEquals($accession, $uniprot->getAccession());
        $this->assertEquals($entryName, $uniprot->getEntryName());
        
        $this->assertEquals($organism, $uniprot->getOrganismName());
        $this->assertEquals($geneName, $uniprot->getGeneName());
        $this->assertEquals($pe, $uniprot->getProteinExistence());
        $this->assertEquals($sv, $uniprot->getSequenceVersion());
    }
}
