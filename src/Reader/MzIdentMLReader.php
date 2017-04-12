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
use pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters;
use pgb_liv\php_ms\Search\Parameters\MsgfPlusModification;

/**
 *
 * @author Andrew Collins
 */
class MzIdentMLReader
{

    private $filePath;

    private $xmlReader;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        
        $this->xmlReader = new \SimpleXMLElement($this->filePath, null, true);
    }

    public function getAnalysisProtocolCollection()
    {
        $xmlReader = new \SimpleXMLElement($this->filePath, null, true);
        
        foreach ($xmlReader->AnalysisProtocolCollection->SpectrumIdentificationProtocol as $spectrumIdentificationProtocol) {
            // var_dump($spectrumIdentificationProtocol->SearchType);
            
            // var_dump($spectrumIdentificationProtocol->AdditionalSearchParams);
            
            $customStuff = array();
            foreach ($spectrumIdentificationProtocol->AdditionalSearchParams->userParam as $userParam) {
                $customStuff[(string) $userParam->attributes()->name] = (string) $userParam->attributes()->value;
            }
            
            var_dump($customStuff);
            
            // var_dump($spectrumIdentificationProtocol->ModificationParams);
            
            // var_dump($spectrumIdentificationProtocol->Enzymes);
            
            // var_dump($spectrumIdentificationProtocol->ParentTolerance);
            
            // var_dump($spectrumIdentificationProtocol->Threshold);
        }
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

    public function getDataCollection()
    {
        $sequences = $this->getSequenceCollection();
        $features = array();
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
            
            $scores = array();
            foreach ($spectraItem->cvParam as $cvParam) {
                $identification->setScore((string) $cvParam->attributes()->accession, 
                    (string) $cvParam->attributes()->value);
            }
            
            $results[(string) $spectrumIdentificationResult->attributes()->id] = $spectra;
        }
        
        return $results;
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
            $modification->setResidues((string) $xmlModification->attributes()->residues);
            
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
            $param = (string) $cvParam->attributes()->accession;
            $additional['cv'][] = $param;
        }
        
        foreach ($xml->userParam as $userParam) {
            $param = array();
            $param['name'] = (string) $userParam->attributes()->name;
            $param['value'] = (string) $userParam->attributes()->value;
            
            $additional['user'][] = $param;
        }
        
        return $additional;
        
    }

    public function getSearchParameters()
    {
        $software = $this->getAnalysisSoftware();
        
        $params = array();
        foreach ($this->xmlReader->AnalysisProtocolCollection->SpectrumIdentificationProtocol as $searchProtocol) {
            $softwareId = (string) $searchProtocol->attributes()->analysisSoftware_ref;
            
            if ($software[$softwareId]['name'] == 'MS-GF+') {
                $param = new MsgfPlusSearchParameters();
            }
            
            $params['mods'] = $this->getProtocolModifications($searchProtocol->ModificationParams);            
            $params['additions'] = $this->getProtocolAdditional($searchProtocol->AdditionalSearchParams);
        }
        
        return $params;
    }
}
