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

use pgb_liv\php_ms\Utility\Filter\FilterLength;
use pgb_liv\php_ms\Core\Peptide;

class FilterLengthTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $filter = new FilterLength(6, 30);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Filter\FilterLength', $filter);

        return $filter;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments1()
    {
        $filter = new FilterLength('One', 30);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Filter\FilterLength', $filter);

        return $filter;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments2()
    {
        $filter = new FilterLength(5, 'Ten');
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Filter\FilterLength', $filter);

        return $filter;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments3()
    {
        $filter = new FilterLength(null, null);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Filter\FilterLength', $filter);

        return $filter;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments4()
    {
        $filter = new FilterLength();
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Filter\FilterLength', $filter);

        return $filter;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::isValidPeptide
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testCanValidateEntryInBounds()
    {
        $peptide = new Peptide();
        $peptide->setSequence('PEPTIDE');

        $filter = new FilterLength(6, 30);

        $this->assertTrue($filter->isValidPeptide($peptide));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::isValidPeptide
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testCanValidateEntryOnBounds()
    {
        $peptideShort = new Peptide('PEPTIDE');
        $peptideShort->setSequence('PEPTIDE');
        $peptideLong = new Peptide('PEPTIDEPEPTIDE');
        $peptideLong->setSequence('PEPTIDEPEPTIDE');

        $filter = new FilterLength(7, 14);

        $this->assertTrue($filter->isValidPeptide($peptideShort));
        $this->assertTrue($filter->isValidPeptide($peptideLong));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::isValidPeptide
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testCanValidateEntryOutOfBounds()
    {
        $peptideShort = new Peptide('PEPTIDE');
        $peptideShort->setSequence('PEPTIDE');
        $peptideLong = new Peptide('PEPTIDEPEPTIDEPEPTIDEPEPTIDEPEPTIDE');
        $peptideLong->setSequence('PEPTIDEPEPTIDEPEPTIDEPEPTIDEPEPTIDE');

        $filter = new FilterLength(10, 15);

        $this->assertFalse($filter->isValidPeptide($peptideShort));
        $this->assertFalse($filter->isValidPeptide($peptideLong));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::isValidPeptide
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::filterPeptide
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     * @uses pgb_liv\php_ms\Utility\Filter\AbstractFilter
     */
    public function testCanValidateEntryArray()
    {
        $peptides = array();
        $peptides[0] = new Peptide('PEPTIDE');
        $peptides[0]->setSequence('PEPTIDE');
        $validPeptide = new Peptide('PEPTIDEPEPTIDE');
        $validPeptide->setSequence('PEPTIDEPEPTIDE');
        $peptides[1] = $validPeptide;
        $peptides[2] = new Peptide('PEPTIDEPEPTIDEPEPTIDEPEPTIDEPEPTIDE');
        $peptides[2]->setSequence('PEPTIDEPEPTIDEPEPTIDEPEPTIDEPEPTIDE');

        $filter = new FilterLength(10, 15);

        $this->assertEquals(array(
            1 => $validPeptide
        ), $filter->filterPeptide($peptides));
    }
}
