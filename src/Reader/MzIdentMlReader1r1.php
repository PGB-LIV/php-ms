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
namespace pgb_liv\php_ms\Reader;

use pgb_liv\php_ms\Core\Modification;
use pgb_liv\php_ms\Core\Tolerance;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Core\Spectra\PrecursorIon;
use pgb_liv\php_ms\Core\Chromosome;
use pgb_liv\php_ms\Core\Entry\ProteinEntry;
use pgb_liv\php_ms\Core\Entry\ChromosomeProteinEntry;
use pgb_liv\php_ms\Reader\HupoPsi\PsiXmlTrait;
use pgb_liv\php_ms\Reader\HupoPsi\PsiVerb;

/**
 *
 * @author Andrew Collins
 */
class MzIdentMlReader1r1 implements MzIdentMlReader1Interface
{
    use PsiXmlTrait;

    /**
     * Map of Peptide ID => Peptide object from Peptide list
     *
     * @var Peptide[]
     */
    private $peptides = array();

    /**
     * Map of Protin ID => Protein object from DbSequence list
     *
     * @var Protein[]
     */
    private $proteins = array();

    private $evidence = array();

    private $inputs;

    /**
     * Filters to apply
     *
     * @var array
     */
    private $filter = array();

    const PROTOCOL_SPECTRUM = 'spectrum';

    const PROTOCOL_PROTEIN = 'protein';

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
    {
        // TODO: Implement
    }

    private function getAmigiousResidue()
    {
        // TODO: Implement
    }

    public function getAnalysisCollection()
    {
        // TODO: Implement
    }
    
    /**
     *
     * @return PrecursorIon[]
     */
    public function getAnalysisData()
    {
        // TODO: This should link to getProteinDetectionList
        return $this->getSpectrumIdentificationList();
    }

    private function getAnalysisParams()
    {
        // TODO: Implement
    }

    public function getAnalysisProtocolCollection()
    {
        $protocols = array();
        $protocols[self::PROTOCOL_SPECTRUM] = array();

        foreach ($this->xmlReader->AnalysisProtocolCollection->SpectrumIdentificationProtocol as $xml) {
            $protocols[self::PROTOCOL_SPECTRUM][$this->getAttributeId($xml)] = $this->getSpectrumIdentificationProtocol(
                $xml);
        }

        if (isset($this->xmlReader->AnalysisProtocolCollection->ProteinDetectionProtocol)) {
            $protocols[self::PROTOCOL_PROTEIN] = $this->getProteinDetectionProtocol();
        }

        return $protocols;
    }

    private function getAnalysisSampleCollection()
    {
        // TODO: Implement
    }

    public function getAnalysisSoftwareList()
    {
        $softwareList = array();

        foreach ($this->xmlReader->AnalysisSoftwareList->AnalysisSoftware as $analysisSoftware) {
            $softwareList[$this->getAttributeId($analysisSoftware)] = $this->getAnalysisSoftware($analysisSoftware);
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
        } elseif (isset($xml->SoftwareName->cvParam)) {
            $cvParam = $this->getCvParam($xml->SoftwareName->cvParam);
            $software['name'] = $cvParam[PsiVerb::CV_NAME];
        }

        if (isset($xml->attributes()->uri)) {
            $software['uri'] = (string) $xml->attributes()->uri;
        }

        $software['product_name'] = $software['name'];

        return $software;
    }

    private function getAuditCollection()
    {
        // TODO: Implement
    }

    private function getBibliographicReference()
    {
        // TODO: Implement
    }

    private function getContactRole()
    {
        // TODO: Implement
    }

    private function getCustomisations()
    {
        // TODO: Implement
    }

    protected function getDbSequence(\SimpleXMLElement $xml)
    {
        $protein = new Protein();

        $protein->setIdentifier((string) $xml->attributes()->accession);

        foreach ($xml->cvParam as $xmlCvParam) {
            $cvParam = $this->getCvParam($xmlCvParam);

            $this->parseDbSequenceParam($cvParam, $protein);
        }

        if (isset($xml->Seq)) {
            $sequence = $this->getSeq($xml->Seq);

            if (strlen($sequence) > 0) {
                $protein->setSequence($sequence);
            }
        }

        $databaseRef = (string) $xml->attributes()->searchDatabase_ref;

        $databases = $this->getInputs()['SearchDatabase'];

        if ($databases[$databaseRef]['isDecoy'] == 1) {
            $protein->setIsDecoy(true);
        } elseif ($databases[$databaseRef]['isDecoy'] == 2) {
            $isDecoy = preg_match('/' . $databases[$databaseRef]['decoyRules']['regExp'] . '/',
                $protein->getIdentifier());
            $protein->setIsDecoy($isDecoy > 0);
        }

        return $protein;
    }

    protected function parseDbSequenceParam(array $cvParam, Protein $protein)
    {
        switch ($cvParam[PsiVerb::CV_ACCESSION]) {
            case 'MS:1001088':
                if (isset($cvParam[PsiVerb::CV_VALUE])) {
                    $protein->setDescription($cvParam[PsiVerb::CV_VALUE]);
                }

                break;
            case 'MS:1002637':
                // Chromosome Name
                $chromosome = $protein->getChromosome();
                if (is_null($chromosome)) {
                    $protein->setChromosome(new Chromosome());
                }

                $protein->getChromosome()->setName($cvParam[PsiVerb::CV_VALUE]);
                break;
            case 'MS:1002638':
                // chromosome strand
                $chromosome = $protein->getChromosome();
                if (is_null($chromosome)) {
                    $protein->setChromosome(new Chromosome());
                }

                $protein->getChromosome()->setStrand($cvParam[PsiVerb::CV_VALUE]);
                break;
            case 'MS:1002644':
                // genome reference version
                $chromosome = $protein->getChromosome();
                if (is_null($chromosome)) {
                    $protein->setChromosome(new Chromosome());
                }

                $protein->getChromosome()->setGenomeReferenceVersion($cvParam[PsiVerb::CV_VALUE]);
                break;
            default:
                // Unknown field
                break;
        }
    }

    public function getDataCollection()
    {
        $dataCollection = array();
        $dataCollection['inputs'] = $this->getInputs();
        $dataCollection['analysisData'] = $this->getAnalysisData();

        return $dataCollection;
    }

    private function getDatabaseFilters()
    {
        // TODO: Implement
    }

    private function getDatabaseName()
    {
        // TODO: Implement
    }

    private function getDatabaseTranslation()
    {
        // TODO: Implement
    }

    /**
     * The details of an individual cleavage enzyme should be provided by giving a regular expression or a CV term if a "standard" enzyme cleavage has been
     * performed.
     *
     * @param \SimpleXMLElement $xmlEnzyme
     *            The XML element
     * @return string[]|number[]|boolean[]|NULL[]|string[][]
     */
    private function getEnzyme(\SimpleXMLElement $xmlEnzyme)
    {
        $enzyme = array();

        foreach ($xmlEnzyme->attributes() as $attribute => $value) {
            switch ($attribute) {
                case 'cTermGain':
                    $enzyme['cTermGain'] = (string) $value;
                    break;
                case 'id':
                    $enzyme['id'] = (string) $value;
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
                    // Unknown element
                    break;
            }
        }

        if (isset($xmlEnzyme->EnzymeName)) {
            $enzyme['EnzymeName'] = $this->getEnzymeName($xmlEnzyme->EnzymeName);
        }

        return $enzyme;
    }

    private function getEnzymeName(\SimpleXMLElement $enzymeName)
    {
        if (isset($enzymeName->cvParam)) {
            return $this->getCvParam($enzymeName->cvParam);
        }

        return null;
    }

    /**
     * The list of enzymes used in experiment
     *
     * @param \SimpleXMLElement $xml
     * @return array
     */
    protected function getEnzymes(\SimpleXMLElement $xml)
    {
        $enzymes = array();

        foreach ($xml->Enzyme as $xmlEnzyme) {
            $enzyme = $this->getEnzyme($xmlEnzyme);

            if (isset($enzyme['id'])) {
                $enzymes[$enzyme['id']] = $enzyme;
                continue;
            }

            $enzymes[] = $enzyme;
        }

        return $enzymes;
    }

    private function getExclude()
    {
        // TODO: Implement
    }

    private function getExternalFormatDocumentation()
    {
        // TODO: Implement
    }

    /**
     * The format of the ExternalData file, for example "tiff" for image files.
     *
     * @param \SimpleXMLElement $xml
     *            XML to parse
     */
    private function getFileFormat(\SimpleXMLElement $xml)
    {
        $formats = array();

        foreach ($xml->cvParam as $xmlCvParam) {
            $cvParam = $this->getCvParam($xmlCvParam);

            $formats[] = $cvParam[PsiVerb::CV_ACCESSION];
        }

        return $formats;
    }

    private function getFilter()
    {
        // TODO: Implement
    }

    private function getFilterType()
    {
        // TODO: Implement
    }

    private function getFragmentArray()
    {
        // TODO: Implement
    }

    private function getFragmentTolerance(\SimpleXMLElement $xml)
    {
        return $this->getTolerance($xml);
    }

    private function getFragmentation()
    {
        // TODO: Implement
    }

    private function getFragmentationTable()
    {
        // TODO: Implement
    }

    private function getInclude()
    {
        // TODO: Implement
    }

    private function getInputSpectra()
    {
        // TODO: Implement
    }

    private function getInputSpectrumIdentifications()
    {
        // TODO: Implement
    }

    public function getInputs()
    {
        if (is_null($this->inputs)) {
            $this->inputs = array();
            $this->inputs['SearchDatabase'] = array();
            foreach ($this->xmlReader->DataCollection->Inputs->SearchDatabase as $xml) {
                $this->inputs['SearchDatabase'][$this->getAttributeId($xml)] = $this->getSearchDatabase($xml);
            }

            $this->inputs['SpectraData'] = array();
            foreach ($this->xmlReader->DataCollection->Inputs->SpectraData as $xml) {
                $this->inputs['SpectraData'][$this->getAttributeId($xml)] = $this->getSpectraData($xml);
            }
        }

        return $this->inputs;
    }

    private function getIonType()
    {
        // TODO: Implement
    }

    private function getMassTable()
    {
        // TODO: Implement
    }

    private function getMeasure()
    {
        // TODO: Implement
    }

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
            if (strlen($residues) > 0) {
                $modification->setResidues(str_split($residues));
            }
        }

        $cvParam = $this->getCvParam($xml->cvParam);

        if ($cvParam[PsiVerb::CV_ACCESSION] == 'MS:1001460') {
            // Unknown modification
            $name = isset($cvParam[PsiVerb::CV_VALUE]) ? $cvParam[PsiVerb::CV_VALUE] : 'Unknown Modification';

            $modification->setName($name);
        } else {
            // Known modification
            $modification->setAccession($cvParam[PsiVerb::CV_ACCESSION]);
            $modification->setName($cvParam[PsiVerb::CV_NAME]);
        }

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
    {
        // TODO: Implement
    }

    private function getParent()
    {
        // TODO: Implement
    }

    protected function getParentTolerance(\SimpleXMLElement $xml)
    {
        return $this->getTolerance($xml);
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

    /**
     *
     * @param \SimpleXMLElement $xml
     * @param Peptide[] $peptides
     * @param Protein[] $proteins
     * @return ProteinEntry
     */
    private function getPeptideEvidence(\SimpleXMLElement $xml)
    {
        $peptideEvidence = array();
        $peptideEvidence['peptide'] = (string) $xml->attributes()->peptide_ref;
        $peptideEvidence['protein'] = (string) $xml->attributes()->dBSequence_ref;
        $peptideEvidence['start'] = (int) $xml->attributes()->start;
        $peptideEvidence['end'] = (int) $xml->attributes()->end;
        $peptideEvidence['is_decoy'] = (string) $xml->attributes()->isDecoy == 'true';
        $peptideEvidence['cv'] = array();

        foreach ($xml->cvParam as $xmlCvParam) {
            $cvParam = $this->getCvParam($xmlCvParam);
            $peptideEvidence['cv'][] = $cvParam;
        }

        return $peptideEvidence;
    }

    /**
     * Reference to the PeptideEvidence element identified.
     * If a specific sequence can be assigned to multiple proteins and or positions in a protein all possible PeptideEvidence elements should be referenced
     * here.
     *
     * @param \SimpleXMLElement $xml
     *            XML to parse
     * @return ProteinEntry
     */
    private function getPeptideEvidenceRef(\SimpleXMLElement $xml)
    {
        return (string) $xml->attributes()->peptideEvidence_ref;
    }

    /**
     * Peptide evidence on which this ProteinHypothesis is based by reference to a PeptideEvidence element.
     *
     * @param \SimpleXMLElement $xml
     *            XML to parse
     */
    private function getPeptideHypothesis(\SimpleXMLElement $xml)
    {
        $hypothesis = array();
        $ref = (string) $xml->attributes()->peptideEvidence_ref;

        $hypothesis['peptide'] = $ref;
        $hypothesis['spectra'] = array();

        // TODO: Nothing we can currently do with this data - yet
        foreach ($xml->SpectrumIdentificationItemRef as $spectrumIdentificationItemRef) {
            $hypothesis['spectra'][] = $this->getSpectrumIdentificationItemRef($spectrumIdentificationItemRef);
        }

        return $hypothesis;
    }

    protected function getPeptideSequence(\SimpleXMLElement $xml)
    {
        return (string) $xml;
    }

    private function getPerson()
    {
        // TODO: Implement
    }

    /**
     * A set of logically related results from a protein detection, for example to represent conflicting assignments of peptides to proteins.
     *
     * @param \SimpleXMLElement $xml
     *            XML to parse
     */
    private function getProteinAmbiguityGroup(\SimpleXMLElement $xml)
    {
        $hypos = array();
        foreach ($xml->ProteinDetectionHypothesis as $proteinDetectionHypothesis) {
            $hypo = $this->getProteinDetectionHypothesis($proteinDetectionHypothesis);
            $hypos[$hypo['id']] = $hypo;
        }

        return $hypos;
    }

    private function getProteinDetection()
    {
        // TODO: Implement
    }

    /**
     * A single result of the ProteinDetection analysis (i.e.
     * a protein).
     *
     * @param \SimpleXMLElement $xml
     *            XML to parse
     */
    private function getProteinDetectionHypothesis(\SimpleXMLElement $xml)
    {
        $hypothesis = array();

        $hypothesis['id'] = $this->getAttributeId($xml);
        $hypothesis['passThreshold'] = ((string) $xml->attributes()->passThreshold) == 'true';

        if (isset($xml->attributes()->name)) {
            $hypothesis['name'] = (string) $xml->attributes()->name;
        }

        if (isset($xml->attributes()->dBSequence_ref)) {
            $ref = (string) $xml->attributes()->dBSequence_ref;
            $hypothesis['protein'] = $ref;
        }

        $hypoPeptides = array();
        foreach ($xml->PeptideHypothesis as $peptideHypothesis) {
            $hypoPeptides[] = $this->getPeptideHypothesis($peptideHypothesis);
        }

        $cvParams = array();
        foreach ($xml->cvParam as $cvParam) {
            $cvParams[] = $this->getCvParam($cvParam);
        }

        $hypothesis['peptides'] = $hypoPeptides;
        $hypothesis['cvParam'] = $cvParams;

        return $hypothesis;
    }

    /**
     * The protein list resulting from a protein detection process.
     */
    public function getProteinDetectionList()
    {
        $this->getSequenceCollection();

        $groups = array();

        if (! isset($this->xmlReader->DataCollection->AnalysisData->ProteinDetectionList->ProteinAmbiguityGroup)) {
            return null;
        }

        foreach ($this->xmlReader->DataCollection->AnalysisData->ProteinDetectionList->ProteinAmbiguityGroup as $proteinAmbiguityGroup) {
            $group = $this->getProteinAmbiguityGroup($proteinAmbiguityGroup);
            $groupId = $this->getAttributeId($proteinAmbiguityGroup);
            // Reprocess each group to change refs to element
            foreach ($group as $id => $value) {
                $group[$id]['protein'] = $this->proteins[$value['protein']];

                foreach ($value['peptides'] as $pepId => $peptide) {
                    $group[$id]['peptides'][$pepId] = $this->peptides[$this->evidence[$peptide['peptide']]['peptide']];
                }
            }

            $groups[$groupId] = $group;
        }

        return $groups;
    }

    public function getProteinDetectionProtocol()
    {
        $xml = $this->xmlReader->AnalysisProtocolCollection->ProteinDetectionProtocol;

        $software = $this->getAnalysisSoftwareList();

        $protocol = array();
        $softwareId = (string) $xml->attributes()->analysisSoftware_ref;

        $protocol['software'] = $software[$softwareId];

        $protocol['threshold'] = $this->getThreshold($xml->Threshold);

        return $protocol;
    }

    private function getProvider()
    {
        // TODO: Implement
    }

    private function getResidue()
    {
        // TODO: Implement
    }

    private function getRole()
    {
        // TODO: Implement
    }

    private function getSample()
    {
        // TODO: Implement
    }

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

        $database['isDecoy'] = 0;

        $database['decoyRules'] = array(
            'isReversed' => false,
            'isMixed' => false,
            'regExp' => null
        );
        foreach ($xml->cvParam as $xmlCvParam) {
            $cvParam = $this->getCvParam($xmlCvParam);

            switch ($cvParam[PsiVerb::CV_ACCESSION]) {
                case 'MS:1001195':
                    $database['decoyRules']['isReversed'] = true;
                    break;
                case 'MS:1001197':
                    $database['decoyRules']['isMixed'] = true;
                    break;
                case 'MS:1001283':
                    $database['decoyRules']['regExp'] = $cvParam[PsiVerb::CV_VALUE];
                    break;
                default:
                    break;
            }
        }

        if ($database['decoyRules']['isMixed']) {
            $database['isDecoy'] = 2;
        } elseif ($database['decoyRules']['isReversed']) {
            $database['isDecoy'] = 1;
        }

        return $database;
    }

    private function getSearchDatabaseRef()
    {
        // TODO: Implement
    }

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

        if ($residues != '.') {
            $residues = explode(' ', $residues);

            $modification->setResidues($residues);
        }

        $modType = Modification::TYPE_VARIABLE;

        if ((string) $xml->attributes()->fixedMod == 'true') {
            $modType = Modification::TYPE_FIXED;
        }

        $modification->setType($modType);

        $cvParam = $this->getCvParam($xml->cvParam);

        if ($cvParam[PsiVerb::CV_ACCESSION] == 'MS:1001460') {
            // Unknown modification
            $name = isset($cvParam[PsiVerb::CV_VALUE]) ? $cvParam[PsiVerb::CV_VALUE] : 'Unknown Modification';

            $modification->setName($name);
        } else {
            $modification->setName($cvParam[PsiVerb::CV_NAME]);
        }

        return $modification;
    }

    private function getSearchType()
    {
        // TODO: Implement
    }

    protected function getSeq(\SimpleXMLElement $xml)
    {
        return (string) $xml;
    }

    public function getSequenceCollection()
    {
        $this->getSequenceCollectionProteins();
        $this->getSequenceCollectionPeptides();

        if (count($this->evidence) == 0) {
            foreach ($this->xmlReader->SequenceCollection->PeptideEvidence as $peptideEvidence) {
                $this->evidence[$this->getAttributeId($peptideEvidence)] = $this->getPeptideEvidence($peptideEvidence,
                    $this->peptides, $this->proteins);
            }
        }

        return array(
            'peptides' => $this->peptides,
            'proteins' => $this->proteins,
            'evidence' => $this->evidence
        );
    }

    private function getSequenceCollectionPeptides()
    {
        if (count($this->peptides) == 0) {
            foreach ($this->xmlReader->SequenceCollection->Peptide as $xml) {
                $this->peptides[$this->getAttributeId($xml)] = $this->getPeptide($xml);
            }
        }

        return $this->peptides;
    }

    private function getSequenceCollectionProteins()
    {
        if (count($this->proteins) == 0) {
            foreach ($this->xmlReader->SequenceCollection->DBSequence as $xml) {
                $this->proteins[$this->getAttributeId($xml)] = $this->getDbSequence($xml);
            }
        }

        return $this->proteins;
    }

    private function getSiteRegexp()
    {
        // TODO: Implement
    }

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
    {
        // TODO: Implement
    }

    protected function getSpecifityRules(\SimpleXMLElement $xml)
    {
        foreach ($xml->cvParam as $xmlParam) {
            $cvParam = $this->getCvParam($xmlParam);
            switch ($cvParam[PsiVerb::CV_ACCESSION]) {
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

        $spectra['format']['id'] = $this->getSpectrumIdFormat($xml->SpectrumIDFormat);
        $spectra['format']['file'] = $this->getFileFormat($xml->FileFormat);

        return $spectra;
    }

    /**
     * The format of the spectrum identifier within the source file.
     *
     * @param \SimpleXMLElement $xml
     *            XML to parse
     * @return string
     */
    private function getSpectrumIdFormat(\SimpleXMLElement $xml)
    {
        $cvParam = $this->getCvParam($xml->cvParam);

        return $cvParam[PsiVerb::CV_ACCESSION];
    }

    private function getSpectrumIdentification()
    {
        // TODO: Implement
    }

    /**
     * An identification of a single (poly)peptide, resulting from querying an input spectra, along with the set of confidence values for that identification.
     * PeptideEvidence elements should be given for all mappings of the corresponding Peptide sequence within protein sequences.
     *
     * @param \SimpleXMLElement $xml
     *            XML to parse
     * @return \pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    private function getSpectrumIdentificationItem(\SimpleXMLElement $xml)
    {
        $identification = new Identification();
        $identification->setRank((int) $xml->attributes()->rank);

        // peptide_ref will tell use the peptide?
        if (isset($xml->attributes()->peptide_ref)) {
            $peptide = clone $this->peptides[(string) $xml->attributes()->peptide_ref];
        } else {
            $peptide = clone $this->peptides[$this->evidence[(string) $xml->PeptideEvidenceRef->attributes->peptideEvidence_ref]['peptide']];
        }

        $identification->setSequence($peptide);

        foreach ($xml->PeptideEvidenceRef as $peptideEvidenceRef) {
            $ref = $this->getPeptideEvidenceRef($peptideEvidenceRef);
            $peptideEvidence = $this->evidence[$ref];
            $protein = $this->proteins[$peptideEvidence['protein']];
            $peptide->setIsDecoy($peptideEvidence['is_decoy']);

            $entry = $this->getProteinEntryType($peptideEvidence, $protein);

            $entry->setStart($peptideEvidence['start']);
            $entry->setEnd($peptideEvidence['end']);

            $this->parsePeptideEvidenceCv($peptideEvidence['cv'], $entry);

            $peptide->addProteinEntry($entry);
        }

        foreach ($xml->cvParam as $cvParam) {
            $cvParam = $this->getCvParam($cvParam);
            switch ($cvParam[PsiVerb::CV_ACCESSION]) {
                case 'MS:1001363':
                // peptide unique to one protein - not supported
                case 'MS:1001175':
                // Peptide shared in multipe proteins - not supported
                case 'MS:1000016':
                // Scan start time - not supported
                case 'MS:1002315':
                    // Concensus result - not supported
                    break;
                default:
                    $identification->setScore($cvParam[PsiVerb::CV_ACCESSION], $cvParam[PsiVerb::CV_VALUE]);
                    break;
            }
        }

        return $identification;
    }

    private function parsePeptideEvidenceCv(array $cvParams, ProteinEntry $entry)
    {
        foreach ($cvParams as $cvParam) {
            switch ($cvParam[PsiVerb::CV_ACCESSION]) {
                case 'MS:1002640':
                    // peptide end on chromosome
                    $entry->setChromosomePositionEnd((int) $cvParam[PsiVerb::CV_VALUE]);
                    break;
                case 'MS:1002641':
                    // peptide exon count
                    $entry->setChromosomeBlockCount((int) $cvParam[PsiVerb::CV_VALUE]);
                    break;
                case 'MS:1002642':
                    // peptide exon nucleotide sizes
                    $blockSizesStr = explode(',', $cvParam[PsiVerb::CV_VALUE]);
                    $blockSizes = array();
                    foreach ($blockSizesStr as $blockSize) {
                        $blockSizes[] = (int) $blockSize;
                    }

                    $entry->setChromosomeBlockSizes($blockSizes);
                    break;
                case 'MS:1002643':
                    // peptide start positions on chromosome
                    $positions = array();
                    $chunks = explode(',', $cvParam[PsiVerb::CV_VALUE]);
                    foreach ($chunks as $chunk) {
                        $positions[] = (int) $chunk;
                    }

                    $entry->setChromosomePositionsStart($positions);
                    break;
                default:
                    // Unknown field
                    break;
            }
        }
    }

    /**
     * PeptideEvidence element.
     * Using these references it is possible to indicate which spectra were actually accepted as evidence for this peptide identification in the given protein.
     *
     * @param \SimpleXMLElement $xml
     *            XML to parse
     * @return string
     */
    private function getSpectrumIdentificationItemRef(\SimpleXMLElement $xml)
    {
        return (string) $xml->attributes()->spectrumIdentificationItem_ref;
    }

    /**
     *
     * @return PrecursorIon[]
     */
    private function getSpectrumIdentificationList()
    {
        $sequences = $this->getSequenceCollection();
        $results = array();
        foreach ($this->xmlReader->DataCollection->AnalysisData->SpectrumIdentificationList->SpectrumIdentificationResult as $xml) {
            $results[$this->getAttributeId($xml)] = $this->getSpectrumIdentificationResult($xml, $sequences);
        }

        return $results;
    }

    protected function getSpectrumIdentificationProtocol(\SimpleXMLElement $xml)
    {
        $software = $this->getAnalysisSoftwareList();

        $protocol = array();
        $softwareId = (string) $xml->attributes()->analysisSoftware_ref;

        $protocol['software'] = $software[$softwareId];

        $protocol['modifications'] = array();

        if (isset($xml->ModificationParams)) {
            $protocol['modifications'] = $this->getModificationParams($xml->ModificationParams);
        }

        if (isset($xml->AdditionalSearchParams)) {
            $protocol['additions'] = $this->getAdditionalSearchParams($xml->AdditionalSearchParams);
        }

        if (isset($xml->Enzymes)) {
            $protocol['enzymes'] = $this->getEnzymes($xml->Enzymes);
        }

        if (isset($xml->FragmentTolerance)) {
            $protocol['fragmentTolerance'] = $this->getFragmentTolerance($xml->FragmentTolerance);
        }

        if (isset($xml->ParentTolerance)) {
            $protocol['parentTolerance'] = $this->getParentTolerance($xml->ParentTolerance);
        }

        return $protocol;
    }

    /**
     *
     * @param \SimpleXMLElement $xml
     *            XML object to parse
     * @param Peptide[] $sequences
     *            Array of peptide sequences to use for identifications
     * @return PrecursorIon
     */
    private function getSpectrumIdentificationResult(\SimpleXMLElement $xml, array $sequences)
    {
        $spectra = new PrecursorIon();
        $spectra->setIdentifier((string) $xml->attributes()->spectrumID);

        // We can not currently pull data from the .raw data so take the m/z vlaues from the first identification
        $charge = (int) $xml->SpectrumIdentificationItem->attributes()->chargeState;
        $massCharge = (float) $xml->SpectrumIdentificationItem->attributes()->experimentalMassToCharge;

        $spectra->setMonoisotopicMassCharge($massCharge, $charge);

        foreach ($xml->SpectrumIdentificationItem as $spectrumItem) {
            $identification = $this->getSpectrumIdentificationItem($spectrumItem, $sequences);

            if (! $this->isFilterMatch($identification)) {
                continue;
            }

            $spectra->addIdentification($identification);
        }

        foreach ($xml->cvParam as $cvParam) {
            $cvParam = $this->getCvParam($cvParam);
            switch ($cvParam[PsiVerb::CV_ACCESSION]) {
                case 'MS:1000796':
                    $spectra->setTitle($cvParam[PsiVerb::CV_VALUE]);
                    break;
                case 'MS:1001115':
                    $spectra->setScan((float) $cvParam[PsiVerb::CV_VALUE]);
                    break;
                default:
                    // Unknown element
                    break;
            }
        }

        return $spectra;
    }

    private function getSubSample()
    {
        // TODO: Implement
    }

    private function getSubstitutionModification()
    {
        // TODO: Implement
    }

    private function getThreshold(\SimpleXMLElement $xmlThreshold)
    {
        $params = array();

        foreach ($xmlThreshold->cvParam as $xmlParam) {
            $params[] = $this->getCvParam($xmlParam);
        }

        return $params;
    }

    private function getTolerance(\SimpleXMLElement $xml)
    {
        $tolerances = array();

        foreach ($xml->cvParam as $xmlCvParam) {
            $cvParam = $this->getCvParam($xmlCvParam);

            switch ($cvParam[PsiVerb::CV_ACCESSION]) {
                case 'MS:1001412':
                case 'MS:1001413':
                    $tolerance = new Tolerance((float) $cvParam[PsiVerb::CV_VALUE], $cvParam[PsiVerb::CV_UNITACCESSION]);
                    break;
                default:
                    $tolerance = $cvParam;
                    break;
            }

            $tolerances[] = $tolerance;
        }

        return $tolerances;
    }

    private function getTranslationTable()
    {
        // TODO: Implement
    }

    private function getCv()
    {
        // TODO: Implement
    }

    private function getCvList()
    {
        // TODO: Implement
    }

    private function getProteinEntryType(array $peptideEvidence, Protein $protein)
    {
        foreach ($peptideEvidence['cv'] as $cvParam) {
            switch ($cvParam[PsiVerb::CV_ACCESSION]) {
                case 'MS:1002640':
                case 'MS:1002641':
                case 'MS:1002642':
                case 'MS:1002643':
                    return new ChromosomeProteinEntry($protein);
                default:
                    break;
            }
        }

        return new ProteinEntry($protein);
    }

    private function isFilterMatch(Identification $identification)
    {
        // Remove idents > rank filter
        if (isset($this->filter['rank']) && $identification->getRank() > $this->filter['rank']) {
            return false;
        }

        return true;
    }

    /**
     * Sets the rank limit for retrieved identifications.
     * All returned indentifications will be <= $rank
     *
     * @param int $rank
     */
    public function setRankFilter($rank)
    {
        $this->filter['rank'] = $rank;
    }
}
