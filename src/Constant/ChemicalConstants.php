<?php
/**
 * Copyright 2019 University of Liverpool
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
namespace pgb_liv\php_ms\Constant;

/**
 * Static class containing chemical constant values in daltons.
 *
 * @see https://physics.nist.gov/cgi-bin/Compositions/stand_alone.pl?ele=&all=all
 * @author Andrew Collins
 */
class ChemicalConstants
{

    /**
     * Mass of hydrogen
     *
     * @var double
     */
    const HYDROGEN_MASS = 1.00782503223;

    /**
     * Mass of carbon
     *
     * @var double
     */
    const CARBON_MASS = 12.0;

    /**
     * Mass of nitrogen
     *
     * @var double
     */
    const NITROGEN_MASS = 14.00307400443;

    /**
     * Mass of oxygen
     *
     * @var double
     */
    const OXYGEN_MASS = 15.99491461957;

    /**
     * Mass of phosphorus
     *
     * @var double
     */
    const PHOSPHORUS_MASS = 30.97376199842;

    /**
     * Mass of selenium
     *
     * @var double
     */
    const SELENIUM_MASS = 79.9165218;
}