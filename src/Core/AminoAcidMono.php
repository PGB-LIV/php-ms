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
 * Monoisotopic masses for common amino acids.
 *
 * @author Andrew Collins
 */
class AminoAcidMono
{

    const A = 71.037114;

    const C = 103.009185;

    const D = 115.026943;

    const E = 129.042593;

    const F = 147.068414;

    const G = 57.021464;

    const H = 137.058912;

    const I = 113.084064;

    const K = 128.094963;

    const L = 113.084064;

    const M = 131.040485;

    const N = 114.042927;

    const P = 97.052764;

    const Q = 128.058578;

    const R = 156.101111;

    const S = 87.032028;

    const T = 101.047679;

    const U = 150.95363;

    const V = 99.068414;

    const W = 186.079313;

    const Y = 163.06332;

    const a = A;

    const c = C;

    const d = D;

    const e = E;

    const f = F;

    const g = G;

    const h = H;

    const i = I;

    const k = K;

    const l = L;

    const m = M;

    const n = N;

    const p = P;

    const q = Q;

    const r = R;

    const s = S;

    const t = T;

    const u = U;

    const v = V;

    const w = W;

    const y = Y;

    public static function getMonoisotopicMass($acid)
    {    	
        $value = @constant('pgb_liv\php_ms\Core\AminoAcidMono::' . $acid);
        
        if (is_null($value))
        {
	    	if (strlen($acid) > 1)
	    	{
	    		throw new \InvalidArgumentException('Value must be a single amino acid. Input was '. $acid);
	    	}
	    	else
	    	{
	    		throw new \InvalidArgumentException('Value must be a valid amino acid. Input was '. $acid);
	    	}        	
        }
        
        return $value;
    }
}
