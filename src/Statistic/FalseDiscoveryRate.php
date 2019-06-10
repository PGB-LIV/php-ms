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
namespace pgb_liv\php_ms\Statistic;

use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Utility\Sort\IdentificationSort;

/**
 * Class for calculating False Discovery Rate (FDR) from a collection of identifications
 *
 * @author Andrew Collins
 */
class FalseDiscoveryRate
{

    private $fdrTable = true;

    private $falseDiscoveryRates = array();

    private $fdrKey = null;

    private $fdrV = 0;

    private $fdrS = 0;

    public function setFdrTableUsage($bool)
    {
        $this->fdrTable = $bool;
    }

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

    public function getFalseDiscoryRates()
    {
        return $this->falseDiscoveryRates;
    }

    /**
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

    public function getFdr(Identification $identification, $scoreKey)
    {
        $fdr = getFdrScore($identification->getScore($scoreKey), $this->isDecoy($identification));

        if (! is_null($this->fdrKey)) {
            $identification->setScore($this->fdrKey, $fdr);
        }

        return $fdr;
    }

    public function getFdrScore($score, $isDecoy)
    {
        if ($isDecoy) {
            $this->fdrV ++;
        } else {
            $this->fdrS ++;
        }

        $R = $this->fdrV + $this->fdrS;

        $fdr = 0;
        if ($R > 1) {
            $fdr = $this->fdrV / $R;
        }

        if ($this->fdrTable) {
            $this->falseDiscoveryRates[] = array(
                'FDR' => $fdr,
                'score' => $score
            );
        }

        return $fdr;
    }

    public function reset()
    {
        $this->falseDiscoveryRates = array();
        $this->fdrV = 0;
        $this->fdrS = 0;
        $this->fdrKey = null;
    }

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
