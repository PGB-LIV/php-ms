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
 * Interface to fasta file formats
 *
 * @author Andrew Collins
 */
interface FastaInterface
{

    /**
     * Gets the header text should be written at the start of the file output
     *
     * @return string
     */
    public function getHeader();

    /**
     * Gets the description text line that should be written for the protein entry
     *
     * @param Protein $protein
     *            The protein to get the plain text format for
     * @return string
     */
    public function getDescription(Protein $protein);

    /**
     * Gets a protein object from the FASTA fields
     *
     * @param string $identifier
     *            The identifier string
     * @param string $description
     *            The description string without identifier
     * @param string $sequence
     *            The full sequence block
     * @return Protein
     */
    public function getProtein($identifier, $description, $sequence);
}
