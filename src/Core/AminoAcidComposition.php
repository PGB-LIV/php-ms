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
namespace pgb_liv\php_ms\Core;

/**
 * Get molecular formula for common amino acids.
 *
 * @author Andrew Collins
 */
class AminoAcidComposition
{

    const A = 'C3H7NO2';

    const R = 'C6H14N4O2';

    const N = 'C4H8N2O3';

    const D = 'C4H7NO4';

    const C = 'C3H7NO2S';

    const Q = 'C5H10N2O3';

    const E = 'C5H9NO4';

    const G = 'C2H5NO2';

    const H = 'C6H9N3O2';

    const I = 'C6H13NO2';

    const L = 'C6H13NO2';

    const K = 'C6H14N2O2';

    const M = 'C5H11NO2S';

    const F = 'C9H11NO2';

    const P = 'C5H9NO2';

    const S = 'C3H7NO3';

    const T = 'C4H9NO3';

    const W = 'C11H12N2O2';

    const Y = 'C9H11NO3';

    const V = 'C5H11NO2';

    /**
     * Gets the molecular formula for the provided amino acid.
     *
     * @param char $acid
     *            Amino acid
     * @throws \InvalidArgumentException If acid is not a single character or valid amino acid
     * @return string Molecular formula
     */
    public static function getFormula($acid)
    {
        $formula = @constant('pgb_liv\php_ms\Core\AminoAcidComposition::' . $acid);
        
        if (is_null($formula)) {
            if (strlen($acid) > 1) {
                throw new \InvalidArgumentException('Value must be a single amino acid. Input was ' . $acid);
            } else {
                throw new \InvalidArgumentException('Value must be a valid amino acid. Input was ' . $acid);
            }
        }
        
        return $formula;
    }

    /**
     * Gets the molecular formula for the provided amino acid.
     *
     * @param char $acid
     *            Amino acid
     * @throws \InvalidArgumentException If acid is not a single character or valid amino acid
     * @return string Molecular formula
     */
    public static function getFormulaInsensitive($acid)
    {
        $acidUp = strtoupper($acid);
        
        return AminoAcidComposition::getFormula($acidUp);
    }
}
