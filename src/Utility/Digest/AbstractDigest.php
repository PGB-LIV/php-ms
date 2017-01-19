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
namespace pgb_liv\php_ms\Utility\Digest;

/**
 * Abstract class for digestion algorithms.
 *
 * @author Andrew Collins
 */
abstract class AbstractDigest
{

    /**
     * Maximum number of missed cleavages a peptide may contain
     *
     * @var integer
     */
    protected $maxMissedCleavage = 0;

    /**
     * Set the maximum number of missed cleavages the algorithm should produce.
     * By default no missed cleavages are produced.
     *
     * @param int $maxMissedCleavage
     *            Maximum number of cleavages to account for
     */
    public function setMaxMissedCleavage($maxMissedCleavage)
    {
        if (! is_int($maxMissedCleavage)) {
            throw new \InvalidArgumentException('Invalid argument type, integer expected. Received ' . gettype($maxMissedCleavage));
        }
        
        $this->maxMissedCleavage = $maxMissedCleavage;
    }
}
