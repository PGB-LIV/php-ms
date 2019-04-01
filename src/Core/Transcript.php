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
namespace pgb_liv\php_ms\Core;

/**
 * Class for transcript object.
 *
 * @author Andrew Collins
 */
class Transcript
{
    use DatabaseEntryTrait;

    /**
     * Type of this gene (e.g.
     * Protein coding)
     *
     * @var string
     */
    private $type;

    /**
     * Sets the gene bio type (E.g.
     * Protein Coding)
     *
     * @param string $name
     *            value to set
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the bio type for this gene
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
