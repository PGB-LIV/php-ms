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
namespace pgb_liv\php_ms\Writer;

use pgb_liv\php_ms\Core\Entry\ProteinEntry;
use pgb_liv\php_ms\Core\Spectra\PrecursorIon;
use pgb_liv\php_ms\Core\Modification;
use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Core\Tolerance;
use PhpObo\LineReader;
use PhpObo\Parser;

/**
 * Class for generating mzIdentML files from a protein/peptide object hierarchy
 *
 * @author Andrew Collins
 */
class MzIdentMlWriter
{

    const SPECTRUM_IDENTIFICATION_PREFIX = 'SI_';

    const SPECTRUM_IDENTIFICATION_PROTOCOL_PREFIX = 'SIP_';

    const SPECTRUM_IDENTIFICATION_LIST_PREFIX = 'SIL_';

    const SPECTRUM_IDENTIFICATION_RESULT_PREFIX = 'SIR_';

    const SPECTRUM_IDENTIFICATION_ITEM_PREFIX = 'SII_';

    const SPECTRA_DATA_PREFIX = 'SD_';

    const SEARCH_DATABASE_PREFIX = 'SDB_';

    const ENZYME_PREFIX = 'ENZ_';

    private $path;

    /**
     *
     * @var \XMLWriter
     */
    private $stream;

    private $cvList = array();

    private $softwareList = array();

    private $spectraData = array();

    private $searchData = array();

    private $psiMsRef = 'PSI-MS';

    private $uoRef = 'UO';

    private $scoreMap = array();

    private $modifications = array();

    private $enzymes = array();

    /**
     *
     * @var Tolerance[]
     */
    private $fragmentTolerance = array();

    /**
     *
     * @var Tolerance[]
     */
    private $parentTolerance = array();

    /**
     * Write to the specified stream
     *
     * @param string $path
     */
    private $oboRef = array();

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function open()
    {
        // Add default CV
        $this->addCv('Proteomics Standards Initiative Mass Spectrometry Vocabularies', '4.1.12',
            'https://raw.githubusercontent.com/HUPO-PSI/psi-ms-CV/master/psi-ms.obo', $this->psiMsRef);
        $this->addCv('Unit Ontology', null,
            'https://raw.githubusercontent.com/bio-ontology-research-group/unit-ontology/master/unit.obo', $this->uoRef);

        // Create empty file we can append to
        file_put_contents($this->path, '');

        $this->stream = new \XMLWriter();
        $this->stream->openMemory();
        $this->stream->setIndent(true);
        $this->stream->startDocument('1.0', 'UTF-8');

        $this->writeMzIdentMl();
        $this->writeCvList();
        $this->writeAnalysisSoftwareList();
        $this->flush();
    }

    public function close()
    {
        // finalise
        $this->stream->endElement();
        $this->flush();
    }

    private function flush()
    {
        file_put_contents($this->path, $this->stream->flush(true), FILE_APPEND);
    }

    /**
     * CV terms must be added prior to open being called
     *
     * @param string $name
     * @param string $version
     * @param string $uri
     * @param string $id
     */
    public function addCv($name, $version, $uri, $cvRef)
    {
        $this->cvList[] = array(
            'fullName' => $name,
            'version' => $version,
            'uri' => $uri,
            'id' => $cvRef
        );

        // read in obo file
        $handle = fopen($uri, 'r');
        $lineReader = new LineReader($handle);
        // parse file
        $parser = new Parser($lineReader);
        $parser->retainTrailingComments(true);
        $parser->getDocument()->mergeStanzas(false); // speed tip
        $parser->parse();

        $terms = array();
        foreach ($parser->getDocument()->getStanzas('Term') as $term) {
            $id = $term->get('id');
            $name = $term->get('name');

            $terms[$id] = $name;
        }

        $this->oboRef[$cvRef] = $terms;
    }

    /**
     * Use the specified cvParam to map peptide scores
     *
     * @param string $cvParam
     * @param string $scoreKey
     */
    public function addScore($cvParam, $scoreKey)
    {
        $this->scoreMap[$cvParam] = $scoreKey;
    }

    /**
     * Software ID's must be added prior to open being called
     *
     * @param string $name
     * @param string $id
     */
    public function addSoftware($id, $name, $version)
    {
        $this->softwareList[] = array(
            'id' => $id,
            'name' => $name,
            'version' => $version
        );
    }

    public function addSpectraData($path)
    {
        $this->spectraData[] = $path;
    }

    public function addSearchData($path, $sequenceCount = null, $releaseDate = null)
    {
        $this->searchData[] = array(
            'path' => $path,
            'isDecoy' => false,
            'sequenceCount' => $sequenceCount,
            'releaseDate' => $releaseDate
        );
    }

    public function addDecoyData($path, $sequenceCount = null, $releaseDate = null)
    {
        $this->searchData[] = array(
            'path' => $path,
            'isDecoy' => true,
            'sequenceCount' => $sequenceCount,
            'releaseDate' => $releaseDate
        );
    }

    public function addFragmentTolerance(Tolerance $plus, Tolerance $minus = null)
    {
        $this->fragmentTolerance[] = $plus;
        if (! is_null($minus)) {
            $this->fragmentTolerance[] = $minus;
        }
    }

    public function addParentTolerance(Tolerance $plus, Tolerance $minus = null)
    {
        $this->parentTolerance[] = $plus;
        if (! is_null($minus)) {
            $this->parentTolerance[] = $minus;
        }
    }

    public function addModification(Modification $modification)
    {
        $this->modifications[] = $modification;
    }

    public function addEnzyme($accession, $cvRef, $missedCleavages)
    {
        $this->enzymes[] = array(
            'accession' => $accession,
            'cvRef' => $cvRef,
            'missedCleavages' => $missedCleavages
        );
    }

    /**
     *
     * @param PrecursorIon[] $precursors
     */
    public function addIdentifiedPrecursors(array $precursors)
    {
        echo '[' . date('r') . '] Writing sequences.' . PHP_EOL;
        $this->writeSequenceCollection($precursors);
        $this->flush();

        $this->writeAnalysisCollection();
        $this->flush();

        $this->writeAnalysisProtocolCollection();
        $this->flush();

        $this->writeDataCollection($precursors);
        $this->flush();
    }

    private function writeMzIdentMl()
    {
        $this->stream->startElement('MzIdentML');
        $this->stream->writeAttribute('version', '1.2.0');
        $this->stream->writeAttribute('id', '');
        $this->stream->writeAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $this->stream->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $this->stream->writeAttribute('xsi:schemaLocation',
            'http://psidev.info/psi/pi/mzIdentML/1.2 http://www.psidev.info/files/mzIdentML1.2.0.xsd');
        $this->stream->writeAttribute('xmlns', 'http://psidev.info/psi/pi/mzIdentML/1.2');
    }

    private function writeCvList()
    {
        if (empty($this->cvList)) {
            throw new \UnexpectedValueException('MzIdentML requires at least one CV to be used');
        }

        $this->stream->startElement('cvList');

        foreach ($this->cvList as $cv) {
            $this->writeCv($cv);
        }

        $this->stream->endElement();
    }

    private function writeCv($cv)
    {
        $this->stream->startElement('cv');
        foreach ($cv as $key => $value) {
            $this->stream->writeAttribute($key, $value);
        }

        $this->stream->endElement();
    }

    private function writeDataCollection(array $precursors)
    {
        $this->stream->startElement('DataCollection');

        $this->writeInputs();

        $this->writeAnalysisData($precursors);

        $this->stream->endElement();
    }

    private function writeAnalysisData(array $precursors)
    {
        $this->stream->startElement('AnalysisData');

        $this->writeSpectrumIdentificationList($precursors);

        $this->stream->endElement();
    }

    /**
     *
     * @param PrecursorIon[] $precursors
     */
    private function writeSpectrumIdentificationList(array $precursors)
    {
        $this->stream->startElement('SpectrumIdentificationList');

        $this->stream->writeAttribute('id', self::SPECTRUM_IDENTIFICATION_LIST_PREFIX . '1');

        $sirId = 0;
        foreach ($precursors as $precursor) {
            $this->writeSpectrumIdentificationResult($sirId, $precursor);
            $sirId ++;

            if ($sirId % 100 == 0) {
                $this->flush();
            }
        }

        $this->stream->endElement();
    }

    private function writeSpectrumIdentificationResult($sirId, PrecursorIon $precursor)
    {
        $this->stream->startElement('SpectrumIdentificationResult');
        $this->stream->writeAttribute('id', self::SPECTRUM_IDENTIFICATION_RESULT_PREFIX . $sirId);

        // Currently only support one dataset
        $this->stream->writeAttribute('spectraData_ref', self::SPECTRA_DATA_PREFIX . '0');
        $this->stream->writeAttribute('spectrumID', 'index=' . $precursor->getIdentifier());

        $siiId = 0;
        foreach ($precursor->getIdentifications() as $identification) {
            $this->writeSpectrumIdentificationItem($sirId . '_' . $siiId, $precursor, $identification);
            $siiId ++;
        }

        $this->writeCvParam('MS:1000796', $this->psiMsRef, $precursor->getTitle());
        $this->writeCvParam('MS:1000894', $this->psiMsRef, $precursor->getRetentionTime(), 'UO:0000010', $this->uoRef,
            'second');

        $this->stream->endElement();
    }

    private function writeSpectrumIdentificationItem($siiId, PrecursorIon $precursor, Identification $identification)
    {
        $this->stream->startElement('SpectrumIdentificationItem');
        $this->stream->writeAttribute('chargeState', $precursor->getCharge());
        $this->stream->writeAttribute('experimentalMassToCharge', $precursor->getMonoisotopicMassCharge());
        $this->stream->writeAttribute('id', self::SPECTRUM_IDENTIFICATION_ITEM_PREFIX . $siiId);
        $this->stream->writeAttribute('passThreshold', 'true');
        $this->stream->writeAttribute('peptide_ref', $this->getId($identification->getSequence()));
        $this->stream->writeAttribute('rank', $identification->getRank());

        $this->stream->writeAttribute('calculatedMassToCharge',
            $identification->getSequence()
                ->getMonoisotopicMassCharge($precursor->getCharge()));

        foreach ($identification->getSequence()->getProteins() as $proteinEntry) {
            $ref = $this->getId($identification->getSequence()) . '_' . $proteinEntry->getProtein()->getIdentifier();
            $this->writePeptideEvidenceRef($ref);
        }

        $scores = $identification->getScores();
        foreach ($this->scoreMap as $cvParam => $scoreKey) {
            $this->writeCvParam($cvParam, $this->psiMsRef, $scores[$scoreKey]);
        }

        $this->stream->endElement();
    }

    private function writePeptideEvidenceRef($ref)
    {
        $this->stream->startElement('PeptideEvidenceRef');
        $this->stream->writeAttribute('peptideEvidence_ref', $ref);

        $this->stream->endElement();
    }

    private function writeInputs()
    {
        $this->stream->startElement('Inputs');

        foreach (array_keys($this->searchData) as $id) {
            $this->writeSearchDatabase($id);
        }

        foreach (array_keys($this->spectraData) as $id) {
            $this->writeSpectraData($id);
        }

        $this->stream->endElement();
    }

    private function writeSpectraData($id)
    {
        $this->stream->startElement('SpectraData');

        $this->stream->writeAttribute('id', self::SPECTRA_DATA_PREFIX . $id);
        $this->stream->writeAttribute('location', $this->spectraData[$id]);

        $this->writeFileFormat($this->spectraData[$id]);
        $this->writeSpectrumIdFormat($id);

        $this->stream->endElement();
    }

    private function writeSpectrumIdFormat()
    {
        $this->stream->startElement('SpectrumIDFormat');

        $this->writeCvParam('MS:1000774', $this->psiMsRef);

        $this->stream->endElement();
    }

    private function writeSearchDatabase($id)
    {
        $this->stream->startElement('SearchDatabase');

        $this->stream->writeAttribute('id', self::SEARCH_DATABASE_PREFIX . $id);
        $this->stream->writeAttribute('location', $this->searchData[$id]['path']);

        if (! is_null($this->searchData[$id]['sequenceCount'])) {
            $this->stream->writeAttribute('numDatabaseSequences', $this->searchData[$id]['sequenceCount']);
        }

        if (! is_null($this->searchData[$id]['releaseDate'])) {
            $this->stream->writeAttribute('releaseDate', date('Y-m-d\TH:i:sP', $this->searchData[$id]['releaseDate']));
        }

        $this->writeFileFormat($this->searchData[$id]['path']);
        $this->writeDatabaseName($id);

        if ($this->searchData[$id]['isDecoy']) {
            $this->writeCvParam('MS:1001195', $this->psiMsRef);
        } else {
            $this->writeCvParam('MS:1001073', $this->psiMsRef);
        }

        $this->stream->endElement();
    }

    private function writeFileFormat($path)
    {
        $this->stream->startElement('FileFormat');

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'mgf':
                $this->writeCvParam('MS:1001062', $this->psiMsRef);
                break;
            case 'fasta':
                $this->writeCvParam('MS:1001348', $this->psiMsRef);
                break;
            default:
                // Unknown?
                break;
        }

        $this->stream->endElement();
    }

    private function writeDatabaseName($id)
    {
        $name = basename($this->searchData[$id]['path']);
        $this->stream->startElement('DatabaseName');

        $this->writeUserParam($name);

        $this->stream->endElement();
    }

    private function writeAnalysisSoftwareList()
    {
        if (empty($this->softwareList)) {
            return;
        }

        $this->stream->startElement('AnalysisSoftwareList');

        foreach ($this->softwareList as $software) {
            $this->writeAnalysisSoftware($software);
        }

        $this->stream->endElement();
    }

    private function writeAnalysisCollection()
    {
        $this->stream->startElement('AnalysisCollection');

        foreach (array_keys($this->searchData) as $id) {
            $this->writeSpectrumIdentification($id);
        }

        $this->stream->endElement();
    }

    private function writeSpectrumIdentification($id)
    {
        $this->stream->startElement('SpectrumIdentification');

        $this->stream->writeAttribute('id', self::SPECTRUM_IDENTIFICATION_PREFIX . $id);

        // We only support one of each these elements
        $this->stream->writeAttribute('spectrumIdentificationProtocol_ref',
            self::SPECTRUM_IDENTIFICATION_PROTOCOL_PREFIX . '1');
        $this->stream->writeAttribute('spectrumIdentificationList_ref', self::SPECTRUM_IDENTIFICATION_LIST_PREFIX . '1');

        $this->writeInputSpectra(0);

        $this->writeSearchDatabaseRef($id);

        $this->stream->endElement();
    }

    private function writeInputSpectra($id)
    {
        $this->stream->startElement('InputSpectra');

        $this->stream->writeAttribute('spectraData_ref', self::SPECTRA_DATA_PREFIX . $id);

        $this->stream->endElement();
    }

    private function writeSearchDatabaseRef($id)
    {
        $this->stream->startElement('SearchDatabaseRef');

        $this->stream->writeAttribute('searchDatabase_ref', self::SEARCH_DATABASE_PREFIX . $id);

        $this->stream->endElement();
    }

    private function writeAnalysisProtocolCollection()
    {
        $this->stream->startElement('AnalysisProtocolCollection');

        $this->writeSpectrumIdentificationProtocol();

        $this->stream->endElement();
    }

    private function writeSpectrumIdentificationProtocol()
    {
        $this->stream->startElement('SpectrumIdentificationProtocol');

        $this->stream->writeAttribute('analysisSoftware_ref', $this->softwareList[0]['id']);
        $this->stream->writeAttribute('id', self::SPECTRUM_IDENTIFICATION_PROTOCOL_PREFIX . '1');

        $this->writeSearchType();

        $this->writeModificationParams();

        $this->writeEnzymes();

        $this->writeFragmentTolerance();

        $this->writeParentTolerance();

        $this->writeThreshold();

        $this->stream->endElement();
    }

    private function writeFragmentTolerance()
    {
        $this->stream->startElement('FragmentTolerance');
        $this->writeTolerance($this->fragmentTolerance);
        $this->stream->endElement();
    }

    private function writeParentTolerance()
    {
        $this->stream->startElement('ParentTolerance');
        $this->writeTolerance($this->parentTolerance);
        $this->stream->endElement();
    }

    private function writeTolerance(array $tolerances)
    {
        $accession = 'MS:1001412';
        $value = $tolerances[0]->getTolerance();

        $unitAccession = 'UO:0000169';
        $unitName = 'parts per million';
        if ($tolerances[0]->getUnit() == Tolerance::DA) {
            $unitAccession = 'UO:0000221';
            $unitName = 'dalton';
        }

        $this->writeCvParam($accession, $this->psiMsRef, $value, $unitAccession, $this->uoRef, $unitName);

        $accession = 'MS:1001413';
        if (count($tolerances) == 2) {
            $value = $tolerances[1]->getTolerance();

            $unitAccession = 'UO:0000169';
            $unitName = 'parts per million';
            if ($tolerances[1]->getUnit() == Tolerance::DA) {
                $unitAccession = 'UO:0000221';
                $unitName = 'dalton';
            }
        }

        $this->writeCvParam($accession, $this->psiMsRef, $value, $unitAccession, $this->uoRef, $unitName);
    }

    private function writeThreshold()
    {
        $this->stream->startElement('Threshold');

        $this->writeCvParam('MS:1001494', $this->psiMsRef);

        $this->stream->endElement();
    }

    private function writeEnzymes()
    {
        $this->stream->startElement('Enzymes');

        foreach (array_keys($this->enzymes) as $id) {
            $this->writeEnzyme($id);
        }

        $this->stream->endElement();
    }

    private function writeEnzyme($id)
    {
        $this->stream->startElement('Enzyme');

        $this->stream->writeAttribute('id', $id);
        $this->stream->writeAttribute('missedCleavages', $this->enzymes[$id]['missedCleavages']);

        $this->writeEnzymeName($this->enzymes[$id]['accession'], $this->enzymes[$id]['cvRef']);

        $this->stream->endElement();
    }

    private function writeEnzymeName($accession, $cvRef)
    {
        $this->stream->startElement('EnzymeName');

        $this->writeCvParam($accession, $cvRef);

        $this->stream->endElement();
    }

    private function writeSearchType()
    {
        $this->stream->startElement('SearchType');

        // TODO: Other types supported?
        $this->writeCvParam('MS:1001083', $this->psiMsRef);

        $this->stream->endElement();
    }

    private function writeModificationParams()
    {
        $this->stream->startElement('ModificationParams');

        foreach ($this->modifications as $modification) {
            $this->writeSearchModification($modification);
        }

        $this->stream->endElement();
    }

    private function writeSearchModification(Modification $modification)
    {
        $this->stream->startElement('SearchModification');

        $this->stream->writeAttribute('fixedMod', $modification->isFixed() ? 'true' : 'false');
        $this->stream->writeAttribute('massDelta', $modification->getMonoisotopicMass());

        $residues = implode(' ', $modification->getResidues());
        if (strlen($residues) == 0) {
            $residues = '.';
        }

        $this->stream->writeAttribute('residues', $residues);

        $this->writeSpecificityRules($modification);

        // TODO: Do not hardcode to unimod
        $this->writeCvParam($modification->getAccession(), 'UNIMOD');

        $this->stream->endElement();
    }

    private function writeSpecificityRules(Modification $modification)
    {
        if ($modification->getPosition() == Modification::POSITION_ANY) {
            return;
        }

        $this->stream->startElement('SpecificityRules');

        switch ($modification->getPosition()) {
            case Modification::POSITION_NTERM:
                $this->writeCvParam('MS:1001189', $this->psiMsRef);
                break;
            case Modification::POSITION_CTERM:
                $this->writeCvParam('MS:1001190', $this->psiMsRef);
                break;
            case Modification::POSITION_PROTEIN_NTERM:
                $this->writeCvParam('MS:1002057', $this->psiMsRef);
                break;
            case Modification::POSITION_PROTEIN_CTERM:
                $this->writeCvParam('MS:1002058', $this->psiMsRef);
                break;
            default:
                // TODO: Correctly handle MS:1001875 / MS:1001876
                break;
        }

        $this->stream->endElement();
    }

    private function writeCvParam($accession, $cvRef, $value = null, $unitAccession = null, $unitCvRef = null, $unitName = null)
    {
        $this->stream->startElement('cvParam');

        $this->stream->writeAttribute('accession', $accession);
        $this->stream->writeAttribute('cvRef', $cvRef);
        $this->stream->writeAttribute('name', $this->getOboName($cvRef, $accession));

        if (! is_null($value)) {
            $this->stream->writeAttribute('value', $value);
        }

        if (! is_null($unitAccession)) {
            $this->stream->writeAttribute('unitAccession', $unitAccession);
            $this->stream->writeAttribute('unitCvRef', $unitCvRef);
            $this->stream->writeAttribute('unitName', $unitName);
        }

        $this->stream->endElement();
    }

    private function writeUserParam($name, $type = null, $unitAccession = null, $unitCvRef = null, $unitName = null, $value = null)
    {
        $this->stream->startElement('userParam');

        $this->stream->writeAttribute('name', $name);

        if (! is_null($value)) {
            $this->stream->writeAttribute('type', $type);
        }

        if (! is_null($value)) {
            $this->stream->writeAttribute('value', $value);
        }

        if (! is_null($unitAccession)) {
            $this->stream->writeAttribute('unitAccession', $unitAccession);
        }

        if (! is_null($unitCvRef)) {
            $this->stream->writeAttribute('unitCvRef', $unitCvRef);
        }

        if (! is_null($unitName)) {
            $this->stream->writeAttribute('unitName', $unitName);
        }

        $this->stream->endElement();
    }

    private function writeAnalysisSoftware(array $software)
    {
        $this->stream->startElement('AnalysisSoftware');
        $this->stream->writeAttribute('id', $software['id']);
        $this->stream->writeAttribute('version', $software['version']);
        $this->stream->writeAttribute('name', $software['name']);

        $this->writeSoftwareName($software);

        $this->stream->endElement();
    }

    private function writeSoftwareName(array $software)
    {
        $this->stream->startElement('SoftwareName');

        $this->writeUserParam($software['name']);

        $this->stream->endElement();
    }

    /**
     *
     * @param PrecursorIon[] $precursors
     */
    private function writeSequenceCollection(array $precursors)
    {
        $this->stream->startElement('SequenceCollection');

        $objectsWritten = array();
        foreach ($precursors as $precursor) {
            foreach ($precursor->getIdentifications() as $ident) {
                $peptide = $ident->getSequence();
                $proteins = $peptide->getProteins();

                foreach ($proteins as $proteinEntry) {
                    if (isset($objectsWritten[$proteinEntry->getProtein()->getIdentifier()])) {
                        continue;
                    }

                    // TODO: Needs to use correct ID
                    $dbId = 0;
                    if ($peptide->isDecoy()) {
                        $dbId = 1;
                    }
                    $this->writeDbSequence($dbId, $proteinEntry->getProtein());

                    $objectsWritten[$proteinEntry->getProtein()->getIdentifier()] = true;
                }
            }
        }

        $this->flush();

        $objectsWritten = array();
        foreach ($precursors as $precursor) {
            foreach ($precursor->getIdentifications() as $ident) {
                $peptide = $ident->getSequence();

                if (isset($objectsWritten[$this->getId($peptide)])) {
                    continue;
                }

                $this->writePeptide($peptide);

                $objectsWritten[$this->getId($peptide)] = true;
            }
        }
        $this->flush();

        $objectsWritten = array();
        foreach ($precursors as $precursor) {
            foreach ($precursor->getIdentifications() as $ident) {
                $peptide = $ident->getSequence();
                $proteins = $ident->getSequence()->getProteins();

                foreach ($proteins as $proteinEntry) {
                    $protein = $proteinEntry->getProtein();

                    $id = $this->getId($peptide) . '_' . $protein->getIdentifier();
                    if (isset($objectsWritten[$id])) {
                        continue;
                    }

                    $this->writePeptideEvidence($peptide, $proteinEntry);

                    $objectsWritten[$id] = true;
                }
            }
        }

        $this->stream->endElement();
    }

    private function writeDbSequence($databaseId, Protein $protein)
    {
        $this->stream->startElement('DBSequence');

        $this->stream->writeAttribute('accession', $protein->getIdentifier());
        $this->stream->writeAttribute('id', $protein->getIdentifier());

        $dbRef = self::SEARCH_DATABASE_PREFIX . $databaseId;
        $this->stream->writeAttribute('searchDatabase_ref', $dbRef);

        $this->writeSeq($protein->getSequence());

        $this->writeCvParam('MS:1001088', $this->psiMsRef, $protein->getDescription());
        $this->stream->endElement();
    }

    private function writeSeq($sequence)
    {
        $this->stream->writeElement('Seq', $sequence);
    }

    private function getId(Peptide $peptide)
    {
        $id = $peptide->getSequence() . '_';

        $modPos = array();
        foreach ($peptide->getModifications() as $modification) {
            $modPos[] = $modification->getLocation();
        }

        for ($i = 1; $i <= strlen($peptide->getSequence()); $i ++) {
            $bool = array_search($i, $modPos);

            $id .= $bool !== false ? '1' : '0';
        }

        return $id;
    }

    private function writePeptide(Peptide $peptide)
    {
        $this->stream->startElement('Peptide');

        $this->stream->writeAttribute('id', $this->getId($peptide));

        $this->writePeptideSequence($peptide->getSequence());

        foreach ($peptide->getModifications() as $modification) {
            $this->writeModification($modification);
        }

        $this->stream->endElement();
    }

    private function writePeptideSequence($sequence)
    {
        $this->stream->writeElement('PeptideSequence', $sequence);
    }

    private function writeModification(Modification $modification)
    {
        $this->stream->startElement('Modification');

        $this->stream->writeAttribute('location', $modification->getLocation());
        $this->stream->writeAttribute('monoisotopicMassDelta', $modification->getMonoisotopicMass());

        // TODO: support non-UNIMOD
        $this->writeCvParam($modification->getAccession(), 'UNIMOD');

        $this->stream->endElement();
    }

    private function writePeptideEvidence(Peptide $peptide, ProteinEntry $proteinEntry)
    {
        $protein = $proteinEntry->getProtein();
        $this->stream->startElement('PeptideEvidence');

        $this->stream->writeAttribute('id', $this->getId($peptide) . '_' . $protein->getIdentifier());
        $this->stream->writeAttribute('dBSequence_ref', $protein->getIdentifier());
        $this->stream->writeAttribute('peptide_ref', $this->getId($peptide));

        $this->writeAttributeNotNull('start', $proteinEntry->getStart());
        $this->writeAttributeNotNull('end', $proteinEntry->getEnd());

        if ($peptide->isDecoy()) {
            $this->stream->writeAttribute('isDecoy', 'true');
        }

        $this->stream->endElement();
    }

    private function getOboName($ref, $id)
    {
        return $this->oboRef[$ref][$id];
    }

    /**
     * Writes the attribute for as long as the value is not null
     *
     * @param string $attribute
     * @param mixed $value
     */
    private function writeAttributeNotNull($attribute, $value)
    {
        if (is_null($value)) {
            return;
        }

        $this->stream->writeAttribute($attribute, $value);
    }
}
