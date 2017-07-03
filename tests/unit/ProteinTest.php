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

use pgb_liv\php_ms\Core\Protein;

class ProteinTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\Protein::getUniqueIdentifier
     * @covers pgb_liv\php_ms\Core\Protein::getDescription
     * @covers pgb_liv\php_ms\Core\Protein::getSequence
     * @covers pgb_liv\php_ms\Core\Protein::getDatabasePrefix
     * @covers pgb_liv\php_ms\Core\Protein::getAccession
     * @covers pgb_liv\php_ms\Core\Protein::getEntryName
     * @covers pgb_liv\php_ms\Core\Protein::getOrganismName
     * @covers pgb_liv\php_ms\Core\Protein::getGeneName
     * @covers pgb_liv\php_ms\Core\Protein::getName
     * @covers pgb_liv\php_ms\Core\Protein::getProteinExistence
     * @covers pgb_liv\php_ms\Core\Protein::getSequenceVersion
     * @covers pgb_liv\php_ms\Core\Protein::setUniqueIdentifier
     * @covers pgb_liv\php_ms\Core\Protein::setDescription
     * @covers pgb_liv\php_ms\Core\Protein::setSequence
     * @covers pgb_liv\php_ms\Core\Protein::setDatabasePrefix
     * @covers pgb_liv\php_ms\Core\Protein::setAccession
     * @covers pgb_liv\php_ms\Core\Protein::setEntryName
     * @covers pgb_liv\php_ms\Core\Protein::setOrganismName
     * @covers pgb_liv\php_ms\Core\Protein::setGeneName
     * @covers pgb_liv\php_ms\Core\Protein::setName
     * @covers pgb_liv\php_ms\Core\Protein::setProteinExistence
     * @covers pgb_liv\php_ms\Core\Protein::setSequenceVersion
     * @covers pgb_liv\php_ms\Core\Protein::reverseSequence
     *
     * @uses pgb_liv\php_ms\Core\Protein
     */
    public function testCanRetrieveEntry()
    {
        $database = 'sp';
        $accession = 'P31947';
        $entryName = '1433S_HUMAN';
        $identifier = $database . '|' . $accession . '|' . $entryName;
        
        $proteinName = '14-3-3 protein sigma';
        $organism = 'Homo sapiens';
        $geneName = 'SFN';
        $pe = 1;
        $sv = 1;
        
        $description = $proteinName . ' OS=' . $organism . ' GN=' . $geneName . ' PE=' . $pe . ' SV=' . $sv;
        $sequence = 'MERASLIQKAKLAEQAERYEDMAAFMKGAVEKGEELSCEERNLLSVAYKNVVGGQRAAWRVLSSIEQKSNEEGSEEKGPEVREYREKVETELQGVCDTVLGLLDSHLIKEAGDAESRVFYLKMKGDYYRYLAEVATGDDKKRIIDSARSAYQEAMDISKKEMPPTNPIRLGLALNFSVFHYEIANSPEEAISLAKTTFDEAMADLHTLSEDSYKDSTLIMQLLRDNLTLWTADNAGEEGGEAPQEPQS';
        
        $protein = new Protein();
        $protein->setSequence($sequence);
        $protein->setUniqueIdentifier($identifier);
        $protein->setDatabasePrefix($database);
        $protein->setAccession($accession);
        $protein->setEntryName($entryName);
        
        $protein->setDescription($description);
        $protein->setName($proteinName);
        $protein->setOrganismName($organism);
        $protein->setGeneName($geneName);
        $protein->setProteinExistence($pe);
        $protein->setSequenceVersion($sv);
        
        $this->assertEquals($identifier, $protein->getUniqueIdentifier());
        $this->assertEquals($description, $protein->getDescription());
        $this->assertEquals($sequence, $protein->getSequence());
        
        $this->assertEquals($database, $protein->getDatabasePrefix());
        $this->assertEquals($accession, $protein->getAccession());
        $this->assertEquals($entryName, $protein->getEntryName());
        
        $this->assertEquals($proteinName, $protein->getName());
        $this->assertEquals($organism, $protein->getOrganismName());
        $this->assertEquals($geneName, $protein->getGeneName());
        $this->assertEquals($pe, $protein->getProteinExistence());
        $this->assertEquals($sv, $protein->getSequenceVersion());
        
        $protein->reverseSequence();
        $this->assertEquals(strrev($sequence), $protein->getSequence());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Protein::setDatabasePrefix
     * @covers pgb_liv\php_ms\Core\Protein::setDatabasePrefix
     *
     * @uses pgb_liv\php_ms\Core\Protein
     */
    public function testCanGetDatabaseName()
    {
        $protein = new Protein();
        
        $protein->setDatabasePrefix('sp');
        $this->assertEquals('UniProtKB/Swiss-Prot', $protein->getDatabaseName(), $protein->getDatabasePrefix() .' is not mapped to UniProtKB/Swiss-Prot');
        
        $protein->setDatabasePrefix('tr');
        $this->assertEquals('UniProtKB/TrEMBL', $protein->getDatabaseName(), $protein->getDatabasePrefix() .' is not mapped to UniProtKB/TrEMBL');
        
        $protein->setDatabasePrefix('nxp');
        $this->assertEquals('NeXtProt', $protein->getDatabaseName(), $protein->getDatabasePrefix() .' is not mapped to NeXtProt');
    }
}
