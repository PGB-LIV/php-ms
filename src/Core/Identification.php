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
 * Abstract database entry object, by default the identifier, description and sequence are required.
 * Extending classes may use the additional fields.
 *
 * @author Andrew Collins
 */
class Identification
{

    private $peptide;

    private $scores = array();

    public function setPeptide(Peptide $peptide)
    {
        $this->peptide = $peptide;
    }

    public function getPeptide()
    {
        return $this->peptide;
    }

    public function setScore($key, $value)
    {
        $this->scores[$key] = $value;
    }

    public function getScores()
    {
        return $this->scores;
    }

    public function getScore($key)
    {
        return $this->scores[$key];
    }

    public function clearScores()
    {
        $this->scores = array();
    }
}
