<?php
/**
 * Copyright 2020 University of Liverpool
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
 * Static class containing common molecular mass values in daltons.
 *
 * @see https://physics.nist.gov/cgi-bin/Compositions/stand_alone.pl?ele=&all=all
 * @author Andrew Collins
 * @todo Re-use chemical constants (Require: PHP 5.6)
 */
class MoleculeConstants
{

    /**
     * Mass of water (H2O)
     *
     * @var double
     */
    const WATER_MASS = 18.01056468403;

    /**
     * Mass of amonia (NH3)
     *
     * @var double
     */
    const AMONIA_MASS = 17.02654910112;

    /**
     * Mass of phospho (HO3P)
     *
     * @var double
     */
    const PHOSPHO_MASS = 79.96633088936;
}
