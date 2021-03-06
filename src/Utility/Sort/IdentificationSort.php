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
namespace pgb_liv\php_ms\Utility\Sort;

use pgb_liv\php_ms\Core\Identification;

/**
 * Creates an instance of an identification sort class.
 * Provides methods for sorting by various properties of an identification. To use score sorting, SetScoreKey() must be called first to specify which score type
 * should be used.
 *
 * @author Andrew Collins
 */
class IdentificationSort extends AbstractSort implements SortInterface
{

    const DATA_TYPE = '\pgb_liv\php_ms\Core\Identification';

    const SORT_SCORE = 'SortByScore';

    const SORT_RANK = 'SortByRank';

    private $scoreKey = null;

    /**
     * Set the key that will be used when sorting by score.
     *
     * @param string $scoreKey
     */
    public function setScoreKey($scoreKey)
    {
        $this->scoreKey = $scoreKey;
    }

    /**
     * Sort the identifications by score using the sort order and key provided
     *
     * @param Identification $a
     * @param Identification $b
     * @throws \BadMethodCallException Thrown if the key has not been specified
     * @return int
     */
    protected function sortByScore(Identification $a, Identification $b)
    {
        if (is_null($this->scoreKey)) {
            throw new \BadMethodCallException('The key to sort on must be defined using SetScoreKey() prior to sorting.');
        }
        
        if ($a->getScore($this->scoreKey) == $b->getScore($this->scoreKey)) {
            return 0;
        }
        
        return $a->getScore($this->scoreKey) > $b->getScore($this->scoreKey) ? $this->returnTrue : $this->returnFalse;
    }

    /**
     * Sort the identifications by rank using the sort order provided
     *
     * @param Identification $a
     * @param Identification $b
     * @return int
     */
    protected function sortByRank(Identification $a, Identification $b)
    {
        if ($a->getRank() == $b->getRank()) {
            return 0;
        }
        
        return $a->getRank() > $b->getRank() ? $this->returnTrue : $this->returnFalse;
    }
}
