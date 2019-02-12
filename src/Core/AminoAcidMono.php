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
namespace pgb_liv\php_ms\Core;

/**
 * Monoisotopic masses for common amino acids.
 *
 * @author Andrew Collins
 */
class AminoAcidMono
{

    const A = 71.0371137852;

    const R = 156.1011110241;

    const N = 114.0429274414;

    const D = 115.0269430243;

    const C = 103.0091849596;

    const E = 129.0425930888;

    const Q = 128.0585775058;

    const G = 57.0214637207;

    const H = 137.0589118585;

    const I = 113.0840639785;

    const L = 113.0840639785;

    const K = 128.0949630152;

    const M = 131.0404850885;

    const F = 147.0684139141;

    const P = 97.0527638496;

    const S = 87.0320284047;

    const T = 101.0476784692;

    const W = 186.0793129507;

    const Y = 163.0633285336;

    const V = 99.0684139141;

    const U = 150.9536355852;

    /**
     * Gets the monoisotopic mass for the provided amino acid.
     *
     * @param string $acid
     *            Amino acid
     * @throws \InvalidArgumentException If acid is not a single character or valid amino acid
     * @return float Monoisotopic mass
     */
    public static function getMonoisotopicMass($acid)
    {
        $value = @constant('pgb_liv\php_ms\Core\AminoAcidMono::' . $acid);

        if (! is_null($value)) {
            return $value;
        }

        if (strlen($acid) > 1) {
            throw new \InvalidArgumentException('Value must be a single amino acid. Input was ' . $acid);
        }

        throw new \InvalidArgumentException('Value must be a valid amino acid. Input was ' . $acid);
    }

    /**
     * Gets the monoisotopic mass for the provided amino acid.
     *
     * @param string $acid
     *            Amino acid
     * @throws \InvalidArgumentException If acid is not a single character or valid amino acid
     * @return float Monoisotopic mass
     */
    public static function getMonoisotopicInsensitive($acid)
    {
        $acidUp = strtoupper($acid);

        return self::getMonoisotopicMass($acidUp);
    }
}
