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

use pgb_liv\php_ms\Core\Peptide;

class PeptideTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::__construct
     * @covers pgb_liv\php_ms\Core\Peptide::getSequence
     * @covers pgb_liv\php_ms\Core\Peptide::getLength
     * @covers pgb_liv\php_ms\Core\Peptide::calculateMass
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanRetrieveEntry()
    {
        $sequence = 'PEPTIDE';
        $peptide = new Peptide($sequence);
        
        $this->assertEquals($sequence, $peptide->getSequence());
        $this->assertEquals(strlen($sequence), $peptide->getLength());
        $this->assertEquals(799.359965, $peptide->calculateMass());
    }
}
