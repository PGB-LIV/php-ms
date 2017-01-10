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
     * @covers pgb_liv\php_ms\Core\Protein::__construct
     *
     * @uses pgb_liv\php_ms\Core\Protein
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $uniprot = new Protein();
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Core\Protein', $uniprot);
        
        return $uniprot;
    }

    /**
     * @covers pgb_liv\php_ms\Core\Protein::__construct
     * @covers pgb_liv\php_ms\Core\Protein::getIdentifier
     * @covers pgb_liv\php_ms\Core\Protein::getDescription
     * @covers pgb_liv\php_ms\Core\Protein::getSequence
     * @covers pgb_liv\php_ms\Core\Protein::getDatabasePrefix
     * @covers pgb_liv\php_ms\Core\Protein::getAccession
     * @covers pgb_liv\php_ms\Core\Protein::getEntryName
     * @covers pgb_liv\php_ms\Core\Protein::getOrganismName
     * @covers pgb_liv\php_ms\Core\Protein::getGeneName
     * @covers pgb_liv\php_ms\Core\Protein::getProteinExistence
     * @covers pgb_liv\php_ms\Core\Protein::getSequenceVersion
     * @covers pgb_liv\php_ms\Core\Protein::setIdentifier
     * @covers pgb_liv\php_ms\Core\Protein::setDescription
     * @covers pgb_liv\php_ms\Core\Protein::setSequence
     * @covers pgb_liv\php_ms\Core\Protein::setDatabasePrefix
     * @covers pgb_liv\php_ms\Core\Protein::setAccession
     * @covers pgb_liv\php_ms\Core\Protein::setEntryName
     * @covers pgb_liv\php_ms\Core\Protein::setOrganismName
     * @covers pgb_liv\php_ms\Core\Protein::setGeneName
     * @covers pgb_liv\php_ms\Core\Protein::setProteinExistence
     * @covers pgb_liv\php_ms\Core\Protein::setSequenceVersion
     *
     * @uses pgb_liv\php_ms\Core\Protein
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
        
        $protein = new Protein();
        $protein->setSequence($sequence);
        $protein->setUniqueIdentifier($identifier);
        $protein->setDatabasePrefix($database);
        $protein->setAccession($accession);
        $protein->setEntryName($entryName);
        
        $protein->setDescription($description);
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
        
        $this->assertEquals($organism, $protein->getOrganismName());
        $this->assertEquals($geneName, $protein->getGeneName());
        $this->assertEquals($pe, $protein->getProteinExistence());
        $this->assertEquals($sv, $protein->getSequenceVersion());
    }
}
