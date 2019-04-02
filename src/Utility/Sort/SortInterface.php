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

/**
 * Interface to common sorting methods
 *
 * @author Andrew Collins
 */
interface SortInterface
{

    /**
     * Sorts the array using the options specified in the constructor
     *
     * @param array $array
     *            The array to sort
     * @param boolean $validate
     *            Whether validation (if available) should be performed prior to the sort occuring. This is recommended to ensure the array data is correct, but
     *            can be disabled for performance reasons if the data origin is known.
     */
    public function sort(&$array, $validate = true);
}
