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

use pgb_liv\php_ms\Core\Modification;
use pgb_liv\php_ms\Core\Tolerance;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Core\Spectra\PrecursorIon;

/**
 *
 * @author Andrew Collins
 */
class MzIdentMlReader1r1 implements MzIdentMlReader1Interface
{

    const CV_ACCESSION = 'accession';

    const CV_VALUE = 'value';

    const CV_UNITACCESSION = 'unitAccession';

    protected $xmlReader;

    public function __construct($filePath)
    {
        $this->xmlReader = new \SimpleXMLElement($filePath, null, true);
    }

    protected function getAdditionalSearchParams($xml)
    {
        $additional = array();
        $additional['cv'] = array();
        $additional['user'] = array();
        
        foreach ($xml->cvParam as $cvParam) {
            $additional['cv'][] = $this->getCvParam($cvParam);
        }
        
        foreach ($xml->userParam as $userParam) {
            $additional['user'][(string) $userParam->attributes()->name] = (string) $userParam->attributes()->value;
        }
        
        return $additional;
    }

    private function getAffiliation()
    {}

    private function getAmigiousResidue()
    {}

    public function getAnalysisCollection()
    {}

    public function getAnalysisData()
    {
        $sequences = $this->getSequenceCollection();
        
        $results = array();
        foreach ($this->xmlReader->DataCollection->AnalysisData->SpectrumIdentificationList->SpectrumIdentificationResult as $spectrumIdentificationResult) {
            $spectraItem = $spectrumIdentificationResult->SpectrumIdentificationItem;
            
            $identification = new Identification();
            $identification->setPeptide(
                $sequences[(string) $spectraItem->PeptideEvidenceRef->attributes()->peptideEvidence_ref]);
            
            $spectra = new PrecursorIon();
            $spectra->setCharge((int) $spectraItem->attributes()->chargeState);
            $spectra->setMassCharge((float) $spectraItem->attributes()->calculatedMassToCharge);
            $spectra->addIdentification($identification);
            
            foreach ($spectrumIdentificationResult->cvParam as $xml) {
                $cvParam = $this->getCvParam($xml);
                switch ($cvParam[MzIdentMlReader1r1::CV_ACCESSION]) {
                    case 'MS:1000796':
                        $spectra->setTitle($cvParam[MzIdentMlReader1r1::CV_VALUE]);
                        break;
                    case 'MS:1001115':
                        $spectra->setScan((float) $cvParam[MzIdentMlReader1r1::CV_VALUE]);
                        break;
                    default:
                        continue;
                }
            }
            
            foreach ($spectraItem->cvParam as $xml) {
                $cvParam = $this->getCvParam($xml);
                $identification->setScore($cvParam[MzIdentMlReader1r1::CV_ACCESSION], 
                    $cvParam[MzIdentMlReader1r1::CV_VALUE]);
            }
            
            $results[(string) $spectrumIdentificationResult->attributes()->id] = $spectra;
        }
        
        return $results;
    }

    private function getAnalysisParams()
    {}

    public function getAnalysisProtocolCollection()
    {
        $protocols = array();
        $protocols['spectrum'] = array();
        
        foreach ($this->xmlReader->AnalysisProtocolCollection->SpectrumIdentificationProtocol as $xml) {
            $protocols['spectrum'][(string) $xml->attributes()->id] = $this->getSpectrumIdentificationProtocol($xml);
        }
        
        if (isset($this->xmlReader->AnalysisProtocolCollection->ProteinDetectionProtocol)) {
            $protocols['protein'] = $this->getProteinDetectionProtocol();
        }
        
        return $protocols;
    }

    private function getAnalysisSampleCollection()
    {}

    public function getAnalysisSoftwareList()
    {
        $softwareList = array();
        
        foreach ($this->xmlReader->AnalysisSoftwareList->AnalysisSoftware as $analysisSoftware) {
            $softwareList[(string) $analysisSoftware->attributes()->id] = $this->getAnalysisSoftware($analysisSoftware);
        }
        
        return $softwareList;
    }

    protected function getAnalysisSoftware(\SimpleXMLElement $xml)
    {
        $software = array();
        
        if (isset($xml->attributes()->version)) {
            $software['version'] = (string) $xml->attributes()->version;
        }
        
        if (isset($xml->attributes()->name)) {
            $software['name'] = (string) $xml->attributes()->name;
        }
        
        if (isset($xml->attributes()->uri)) {
            $software['uri'] = (string) $xml->attributes()->uri;
        }
        
        $software['product_name'] = (string) $xml->attributes()->name;
        
        return $software;
    }

    private function getAuditCollection()
    {}

    private function getBibliographicReference()
    {}

    private function getContactRole()
    {}

    private function getCustomisations()
    {}

    protected function getDbSequence(\SimpleXMLElement $xml)
    {
        $protein = new Protein();
        $protein->setAccession((string) $xml->attributes()->accession);
        
        foreach ($xml->cvParam as $cvParam) {
            switch ($cvParam->attributes()->accession) {
                case 'MS:1001088':
                    $protein->setDescription((string) $cvParam->attributes()->value);
                    break;
                default:
                    continue;
            }
        }
        
        if (isset($xml->Seq)) {
            $protein->setSequence($this->getSeq($xml->Seq));
        }
        
        return $protein;
    }

    public function getDataCollection()
    {
        $dataCollection = array();
        $dataCollection['inputs'] = $this->getInputs();
        $dataCollection['analysisData'] = $this->getAnalysisData();
        
        return $dataCollection;
    }

    private function getDatabaseFilters()
    {}

    private function getDatabaseName()
    {}

    private function getDatabaseTranslation()
    {}

    private function getEnzyme()
    {}

    private function getEnzymeName()
    {}

    protected function getEnzymes($xml)
    {
        $enzymes = array();
        
        foreach ($xml->Enzyme as $xmlEnzyme) {
            $enzyme = array();
            
            $id = - 1;
            foreach ($xmlEnzyme->attributes() as $attribute => $value) {
                switch ($attribute) {
                    case 'cTermGain':
                        $enzyme['cTermGain'] = (string) $value;
                        break;
                    case 'id':
                        $id = (string) $value;
                        break;
                    case 'minDistance':
                        $enzyme['minDistance'] = (int) $value;
                        break;
                    case 'missedCleavages':
                        $enzyme['missedCleavages'] = (int) $value;
                        break;
                    case 'nTermGain':
                        $enzyme['nTermGain'] = (string) $value;
                        break;
                    case 'name':
                        $enzyme['name'] = (string) $value;
                        break;
                    case 'semiSpecific':
                        $enzyme['semiSpecific'] = (string) $value == 'true';
                        break;
                    default:
                        continue;
                }
            }
            
            $enzyme['EnzymeName'] = $this->getCvParam($xmlEnzyme->EnzymeName->cvParam);
            
            $enzymes[$id] = $enzyme;
        }
        
        return $enzymes;
    }

    private function getExclude()
    {}

    private function getExternalFormatDocumentation()
    {}

    private function getFileFormat()
    {}

    private function getFilter()
    {}

    private function getFilterType()
    {}

    private function getFragmentArray()
    {}

    private function getFragmentTolerance(\SimpleXMLElement $xml)
    {
        $tolerances = array();
        
        foreach ($xml->cvParam as $xmlCvParam) {
            $cvParam = $this->getCvParam($xmlCvParam);
            
            switch ($cvParam[MzIdentMlReader1r1::CV_ACCESSION]) {
                case 'MS:1001412':
                case 'MS:1001413':
                    $tolerance = new Tolerance((float) $cvParam[MzIdentMlReader1r1::CV_VALUE], 
                        $cvParam[MzIdentMlReader1r1::CV_UNITACCESSION]);
                    break;
                default:
                    $tolerance = $cvParam;
                    break;
            }
            
            $tolerances[] = $tolerance;
        }
        
        return $tolerances;
    }

    private function getFragmentation()
    {}

    private function getFragmentationTable()
    {}

    private function getInclude()
    {}

    private function getInputSpectra()
    {}

    private function getInputSpectrumIdentifications()
    {}

    public function getInputs()
    {
        $inputs = array();
        $inputs['SearchDatabase'] = array();
        foreach ($this->xmlReader->DataCollection->Inputs->SearchDatabase as $xml) {
            $inputs['SearchDatabase'][(string) $xml->attributes()->id] = $this->getSearchDatabase($xml);
        }
        
        $inputs['SpectraData'] = array();
        foreach ($this->xmlReader->DataCollection->Inputs->SpectraData as $xml) {
            $inputs['SpectraData'][(string) $xml->attributes()->id] = $this->getSpectraData($xml);
        }
        
        return $inputs;
    }

    private function getIonType()
    {}

    private function getMassTable()
    {}

    private function getMeasure()
    {}

    protected function getModification(\SimpleXMLElement $xml)
    {
        $attributes = $xml->attributes();
        $modification = new Modification();
        
        if (isset($attributes->avgMassDelta)) {
            $modification->setAverageMass((float) $attributes->avgMassDelta);
        }
        
        if (isset($attributes->location)) {
            $modification->setLocation((int) $attributes->location);
        }
        
        if (isset($attributes->monoisotopicMassDelta)) {
            $modification->setMonoisotopicMass((float) $attributes->monoisotopicMassDelta);
        }
        
        if (isset($attributes->residues)) {
            $residues = (string) $attributes->residues;
            $modification->setResidues(str_split($residues));
        }
        
        $cvParam = $this->getCvParam($xml->cvParam);
        
        $modification->setName($cvParam['name']);
        
        return $modification;
    }

    protected function getModificationParams(\SimpleXMLElement $xml)
    {
        $modifications = array();
        foreach ($xml->SearchModification as $xmlModification) {
            $modifications[] = $this->getSearchModification($xmlModification);
        }
        
        return $modifications;
    }

    private function getOrganization()
    {}

    private function getParent()
    {}

    protected function getParentTolerance(\SimpleXMLElement $xml)
    {
        $tolerances = array();
        
        foreach ($xml->cvParam as $xmlCvParam) {
            $cvParam = $this->getCvParam($xmlCvParam);
            
            switch ($cvParam[MzIdentMlReader1r1::CV_ACCESSION]) {
                case 'MS:1001412':
                case 'MS:1001413':
                    $tolerance = new Tolerance((float) $cvParam[MzIdentMlReader1r1::CV_VALUE], 
                        $cvParam[MzIdentMlReader1r1::CV_UNITACCESSION]);
                    break;
                default:
                    $tolerance = $cvParam;
                    break;
            }
            
            $tolerances[] = $tolerance;
        }
        
        return $tolerances;
    }

    /**
     *
     * @param \SimpleXMLElement $xml            
     * @return Peptide
     */
    protected function getPeptide(\SimpleXMLElement $xml)
    {
        $peptide = new Peptide();
        $peptide->setSequence($this->getPeptideSequence($xml->PeptideSequence));
        
        foreach ($xml->Modification as $xmlModification) {
            $peptide->addModification($this->getModification($xmlModification));
        }
        
        return $peptide;
    }

    private function getPeptideEvidence()
    {}

    private function getPeptideEvidenceRef()
    {}

    private function getPeptideHypothesis()
    {}

    protected function getPeptideSequence(\SimpleXMLElement $xml)
    {
        return (string) $xml;
    }

    private function getPerson()
    {}

    private function getProteinAmbiguityGroup()
    {}

    private function getProteinDetection()
    {}

    private function getProteinDetectionHypothesis()
    {}

    private function getProteinDetectionList()
    {}

    private function getProteinDetectionProtocol()
    {}

    private function getProvider()
    {}

    private function getResidue()
    {}

    private function getRole()
    {}

    private function getSample()
    {}

    protected function getSearchDatabase(\SimpleXMLElement $xml)
    {
        $database = array();
        
        // Required
        $database['location'] = (string) $xml->attributes()->location;
        
        // Optional
        if (isset($xml->attributes()->name)) {
            $database['name'] = (string) $xml->attributes()->name;
        }
        
        if (isset($xml->attributes()->numDatabaseSequences)) {
            $database['numDatabaseSequences'] = (int) $xml->attributes()->numDatabaseSequences;
        }
        
        if (isset($xml->attributes()->numResidues)) {
            $database['numResidues'] = (int) $xml->attributes()->numResidues;
        }
        
        if (isset($xml->attributes()->releaseDate)) {
            $database['releaseDate'] = (string) $xml->attributes()->releaseDate;
        }
        
        if (isset($xml->attributes()->version)) {
            $database['version'] = (string) $xml->attributes()->version;
        }
        
        return $database;
    }

    private function getSearchDatabaseRef()
    {}

    protected function getSearchModification(\SimpleXMLElement $xml)
    {
        $modification = new Modification();
        $modification->setLocation((int) $xml->attributes()->location);
        $modification->setMonoisotopicMass((float) $xml->attributes()->massDelta);
        
        if (isset($xml->SpecificityRules)) {
            $modification->setPosition($this->getSpecifityRules($xml->SpecificityRules));
        }
        
        $residues = (string) $xml->attributes()->residues;
        
        // Peaks fix
        if (strlen($residues) === 0) {
            $residues = '.';
        }
        
        $residues = explode(' ', $residues);
        
        $modification->setResidues($residues);
        
        if ((string) $xml->attributes()->fixedMod == 'true') {
            $modification->setType(Modification::TYPE_FIXED);
        } else {
            $modification->setType(Modification::TYPE_VARIABLE);
        }
        
        $cvParam = $this->getCvParam($xml->cvParam);
        
        $modification->setName($cvParam['name']);
        
        return $modification;
    }

    private function getSearchType()
    {}

    protected function getSeq(\SimpleXMLElement $xml)
    {
        return (string) $xml;
    }

    public function getSequenceCollection()
    {
        $peptides = array();
        foreach ($this->xmlReader->SequenceCollection->Peptide as $xml) {
            $peptides[(string) $xml->attributes()->id] = $this->getPeptide($xml);
        }
        
        $proteins = array();
        foreach ($this->xmlReader->SequenceCollection->DBSequence as $xml) {
            $proteins[(string) $xml->attributes()->id] = $this->getDbSequence($xml);
        }
        
        $results = array();
        foreach ($this->xmlReader->SequenceCollection->PeptideEvidence as $peptideEvidence) {
            $proteinRef = (string) $peptideEvidence->attributes()->dBSequence_ref;
            $peptideRef = (string) $peptideEvidence->attributes()->peptide_ref;
            
            $peptide = clone $peptides[$peptideRef];
            $peptide->setPositionStart((int) $peptideEvidence->attributes()->start);
            $peptide->setPositionEnd((int) $peptideEvidence->attributes()->end);
            $peptide->setProtein($proteins[$proteinRef]);
            $peptide->setIsDecoy((bool) $peptideEvidence->attributes()->isDecoy);
            
            $results[(string) $peptideEvidence->attributes()->id] = $peptide;
        }
        
        return $results;
    }

    private function getSiteRegexp()
    {}

    private function getSoftwareName(\SimpleXMLElement $xml)
    {
        $param = array();
        if (isset($xml->cvParam)) {
            $param = $this->parseCvParam($xml);
        } elseif (isset($xml->userParam)) {
            $param = $this->parseUserParam($xml);
        }
        
        return $param;
    }

    private function getSourceFile()
    {}

    protected function getSpecifityRules(\SimpleXMLElement $xml)
    {
        foreach ($xml->cvParam as $xmlParam) {
            $cvParam = $this->getCvParam($xmlParam);
            switch ($cvParam[MzIdentMlReader1r1::CV_ACCESSION]) {
                case 'MS:1001189':
                    return Modification::POSITION_NTERM;
                case 'MS:1001190':
                    return Modification::POSITION_CTERM;
                case 'MS:1002057':
                    return Modification::POSITION_PROTEIN_NTERM;
                case 'MS:1002058':
                    return Modification::POSITION_PROTEIN_CTERM;
                default:
                    // TODO: Correctly handle MS:1001875 / MS:1001876
                    break;
            }
        }
        return Modification::POSITION_ANY;
    }

    protected function getSpectraData(\SimpleXMLElement $xml)
    {
        $spectra = array();
        
        // Required
        $spectra['location'] = (string) $xml->attributes()->location;
        
        // Optional
        if (isset($xml->attributes()->name)) {
            $spectra['name'] = (string) $xml->attributes()->name;
        }
        
        return $spectra;
    }

    private function getSpectrumIdFormat()
    {}

    private function getSpectrumIdentification()
    {}

    private function getSpectrumIdentificationItem()
    {}

    private function getSpectrumIdentificationItemRef()
    {}

    private function getSpectrumIdentificationList()
    {}

    protected function getSpectrumIdentificationProtocol(\SimpleXMLElement $xml)
    {
        $software = $this->getAnalysisSoftwareList();
        
        $protocol = array();
        $softwareId = (string) $xml->attributes()->analysisSoftware_ref;
        
        $protocol['software'] = $software[$softwareId];
        
        $protocol['modifications'] = array();
        
        $protocol['modifications'] = $this->getModificationParams($xml->ModificationParams);
        
        $protocol['additions'] = $this->getAdditionalSearchParams($xml->AdditionalSearchParams);
        
        $protocol['enzymes'] = $this->getEnzymes($xml->Enzymes);
        
        if (isset($xml->FragmentTolerance)) {
            $protocol['fragmentTolerance'] = $this->getFragmentTolerance($xml->FragmentTolerance);
        }
        
        $protocol['parentTolerance'] = $this->getParentTolerance($xml->ParentTolerance);
        
        return $protocol;
    }

    private function getSpectrumIdentificationResult()
    {}

    private function getSubSample()
    {}

    private function getSubstitutionModification()
    {}

    private function getThreshold()
    {}

    private function getTranslationTable()
    {}

    private function getCv()
    {}

    private function getCvList()
    {}

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
        $cvParam[MzIdentMlReader1r1::CV_ACCESSION] = (string) $xml->attributes()->accession;
        $cvParam['name'] = (string) $xml->attributes()->name;
        
        // Optional fields
        if (isset($xml->attributes()->value)) {
            $cvParam[MzIdentMlReader1r1::CV_VALUE] = (string) $xml->attributes()->value;
        }
        
        if (isset($xml->attributes()->unitAccession)) {
            $cvParam[MzIdentMlReader1r1::CV_UNITACCESSION] = (string) $xml->attributes()->unitAccession;
        }
        
        if (isset($xml->attributes()->unitName)) {
            $cvParam['unitName'] = (string) $xml->attributes()->unitName;
        }
        
        if (isset($xml->attributes()->unitCvRef)) {
            $cvParam['unitCvRef'] = (string) $xml->attributes()->unitCvRef;
        }
        
        return $cvParam;
    }

    private function getUserParam()
    {}
}
