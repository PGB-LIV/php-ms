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
 * Abstract class containing generic sorting methods
 *
 * @author Andrew Collins
 */
abstract class AbstractSort implements SortInterface
{

    protected $returnTrue = - 1;

    protected $returnFalse = 1;

    private $method;

    private $type;

    public function __construct($method, $order)
    {
        if ($order == SORT_ASC) {
            $this->returnTrue = 1;
            $this->returnFalse = - 1;
        }

        // Validate method?
        $this->method = $method;

        $clazz = get_class($this);
        if (defined($clazz . '::DATA_TYPE')) {
            $this->type = $clazz::DATA_TYPE;
        }
    }

    public function sort(&$array, $validate = true)
    {
        if ($validate) {
            $this->validate($array);
        }

        usort($array, array(
            $this,
            $this->method
        ));
    }

    protected function validate($array)
    {
        if (is_null($this->type)) {
            return false;
        }

        foreach ($array as $key => $element) {
            if (is_a($element, $this->type)) {
                continue;
            }

            throw new \InvalidArgumentException(
                'Type=' . $this->type . ' expected for element key=' . $key . ', type=' . gettype($element) . ' found');
        }

        return true;
    }
}
