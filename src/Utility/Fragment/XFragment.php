<?php
/**
 * Copyright 2017 University of Liverpool
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
 * Generates the X ions from a peptide
 *
 * @author Andrew Collins
 */
class XFragment extends AbstractFragmentReverse implements FragmentInterface
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getAdditiveMass()
     */
    protected function getAdditiveMass()
    {
        // CTerm + CO-H
        return (Peptide::C_TERM_MASS + 12 + Peptide::OXYGEN_MASS + Peptide::PROTON_MASS) - Peptide::HYDROGEN_MASS;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getStart()
     */
    protected function getStart()
    {
        return 1;
    }
}