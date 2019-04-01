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
 * Class for gene object.
 *
 * @author Andrew Collins
 */
class Gene
{
    use DatabaseEntryTrait;

    /**
     * Symbol of this gene
     *
     * @var string
     */
    private $symbol;

    /**
     * Name of this gene
     *
     * @var string
     */
    private $name;

    /**
     * Type of this gene (e.g.
     * Protein coding)
     *
     * @var string
     */
    private $type;

    /**
     *
     * @var Gene[]
     */
    private static $instances;

    /**
     * Sets the gene symbol
     *
     * @param string $symbol
     *            value to set
     */
    private function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * Gets the symbol for this gene
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Sets the gene name
     *
     * @param string $name
     *            value to set
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the name for this gene
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

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

    /**
     *
     * @param string $symbol
     * @return Gene
     */
    public static function getInstance($symbol)
    {
        if (! isset(self::$instances[$symbol])) {
            self::$instances[$symbol] = new Gene($symbol);
        }

        return self::$instances[$symbol];
    }
}
