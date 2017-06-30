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
 * Class for spectra identification object, provides storage for assigning a Peptide and scoring.
 *
 * @author Andrew Collins
 */
class Identification
{

    /**
     * Peptide assigned to this identification
     *
     * @var Peptide
     */
    private $peptide;

    /**
     * Map of identification scores
     *
     * @var array
     */
    private $scores = array();

    /**
     * Number of ions matched from a search result
     *
     * @var int
     */
    private $ionsMatched;

    /**
     * Sets the peptide for this identification
     *
     * @param Peptide $peptide
     *            The peptide to assign this identification object
     */
    public function setPeptide(Peptide $peptide)
    {
        $this->peptide = $peptide;
    }

    /**
     * Gets the peptide associated with this identification
     *
     * @return Peptide
     */
    public function getPeptide()
    {
        return $this->peptide;
    }

    /**
     * Sets the score for this identification, a key must be specified that can be used for retreiving the score type later.
     * E.g. eValue or pValue
     *
     * @param string $key
     *            The key to identify this score entry by
     * @param mixed $value
     *            The score value. Both numeric and string types are allowable.
     */
    public function setScore($key, $value)
    {
        $this->scores[$key] = $value;
    }

    /**
     * Gets the scores for this identification as an associative array.
     *
     * @return array
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * Gets the value for a score identified by the key that was set when setScore was called.
     *
     * @param sring $key
     *            The key to retrieve the value for
     * @throws \OutOfBoundsException If the key was not found on this identification
     * @return mixed
     */
    public function getScore($key)
    {
        if (! array_key_exists($key, $this->scores)) {
            throw new \OutOfBoundsException('The key "' . $key . ' was not found.');
        }
        
        return $this->scores[$key];
    }

    /**
     * Clears all scores held by this instance.
     */
    public function clearScores()
    {
        $this->scores = array();
    }

    /**
     * Sets the the number of fragment ions matched
     *
     * @param int $ionsMatched
     *            The number of ions matched
     * @throws \InvalidArgumentException If the arguments do not match the data types
     */
    public function setIonsMatched($ionsMatched)
    {
        if (! is_int($ionsMatched)) {
            throw new \InvalidArgumentException('Argument 1 must be an int value. Valued passed is of type ' . gettype($ionsMatched));
        }
        
        $this->ionsMatched = $ionsMatched;
    }

    /**
     * Gets the number of ions matched
     *
     * @return int
     */
    public function getIonsMatched()
    {
        return $this->ionsMatched;
    }
}
