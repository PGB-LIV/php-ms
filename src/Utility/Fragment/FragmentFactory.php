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
namespace pgb_liv\php_ms\Utility\Fragment;

use pgb_liv\php_ms\Core\ModifiableSequenceInterface;

/**
 * Helper methods to get fragmentation types by instrument type
 *
 * @author Andrew Collins
 */
class FragmentFactory
{

    /**
     * List of all methods currently supported
     *
     * @var string[]
     */
    private static $methods = array(
        'CID',
        'HCD',
        'ECD',
        'ETD',
        'CTD',
        'EDD',
        'NETD',
        'ETHCD'
    );

    public static function getFragmentMethods()
    {
        return self::$methods;
    }

    /**
     * For a specified method, returns the possible fragmentat ion types that may be produced
     *
     * @param string $method
     *            The method to get fragment types for
     * @param ModifiableSequenceInterface $sequence
     *            The peptide or protein sequence object to get fragment types for
     * @return FragmentInterface[]
     */
    public static function getMethodFragments($method, ModifiableSequenceInterface $sequence)
    {
        $fragmentTypes = array();
        
        switch (strtoupper($method)) {
            case 'CID':
            case 'HCD':
                $fragmentTypes['B'] = new BFragment($sequence);
                $fragmentTypes['Y'] = new YFragment($sequence);
                break;
            case 'ECD':
                $fragmentTypes['C'] = new CFragment($sequence);
                $fragmentTypes['Z'] = new ZFragment($sequence);
                $fragmentTypes['B'] = new BFragment($sequence);
                break;
            case 'ETD':
                $fragmentTypes['C'] = new CFragment($sequence);
                $fragmentTypes['Z'] = new ZFragment($sequence);
                break;
            case 'CTD':
            case 'EDD':
            case 'NETD':
                $fragmentTypes['A'] = new AFragment($sequence);
                $fragmentTypes['X'] = new XFragment($sequence);
                break;
            case 'ETHCD':
                $fragmentTypes['B'] = new BFragment($sequence);
                $fragmentTypes['Y'] = new YFragment($sequence);
                $fragmentTypes['C'] = new CFragment($sequence);
                $fragmentTypes['Z'] = new ZFragment($sequence);
                break;
            default:
                throw new \InvalidArgumentException('Unknown fragmentation method type "' . $method . '"');
        }
        
        return $fragmentTypes;
    }
}
