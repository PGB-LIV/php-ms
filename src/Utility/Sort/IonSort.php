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
namespace pgb_liv\php_ms\Utility\Sort;

use pgb_liv\php_ms\Core\Spectra\IonInterface;

/**
 * Creates an instance of an ion sort class.
 * Provides methods for sorting by various properties of an ion.
 *
 * @author Andrew Collins
 */
class IonSort extends AbstractSort implements SortInterface
{

    const DATA_TYPE = '\pgb_liv\php_ms\Core\Spectra\IonInterface';

    const SORT_INTENSITY = 'SortByIntensity';

    const SORT_MZ = 'SortByMassCharge';

    const SORT_MASS = 'SortByMass';

    const SORT_CHARGE = 'SortByCharge';

    protected function sortByIntensity(IonInterface $a, IonInterface $b)
    {
        if ($a->getIntensity() == $b->getIntensity()) {
            return 0;
        }

        return $a->getIntensity() > $b->getIntensity() ? $this->returnTrue : $this->returnFalse;
    }

    protected function sortByMass(IonInterface $a, IonInterface $b)
    {
        if ($a->getMonoisotopicMass() == $b->getMonoisotopicMass()) {
            return 0;
        }

        return $a->getMonoisotopicMass() > $b->getMonoisotopicMass() ? $this->returnTrue : $this->returnFalse;
    }

    protected function sortByMassCharge(IonInterface $a, IonInterface $b)
    {
        if ($a->getMonoisotopicMassCharge() == $b->getMonoisotopicMassCharge()) {
            return 0;
        }

        return $a->getMonoisotopicMassCharge() > $b->getMonoisotopicMassCharge() ? $this->returnTrue : $this->returnFalse;
    }

    protected function sortByCharge(IonInterface $a, IonInterface $b)
    {
        if ($a->getCharge() == $b->getCharge()) {
            return 0;
        }

        return $a->getCharge() > $b->getCharge() ? $this->returnTrue : $this->returnFalse;
    }
}
