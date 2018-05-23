<?php
/**
 * Copyright 2018 University of Liverpool
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

use pgb_liv\php_ms\Constant\ChemicalConstants;
use pgb_liv\php_ms\Core\Peptide;

/**
 * Generates the C ions from a peptide
 *
 * @author Andrew Collins
 */
class CFragment extends AbstractFragment implements FragmentInterface
{

    /**
     *
     * {@inheritdoc}
     */
    protected function getAdditiveMass()
    {
        return Peptide::N_TERM_MASS + ChemicalConstants::NITROGEN_MASS + ChemicalConstants::HYDROGEN_MASS + ChemicalConstants::HYDROGEN_MASS;
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function getEnd()
    {
        return parent::getEnd() - 1;
    }
}
