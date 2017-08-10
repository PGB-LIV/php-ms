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
namespace pgb_liv\php_ms\Reader;

use pgb_liv\php_ms\Core\Spectra\PrecursorIon;

/**
 *
 * @author Andrew Collins
 */
interface MzIdentMlReader1Interface
{

    public function getInputs();

    public function getAnalysisProtocolCollection();

    /**
     *
     * @return PrecursorIon[]
     */
    public function getAnalysisData();
    
    public function getProteinDetectionList();
    
    /**
     * Gets the CvParam name attribute from any previously seen and indexed CvParam.
     * For this method to return a value the accession should already have been read by this parser.
     *
     * @param string $accession
     *            The accession to return the name value for.
     *
     * @throws \OutOfRangeException The accession was not found and consequently has not yet been parsed by this instance.
     * @return string
     */
    public function getCvParamName($accession);
}
