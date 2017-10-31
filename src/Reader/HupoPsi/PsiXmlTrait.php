<?php
/**
 * Copyright 2017 University of Liverpool
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
namespace pgb_liv\php_ms\Reader\HupoPsi;

/**
 * Trait for generic methods that are consistent across all HUPO-PSI standards (e.g.
 * CvParam)
 *
 * @author Andrew Collins
 */
trait PsiXmlTrait
{

    /**
     * Builds an index of seen CvParams of Accession -> Name
     *
     * @var string[]
     */
    private $cvParamIndex = array();

    /**
     *
     * {@inheritdoc}
     *
     * @see \pgb_liv\php_ms\Reader\MzIdentMlReader1Interface::getCvParamName()
     */
    public function getCvParamName($accession)
    {
        $name = $this->cvParamIndex[$accession];
        
        if (is_null($name)) {
            throw new \OutOfRangeException($accession . ' not seen in data source');
        }
        
        return $name;
    }

    /**
     * Creates an array object from a CvParam object
     *
     * @param \SimpleXMLElement $xml
     */
    protected function getCvParam($xml)
    {
        $cvParam = array();
        // Required fields
        
        $cvParam['cvRef'] = (string) $xml->attributes()->cvRef;
        $cvParam[PsiVerb::CV_ACCESSION] = (string) $xml->attributes()->accession;
        $cvParam['name'] = (string) $xml->attributes()->name;
        
        if (! isset($this->cvParamIndex[$cvParam[PsiVerb::CV_ACCESSION]])) {
            $this->cvParamIndex[$cvParam[PsiVerb::CV_ACCESSION]] = $cvParam['name'];
        }
        
        // Optional fields
        if (isset($xml->attributes()->value)) {
            $cvParam[PsiVerb::CV_VALUE] = (string) $xml->attributes()->value;
        }
        
        if (isset($xml->attributes()->unitAccession)) {
            $cvParam[PsiVerb::CV_UNITACCESSION] = (string) $xml->attributes()->unitAccession;
        }
        
        if (isset($xml->attributes()->unitName)) {
            $cvParam['unitName'] = (string) $xml->attributes()->unitName;
        }
        
        if (isset($xml->attributes()->unitCvRef)) {
            $cvParam['unitCvRef'] = (string) $xml->attributes()->unitCvRef;
        }
        
        return $cvParam;
    }

    protected function getUserParam()
    {}

    protected function getAttributeId(\SimpleXMLElement $xml)
    {
        return (string) $xml->attributes()->id;
    }
}
