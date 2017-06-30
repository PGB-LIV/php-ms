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
namespace pgb_liv\php_ms\Utility\Fragment;

use pgb_liv\php_ms\Core\Peptide;

/**
 * Abstract class containing generic filtering methods
 *
 * @author Andrew Collins
 */
class YFragment extends AbstractFragment
{
    public function __construct(Peptide $peptide)
    {
        $this->setIsReversed(true);
        parent::__construct($peptide);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getNTerminusMass()
     */
    public function getNTerminusMass()
    {
        $mass = Peptide::C_TERM_MASS;
        $mass += Peptide::HYDROGEN_MASS;
        $mass += Peptide::PROTON_MASS;
        
        return $mass;
    }
}
