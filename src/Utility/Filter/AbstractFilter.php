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
namespace pgb_liv\php_ms\Utility\Filter;

use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Spectra\SpectraEntry;

/**
 * Abstract class containing generic filtering methods
 *
 * @author Andrew Collins
 */
abstract class AbstractFilter
{

    /**
     * Returns true if the Peptide matches the filter criteria, else false
     *
     * @param Peptide $peptide
     *            Peptide object to filter
     */
    public function isValidPeptide(Peptide $peptide)
    {
        throw new \BadMethodCallException("isValidPeptide is not defined for this instance.");
    }

    /**
     * Returns true if the SpectraEntry matches the filter criteria, else false
     *
     * @param SpectraEntry $peptide
     *            Spectra object to filter
     */
    public function isValidSpectra(SpectraEntry $spectra)
    {
        throw new \BadMethodCallException("isValidPeptide is not defined for this instance.");
    }

    /**
     * Filters an array of peptides and returns an array of peptides which match the filter criteria
     *
     * @param array $peptides
     *            An array of Peptide elements
     */
    public function filterPeptide(array $peptides)
    {
        return array_filter($peptides, array(
            $this,
            'isValidPeptide'
        ));
    }

    /**
     * Filters an array of spectra and returns an array of spectra which match the filter criteria
     *
     * @param array $spectra
     *            An array of spectra elements
     */
    public function filterSpectra(array $spectra)
    {
        return array_filter($spectra, array(
            $this,
            'isValidSpectra'
        ));
    }
}
