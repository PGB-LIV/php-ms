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

use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Spectra\SpectraEntry;
use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Core\Modification;
use pgb_liv\php_ms\Core\Tolerance;

/**
 *
 * @author Andrew Collins
 */
class MzIdentMLReader
{

    private $xmlReader;

    public function __construct($filePath)
    {
        $this->xmlReader = new \SimpleXMLElement($filePath, null, true);
    }

    public function getAnalysisProtocolCollection()
    {
        $protocols = array();
        foreach ($this->xmlReader->AnalysisProtocolCollection->SpectrumIdentificationProtocol as $spectrumIdentificationProtocol) {
            $protocols[(string) $spectrumIdentificationProtocol->attributes()->id] = $this->getSpectrumIdentificationProtocol(
                $spectrumIdentificationProtocol);
        }
        
        return $protocols;
    }

    public function getPeptides()
    {
        $peptides = array();
        foreach ($this->xmlReader->SequenceCollection->Peptide as $xmlPeptide) {
            $peptide = new Peptide((string) $xmlPeptide->PeptideSequence);
            
            foreach ($this->xmlReader->Modification as $xmlModification) {
                $modification = new Modification();
                $modification->setLocation((int) $xmlModification->attributes()->location);
                $modification->setMass((float) $xmlModification->attributes()->monoisotopicMassDelta);
                
                $peptide->setModification($modification);
            }
            
            $peptides[(string) $xmlPeptide->attributes()->id] = $peptide;
        }
        
        return $peptides;
    }

    public function getProteins()
    {
        $proteins = array();
        foreach ($this->xmlReader->SequenceCollection->DBSequence as $dbSequence) {
            $protein = new Protein();
            $protein->setAccession((string) $dbSequence->attributes()->accession);
            
            foreach ($dbSequence->cvParam as $cvParam) {
                switch ($cvParam->attributes()->accession) {
                    case 'MS:1001088':
                        $protein->setDescription((string) $cvParam->attributes()->value);
                        break;
                    default:
                        continue;
                }
            }
            
            $proteins[(string) $dbSequence->attributes()->id] = $protein;
        }
        
        return $proteins;
    }

    public function getSequenceCollection()
    {
        $peptides = $this->getPeptides();
        $proteins = $this->getProteins();
        
        $results = array();
        foreach ($this->xmlReader->SequenceCollection->PeptideEvidence as $peptideEvidence) {
            $proteinRef = (string) $peptideEvidence->attributes()->dBSequence_ref;
            $peptideRef = (string) $peptideEvidence->attributes()->peptide_ref;
            
            $peptide = new Peptide($peptides[$peptideRef]->getSequence());
            $peptide->setPositionStart((int) $peptideEvidence->attributes()->start);
            $peptide->setPositionEnd((int) $peptideEvidence->attributes()->end);
            $peptide->setProtein($proteins[$proteinRef]);
            $peptide->setIsDecoy((bool) $peptideEvidence->attributes()->isDecoy);
            
            $results[(string) $peptideEvidence->attributes()->id] = $peptide;
        }
        
        return $results;
    }

    public function getInputs()
    {
        $inputs = array();
        $inputs['SearchDatabase'] = $this->getSearchDatabases();
        $inputs['SpectraData'] = $this->getSpectraDataSets();
        
        return $inputs;
    }

    public function getSearchDatabases()
    {
        $databases = array();
        
        foreach ($this->xmlReader->DataCollection->Inputs->SearchDatabase as $xmlDatabases) {
            $databases[(string) $xmlDatabases->attributes()->id] = $this->getSearchDatabase($xmlDatabases);
        }
        
        return $databases;
    }

    private function getSearchDatabase(\SimpleXMLElement $xml)
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
            $database['numDatabaseSequences'] = (int) $xml->attributes()->numResidues;
        }
        
        if (isset($xml->attributes()->releaseDate)) {
            $database['numDatabaseSequences'] = (string) $xml->attributes()->releaseDate;
        }
        
        if (isset($xml->attributes()->version)) {
            $database['numDatabaseSequences'] = (string) $xml->attributes()->version;
        }
        
        return $database;
    }

    public function getSpectraDataSets()
    {
        $spectra = array();
        
        foreach ($this->xmlReader->DataCollection->Inputs->SpectraData as $xmlSpectra) {
            $spectra[(string) $xmlSpectra->attributes()->id] = $this->getSpectraDataSet($xmlSpectra);
        }
        
        return $spectra;
    }

    private function getSpectraDataSet(\SimpleXMLElement $xml)
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

    public function getAnalysisData()
    {
        $sequences = $this->getSequenceCollection();
        foreach ($this->xmlReader->DataCollection->AnalysisData->SpectrumIdentificationList->SpectrumIdentificationResult as $spectrumIdentificationResult) {
            $spectraItem = $spectrumIdentificationResult->SpectrumIdentificationItem;
            
            $identification = new Identification();
            $identification->setPeptide(
                $sequences[(string) $spectraItem->PeptideEvidenceRef->attributes()->peptideEvidence_ref]);
            
            $spectra = new SpectraEntry();
            $spectra->setCharge((int) $spectraItem->attributes()->chargeState);
            $spectra->setMassCharge((float) $spectraItem->attributes()->calculatedMassToCharge);
            $spectra->setIdentification($identification);
            
            foreach ($spectrumIdentificationResult->cvParam as $cvParam) {
                switch ($cvParam->attributes()->accession) {
                    case 'MS:1000796':
                        $spectra->setTitle((string) $cvParam->attributes()->value);
                        break;
                    case 'MS:1001115':
                        $spectra->setScans((int) $cvParam->attributes()->value);
                        break;
                    default:
                        continue;
                }
            }
            
            foreach ($spectraItem->cvParam as $cvParam) {
                $identification->setScore((string) $cvParam->attributes()->accession, 
                    (string) $cvParam->attributes()->value);
            }
            
            $results[(string) $spectrumIdentificationResult->attributes()->id] = $spectra;
        }
        
        return $results;
    }

    public function getDataCollection()
    {
        $dataCollection = array();
        $dataCollection['inputs'] = $this->getInputs();
        $dataCollection['analysisData'] = $this->getAnalysisData();
        
        return $dataCollection;
    }

    public function getAnalysisSoftware()
    {
        $softwareList = array();
        
        foreach ($this->xmlReader->AnalysisSoftwareList->AnalysisSoftware as $analysisSoftware) {
            $software = array();
            $software['version'] = (string) $analysisSoftware->attributes()->version;
            $software['name'] = (string) $analysisSoftware->attributes()->name;
            
            $softwareList[(string) $analysisSoftware->attributes()->id] = $software;
        }
        
        return $softwareList;
    }

    private function getProtocolModifications($xml)
    {
        $modifications = array();
        
        foreach ($xml->SearchModification as $xmlModification) {
            $modification = new Modification();
            $modification->setLocation((int) $xmlModification->attributes()->location);
            $modification->setMass((float) $xmlModification->attributes()->massDelta);
            
            $residues = (string) $xmlModification->attributes()->residues;
            
            if (strtolower($residues) == 'any') {
                $residues = '*';
            } else {
                $residues = str_split($residues);
            }
            
            $modification->setResidues($residues);
            
            if ((string) $xmlModification->attributes()->fixedMod == 'true') {
                $modification->setType(Modification::TYPE_FIXED);
            } else {
                $modification->setType(Modification::TYPE_VARIABLE);
            }
            
            $modification->setName((string) $xmlModification->cvParam->attributes()->name);
            
            $modifications[] = $modification;
        }
        
        return $modifications;
    }

    private function getProtocolAdditional($xml)
    {
        $additional = array();
        $additional['cv'] = array();
        $additional['user'] = array();
        
        foreach ($xml->cvParam as $cvParam) {
            $additional['cv'][] = $this->parseCvParam($cvParam);
        }
        
        foreach ($xml->userParam as $userParam) {
            $additional['user'][(string) $userParam->attributes()->name] = (string) $userParam->attributes()->value;
        }
        
        return $additional;
    }

    private function getSpectrumIdentificationProtocol($xml)
    {
        $software = $this->getAnalysisSoftware();
        
        $protocol = array();
        $softwareId = (string) $xml->attributes()->analysisSoftware_ref;
        
        $protocol['software'] = $software[$softwareId];
        
        $protocol['modifications'] = $this->getProtocolModifications($xml->ModificationParams);
        
        $protocol['additions'] = $this->getProtocolAdditional($xml->AdditionalSearchParams);
        
        $protocol['enzymes'] = $this->getEnzymes($xml->Enzymes);
        
        $protocol['tolerance'] = $this->getParentTolerance($xml->ParentTolerance);
        
        return $protocol;
    }

    private function getEnzymes($xml)
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
                }
            }
            
            $enzyme['EnzymeName'] = $this->parseCvParam($xmlEnzyme->EnzymeName->cvParam);
            
            $enzymes[$id] = $enzyme;
        }
        
        return $enzymes;
    }

    private function getParentTolerance($xml)
    {
        $tolerances = array();
        
        foreach ($xml->cvParam as $xmlCvParam) {
            $cvParam = $this->parseCvParam($xmlCvParam);
            
            switch ($cvParam['accession']) {
                case 'MS:1001412':
                case 'MS:1001413':
                    $tolerance = new Tolerance((float) $cvParam['value'], $cvParam['unitAccession']);
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
     * Creates an array object from a CvParam object
     *
     * @param \SimpleXMLElement $xml            
     */
    private function parseCvParam($xml)
    {
        $cvParam = array();
        // Required fields
        $cvParam['cvRef'] = (string) $xml->attributes()->cvRef;
        $cvParam['accession'] = (string) $xml->attributes()->accession;
        $cvParam['name'] = (string) $xml->attributes()->name;
        
        // Optional fields
        if (isset($xml->attributes()->value)) {
            $cvParam['value'] = (string) $xml->attributes()->value;
        }
        
        if (isset($xml->attributes()->unitAccession)) {
            $cvParam['unitAccession'] = (string) $xml->attributes()->unitAccession;
        }
        
        if (isset($xml->attributes()->unitName)) {
            $cvParam['unitName'] = (string) $xml->attributes()->unitName;
        }
        
        if (isset($xml->attributes()->unitCvRef)) {
            $cvParam['unitCvRef'] = (string) $xml->attributes()->unitCvRef;
        }
        
        return $cvParam;
    }
}
