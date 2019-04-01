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
 * Class for organism object.
 *
 * @author Andrew Collins
 */
class Organism
{

    /**
     * The scientific name of the organism.
     *
     * @var string
     */
    private $name;

    /**
     * The unique identifier of the source organism, assigned by the NCBI.
     *
     * @var string
     */
    private $identifier;

    /**
     *
     * @var Organism[]
     */
    private static $instances;

    /**
     * Sets the scientific name of the organism.
     *
     * @param string $name
     *            name of the organism
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the scientific name of the organism.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the identifier (NCBI) of the organism. If identifier is known at object creation, getInstance() should be used
     *
     * @param string $identifier
     *            identifier of the organism
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     *
     * @param string $identifier
     * @return Organism
     */
    public static function getInstance($identifier)
    {
        if (! isset(self::$instances[$identifier])) {
            self::$instances[$identifier] = new Organism();
            self::$instances[$identifier]->setIdentifier($identifier);
        }

        return self::$instances[$identifier];
    }

    /**
     *
     * @param string $identifier
     * @return bool
     */
    public static function hasInstance($identifier)
    {
        if (isset(self::$instances[$identifier])) {
            return true;
        }

        return false;
    }
}
