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

use pgb_liv\php_ms\Core\Chromosome;

class ChromosomeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\Chromosome::setName
     * @covers pgb_liv\php_ms\Core\Chromosome::getName
     *
     * @uses pgb_liv\php_ms\Core\Chromosome
     */
    public function testCanGetSetName()
    {
        $value = 'Chr1';
        $chromosome = new Chromosome();
        
        $chromosome->setName($value);
        
        $this->assertEquals($value, $chromosome->getName());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Chromosome::setStrand
     * @covers pgb_liv\php_ms\Core\Chromosome::getStrand
     *
     * @uses pgb_liv\php_ms\Core\Chromosome
     */
    public function testCanGetSetStrand()
    {
        $value = '+';
        $chromosome = new Chromosome();
        
        $chromosome->setStrand($value);
        
        $this->assertEquals($value, $chromosome->getStrand());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Chromosome::setGenomeReferenceVersion
     * @covers pgb_liv\php_ms\Core\Chromosome::getGenomeReferenceVersion
     *
     * @uses pgb_liv\php_ms\Core\Chromosome
     */
    public function testCanGetSetGenomeReferenceVersion()
    {
        $value = '1.0';
        $chromosome = new Chromosome();
        
        $chromosome->setGenomeReferenceVersion($value);
        
        $this->assertEquals($value, $chromosome->getGenomeReferenceVersion());
    }
}
