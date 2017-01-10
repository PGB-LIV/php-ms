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

use pgb_liv\php_ms\Core\Spectra\SpectraEntry;

class SpectraEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setTitle
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setMassCharge
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setCharge
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setScans
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setRetentionTime
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getTitle
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getMassCharge
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getCharge
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getScans
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getRetentionTime
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanRetrieveEntry()
    {
        $title = 'VH_181016_Digest_mix_1.16140.16140.3 (intensity=192543543.5801)';
        $massCharge = 370.217742939639;
        $charge = 3;
        $scans = 16140;
        $rt = 1854.661;
        
        $spectra = new SpectraEntry();
        $spectra->setTitle($title);
        $spectra->setMassCharge($massCharge);
        $spectra->setCharge($charge);
        $spectra->setScans($scans);
        $spectra->setRetentionTime($rt);
        
        $this->assertEquals($title, $spectra->getTitle());
        $this->assertEquals($massCharge, $spectra->getMassCharge());
        $this->assertEquals($charge, $spectra->getCharge());
        $this->assertEquals($scans, $spectra->getScans());
        $this->assertEquals($rt, $spectra->getRetentionTime());
        
        // TODO: Add MS2 testing
    }
}
