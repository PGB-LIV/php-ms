<?php
/**
 * Copyright 2016 University of Liverpool
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
namespace pgb_liv\php_ms\Utility\Digest;

/**
 * Factory class for digestion algorithms.
 *
 * @author Andrew Collins
 */
class DigestFactory
{

    /**
     * Gets the digest object associated with the enzyme
     *
     * @param string $digestName
     *            Name of the enzyme
     * @return \pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     */
    public static function getDigest($digestName)
    {
        $enzymes = DigestFactory::getEnzymes();
        $digestUp = strtoupper($digestName);
        
        foreach ($enzymes as $key => $value) {
            if (strtoupper($key) == $digestUp) {
                $classPath = __NAMESPACE__ . '\\Digest' . $key;
                return new $classPath();
            }
        }
        
        throw new \InvalidArgumentException('Unknown digest algorithm - ' . $digestName);
    }

    public static function getEnzymes()
    {
        $blacklist = array(
            'AbstractDigest.php',
            'DigestInterface.php',
            'DigestRegularExpression.php',
            'DigestFactory.php'
        );
        
        $files = scandir(__DIR__);
        $enzymes = array();
        
        foreach ($files as $file) {
            if (is_dir(__DIR__ . '/' . $file)) {
                continue;
            }
            
            if (in_array($file, $blacklist)) {
                continue;
            }
            
            $className = str_replace('.php', '', $file);
            $classPath = __NAMESPACE__ . '\\' . $className;
            $class = new $classPath();
            
            if (is_a($class, __NAMESPACE__ . '\\' . 'DigestInterface')) {
                $enzymes[substr($className, 6)] = $class->getName();
            }
        }
        
        return $enzymes;
    }
}
