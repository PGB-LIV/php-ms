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
namespace pgb_liv\php_ms\Statistic;

use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Utility\Sort\IdentificationSort;

/**
 * Class for calculating False Discovery Rate (FDR) from a object scores
 *
 * @author Andrew Collins
 */
class FalseDiscoveryRate
{

    private $fdrTable = true;

    private $falseDiscoveryRates = array();

    private $fdrKey = null;

    private $fdrV = 0;

    private $fdrR = 0;

    /**
     * Sets whether the FDR table is available, used by getScore/getMatches.
     * Default true.
     *
     * @param bool $bool
     */
    public function setFdrTableUsage($bool)
    {
        $this->fdrTable = $bool;
    }

    /**
     * Sets the key that should be used to record the FDR as an identification score element.
     * Only jused when identification data is used to calculate FDR
     *
     * @param string $key
     */
    public function setFdrKey($key)
    {
        $this->fdrKey = $key;
    }

    /**
     * Gets the score that corresponds to the target FDR
     *
     * @param float $targetRate
     */
    public function getScore($targetRate)
    {
        $score = 0;
        foreach ($this->falseDiscoveryRates as $falseDiscoryRate) {
            if ($falseDiscoryRate['FDR'] <= $targetRate) {
                $score = $falseDiscoryRate['score'];

                continue;
            }

            break;
        }

        return $score;
    }

    /**
     * Gets the number of matches for the target FDR
     *
     * @param float $targetRate
     */
    public function getMatches($targetRate)
    {
        $matches = 0;
        foreach ($this->falseDiscoveryRates as $falseDiscoryRate) {
            if ($falseDiscoryRate['FDR'] <= $targetRate) {
                $matches ++;
                continue;
            }

            break;
        }

        return $matches;
    }

    /**
     * Gets the array of FDR rates, FDR => Score
     *
     * @return array
     */
    public function getFalseDiscoryRates()
    {
        return $this->falseDiscoveryRates;
    }

    /**
     * Alias of getFdrAll
     *
     * @param Identification[] $identifications
     * @param string $scoreKey
     * @param int $sort
     *            Direction of sort, use SORT_DESC or SORT_ASC. If $sort=null, no sorting will be performed. This setting is recommended only when the data
     *            is already sorted.
     * @deprecated Alias of getFdrAll
     */
    public function calculate(array $identifications, $scoreKey, $sort = SORT_DESC)
    {
        getFdrAll($identifications, $scoreKey, $sort);
    }

    /**
     * Calculates the FDR of all identifications, and stores them depending on options used for this
     * instance.
     *
     * @param Identification[] $identifications
     * @param string $scoreKey
     * @param int $sort
     *            Direction of sort, use SORT_DESC or SORT_ASC. If $sort=null, no sorting will be performed. This setting is recommended only when the data
     *            is already sorted.
     */
    public function getFdrAll(array $identifications, $scoreKey, $sort = SORT_DESC)
    {
        if (! is_null($sort)) {
            $scoreSort = new IdentificationSort(IdentificationSort::SORT_SCORE, $sort);
            $scoreSort->setScoreKey($scoreKey);
            $scoreSort->sort($identifications);
        }

        foreach ($identifications as $identification) {
            $this->getFdr($identification, $scoreKey);
        }
    }

    /**
     * Gets the FDR for the specified identification.
     *
     * @param Identification $identification
     * @param string $scoreKey
     * @return float
     */
    public function getFdr(Identification $identification, $scoreKey)
    {
        $fdr = getFdrScore($identification->getScore($scoreKey), $this->isDecoy($identification));

        if (! is_null($this->fdrKey)) {
            $identification->setScore($this->fdrKey, $fdr);
        }

        return $fdr;
    }

    /**
     * Gets the FDR for the specified score
     *
     * @param float $score
     * @param bool $isDecoy
     * @return float
     */
    public function getFdrScore($score, $isDecoy)
    {
        if ($isDecoy) {
            $this->fdrV ++;
        }

        $this->fdrR ++;

        $fdr = 0;
        if ($this->fdrR > 1) {
            $fdr = $this->fdrV / $this->fdrR;
        }

        if ($this->fdrTable) {
            $this->falseDiscoveryRates[] = array(
                'FDR' => $fdr,
                'score' => $score
            );
        }

        return $fdr;
    }

    /**
     * Resets the cummulative FDR tallies for this instance.
     */
    public function reset()
    {
        $this->falseDiscoveryRates = array();
        $this->fdrV = 0;
        $this->fdrR = 0;
        $this->fdrKey = null;
    }

    /**
     * Identifies whether the identification is a decoy or not.
     *
     * @param Identification $identification
     * @return boolean
     */
    private function isDecoy(Identification $identification)
    {
        if ($identification->getSequence()->isDecoy()) {
            return true;
        } else {
            // Peptide may not contain the field, but the protein might.
            foreach ($identification->getSequence()->getProteins() as $proteinEntry) {
                $protein = $proteinEntry->getProtein();
                if ($protein->isDecoy()) {
                    return true;
                }
            }
        }

        return false;
    }
}
