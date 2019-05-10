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
 * @todo Allow assigning of FDR to ident object - use custom key?
 */
class FalseDiscoveryRate
{

    private $falseDiscoveryRates;

    private $fdrKey = null;

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
            if ($falseDiscoryRate['FDR'] < $targetRate) {
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
     */
    public function calculate(array $identifications, $scoreKey, $sort = SORT_DESC)
    {
        $scoreSort = new IdentificationSort(IdentificationSort::SORT_SCORE, $sort);
        $scoreSort->setScoreKey($scoreKey);
        $scoreSort->sort($identifications);

        $this->falseDiscoveryRates = array();

        $V = 0;
        $S = 0;
        foreach ($identifications as $identification) {
            if ($this->isDecoy($identification)) {
                $V ++;
            } else {
                $S ++;
            }

            $R = $V + $S;

            $fdr = 0;
            if ($R > 1) {
                $fdr = $V / $R;
            }

            $this->falseDiscoveryRates[] = array(
                'FDR' => $fdr,
                'score' => $identification->getScore($scoreKey)
            );

            if (! is_null($this->fdrKey)) {
                $identification->setScore($this->fdrKey, $fdr);
            }
        }
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
