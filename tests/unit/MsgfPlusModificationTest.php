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

use pgb_liv\php_ms\Search\Parameters\MsgfPlusModification;

class MsgfPlusModificationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusModification::__construct
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusModification
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $modification = new MsgfPlusModification(15.994915, 'M', MsgfPlusModification::MOD_TYPE_VARIABLE, 
            MsgfPlusModification::POSITION_ANY, 'Oxidation');
        $this->assertInstanceOf('\pgb_liv\php_ms\Search\Parameters\MsgfPlusModification', $modification);
        
        return $modification;
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusModification::__construct
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusModification::getMass
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusModification::getResidues
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusModification::getModificationType
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusModification::getPosition
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusModification::getName
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusModification::createModificationFile
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusModification
     */
    public function testCanCreateModificationFile()
    {
        $expected = 'NumMods=2' . PHP_EOL . '57.021464,C,fix,any,Carbamidomethyl' . PHP_EOL .
             '15.994915,M,opt,any,Oxidation' . PHP_EOL . '42.010565,K,opt,Prot-N-term,Acetyl' . PHP_EOL .
             '79.966331,STY,opt,any,Phospho';
        
        $modifications = array();
        $modifications[] = new MsgfPlusModification(57.021464, 'C', MsgfPlusModification::MOD_TYPE_FIXED, 
            MsgfPlusModification::POSITION_ANY, 'Carbamidomethyl');
        $modifications[] = new MsgfPlusModification(15.994915, 'M', MsgfPlusModification::MOD_TYPE_VARIABLE, 
            MsgfPlusModification::POSITION_ANY, 'Oxidation');
        $modifications[] = new MsgfPlusModification(42.010565, 'K', MsgfPlusModification::MOD_TYPE_VARIABLE, 
            MsgfPlusModification::POSITION_PROTEIN_NTERM, 'Acetyl');
        $modifications[] = new MsgfPlusModification(79.966331, 'STY', MsgfPlusModification::MOD_TYPE_VARIABLE, 
            MsgfPlusModification::POSITION_ANY, 'Phospho');
        
        $filePath = MsgfPlusModification::createModificationFile($modifications);
        $actual = file_get_contents($filePath);
        
        $this->assertEquals($expected, trim($actual));
    }
}
