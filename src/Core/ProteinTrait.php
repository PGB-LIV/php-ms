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

use pgb_liv\php_ms\Core\Entry\ProteinEntry;

/**
 * Trait for methods associated with attaching a protein to another object
 *
 * @author Andrew Collins
 */
trait ProteinTrait
{

    /**
     * An array of all proteins this object maps to
     *
     * @var ProteinEntry[]
     */
    private $proteins = array();

    /**
     * Add a new protein mapping to this object.
     * Start and end positions on the protein sequence can be specified
     *
     * @param Protein $protein
     *            The protein to map to
     * @param int $start
     *            The start position of this peptide in the sequence
     * @param int $end
     *            The end position this peptide in the sequence
     */
    public function addProtein(Protein $protein, $start = null, $end = null)
    {
        $entry = new ProteinEntry($protein);
        if (! is_null($start)) {
            $entry->setStart($start);
        }

        if (! is_null($end)) {
            $entry->setEnd($end);
        }

        $this->addProteinEntry($entry);
    }

    /**
     * This provides direct access to add new entity records and should be used when subclasses are expected
     *
     * @param ProteinEntry $entity
     */
    public function addProteinEntry(ProteinEntry $entry)
    {
        $this->proteins[] = $entry;
    }

    /**
     * Gets the set of proteins that this object links to
     *
     * @return ProteinEntry[]
     */
    public function getProteins()
    {
        return $this->proteins;
    }
}
