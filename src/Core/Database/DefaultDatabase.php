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
namespace pgb_liv\php_ms\Core\Database;

/**
 * Class for default database.
 * This class is not a singleton and multiple instances with the same prefix may exist. Only use if no other named class is suitable.
 *
 * @author Andrew Collins
 */
class DefaultDatabase implements DatabaseInterface
{

    private $prefix;

    private $name;

    private $source;

    /**
     * Sets the database prefix
     *
     * @param string $prefix
     *            value to set
     */
    public function __construct()
    {
        $this->setPrefix('UNKNOWN');
        $this->setName('Unknown Database');
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getSource()
    {
        return $this->source;
    }
}
