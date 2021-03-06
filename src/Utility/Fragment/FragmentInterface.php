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

/**
 * Generic interface for accessing fragment ion data generated by fragmentation classes (A, B, C, X, Y, Z)
 *
 * @author Andrew Collins
 */
interface FragmentInterface
{

    /**
     * Gets the fragmentation ions for this instances peptide sequence
     *
     * @param int $charge The charge to generate ions at
     * @return double[]
     */
    public function getIons($charge = 1);

    /**
     * Gets the direction ions should be read
     *
     * @return boolean
     */
    public function isReversed();
}
