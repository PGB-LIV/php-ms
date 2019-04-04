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
 * Abstract class for database object.
 *
 * @author Andrew Collins
 */
abstract class AbstractDatabase implements DatabaseInterface
{

    private $prefix;

    private $name;

    private $source;

    /**
     *
     * @var DatabaseInterface[]
     */
    private static $instances = array();

    /**
     * Singleton use only
     */
    protected function __construct($prefix, $name)
    {
        $this->prefix = $prefix;
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

    protected function setSource($source)
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

    /**
     * Gets the singleton intance for this prefix
     *
     * @param string $prefix
     * @return DatabaseInterface
     */
    public static function getInstance()
    {
        $class = get_called_class();

        if (! isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }
}
