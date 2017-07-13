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
namespace pgb_liv\php_ms\Core\Database\Fasta;

use pgb_liv\php_ms\Core\Protein;

/**
 * A sequence Database Entry object.
 * By default the identifier, description
 * and sequence are available. Additional fields will be available if the
 * description has been able to be parsed in the case of FASTA data.
 *
 * @author Andrew Collins
 */
class DefaultFastaEntry implements FastaInterface
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Core\Database\Fasta\FastaInterface::getHeader()
     */
    public function getHeader()
    {
        return '';
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Core\Database\Fasta\FastaInterface::getDescription()
     */
    public function getDescription(Protein $protein)
    {
        $description = '>' . $protein->getUniqueIdentifier();
        
        if (! is_null($protein->getDescription())) {
            $description .= ' ' . $protein->getDescription();
        }
        
        return $description;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Core\Database\Fasta\FastaInterface::getProtein()
     */
    public function getProtein($identifier, $description, $sequence)
    {
        $protein = new Protein();
        $protein->setUniqueIdentifier($identifier);
        $protein->setDescription($description);
        $protein->setSequence($sequence);
        
        return $protein;
    }
}
