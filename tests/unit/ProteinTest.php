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
use pgb_liv\php_ms\Core\Chromosome;

class ProteinTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @covers pgb_liv\php_ms\Core\Protein::geIdentifier
     * @covers pgb_liv\php_ms\Core\Protein::getDescription
     * @covers pgb_liv\php_ms\Core\Protein::getSequence
     * @covers pgb_liv\php_ms\Core\Protein::getChromosome
     * @covers pgb_liv\php_ms\Core\Protein::setIdentifier
     * @covers pgb_liv\php_ms\Core\Protein::setDescription
     * @covers pgb_liv\php_ms\Core\Protein::setSequence
     * @covers pgb_liv\php_ms\Core\Protein::reverseSequence
     * @covers pgb_liv\php_ms\Core\Protein::setChromosome
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
        $chromosome = new Chromosome();

        $description = $proteinName . ' OS=' . $organism . ' GN=' . $geneName . ' PE=' . $pe . ' SV=' . $sv;
        $sequence = 'MERASLIQKAKLAEQAERYEDMAAFMKGAVEKGEELSCEERNLLSVAYKNVVGGQRAAWRVLSSIEQKSNEEGSEEKGPEVREYREKVETELQGVCDTVLGLLDSHLIKEAGDAESRVFYLKMKGDYYRYLAEVATGDDKKRIIDSARSAYQEAMDISKKEMPPTNPIRLGLALNFSVFHYEIANSPEEAISLAKTTFDEAMADLHTLSEDSYKDSTLIMQLLRDNLTLWTADNAGEEGGEAPQEPQS';

        $protein = new Protein();
        $protein->setSequence($sequence);
        $protein->setIdentifier($identifier);

        $protein->setDescription($description);
        $protein->setChromosome($chromosome);

        $this->assertEquals($identifier, $protein->getIdentifier());
        $this->assertEquals($description, $protein->getDescription());
        $this->assertEquals($sequence, $protein->getSequence());

        $this->assertEquals($chromosome, $protein->getChromosome());

        $protein->reverseSequence();
        $this->assertEquals(strrev($sequence), $protein->getSequence());
    }
}
