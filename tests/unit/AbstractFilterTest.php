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

use pgb_liv\php_ms\Utility\Filter\AbstractFilter;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Spectra\SpectraEntry;

class AbstractFilterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractFilter::isValidPeptide
     * @expectedException BadMethodCallException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\AbstractFilter
     */
    public function testCanValidiateUnimplementedIsValidPeptide()
    {
        $stub = $this->getMockForAbstractClass('pgb_liv\php_ms\Utility\Filter\AbstractFilter');
        
        $stub->isValidPeptide(new Peptide('PEPTIDE'));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractFilter::isValidSpectra
     * @expectedException BadMethodCallException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\AbstractFilter
     */
    public function testCanValidiateUnimplementedIsValidSpectra()
    {
        $stub = $this->getMockForAbstractClass('pgb_liv\php_ms\Utility\Filter\AbstractFilter');
        
        $stub->isValidSpectra(new SpectraEntry());
    }
}
