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
namespace pgb_liv\php_ms\Search;

/**
 * Encapsulation class for Mascot search parameters
 *
 * @author Andrew Collins
 */
class MascotSearchParams
{

    const UNIT_PPM = 'ppm';

    const MASS_MONO = 'Monoisotopic';

    const MASS_AVG = 'Average';

    private $formVersion = '1.01';

    private $intermediate = '';

    private $searchType = 'MIS';

    private $peak = 'AUTO';

    private $repType = 'peptide';

    private $errTolRepeat = 0;

    private $isShowAllModsEnabled = '';

    private $userName;

    private $userMail;

    private $searchTitle;

    private $databases;

    private $enzyme = 'Trypsin';

    private $missedCleavageCount = 1;

    private $quantitation = 'None';

    private $taxonomy = 'All Entries';

    private $fixedModificiations;

    private $variableModifications;

    private $precursorTolerance = 1.2;

    private $precursorToleranceUnit = 'Da';

    private $peptideIsotopeError = 0;

    private $fragmentTolerance = 0.6;

    private $fragmentToleranceUnit = 'Da';

    private $charge = '2+';

    private $mass = 'Monoisotopic';

    private $file;

    private $fileFormat = 'Mascot generic';

    private $precursor;

    private $instrument = 'Default';

    private $report = 'Auto';

    private $isDecoyEnabled = 0;

    public function setIntermediate($intermediate)
    {
        $this->intermediate = $intermediate;
    }

    public function getIntermediate()
    {
        return $this->intermediate;
    }

    public function setFormVersion($formVersion)
    {
        $this->formVersion = $formVersion;
    }

    public function getFormVersion()
    {
        return $this->formVersion;
    }

    public function setSearchType($searchType)
    {
        switch ($searchType) {
            case 'MIS':
            case 'SQ':
            case 'PMF':
                $this->searchType = $searchType;
                return;
            default:
                throw new \InvalidArgumentException('Unknown search type: ' . $searchType);
        }
    }

    public function getSearchType()
    {
        return $this->searchType;
    }

    public function setRepType($repType)
    {
        $this->repType = $repType;
    }

    public function getRepType()
    {
        return $this->repType;
    }

    public function setErrorTolerantRepeat($repeat)
    {
        $this->errTolRepeat = $repeat;
    }

    public function getErrorTolerantRepeat()
    {
        return $this->errTolRepeat;
    }

    public function setPeak($peak)
    {
        $this->peak = $peak;
    }

    public function getPeak()
    {
        return $this->peak;
    }

    public function setShowAllModsEnabled($bool)
    {
        return $this->isShowAllModsEnabled = $bool;
    }

    public function isShowAllModsEnabled()
    {
        return $this->isShowAllModsEnabled;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserMail($mail)
    {
        $this->userMail = $mail;
    }

    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * A text string which will be printed at the top of results report pages.
     * Can be left blank.
     *
     * @param string $title
     *            Text string for title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * A text string which will be printed at the top of results report pages.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setDatabases($databases)
    {
        $this->databases = $databases;
    }

    /**
     * The sequence database(s) to be searched.
     *
     * @return string
     */
    public function getDatabases()
    {
        return $this->databases;
    }

    public function setEnzyme($enzyme)
    {
        // TOOD: Validate known enzyme
        $this->enzyme = $enzyme;
    }

    public function getEnzyme()
    {
        return $this->enzyme;
    }

    public function setMissedCleavageCount($maxCleave)
    {
        // TODO: Validate int
        // TODO: Validate >= 0 && <= 9
        $this->missedCleavageCount = $maxCleave;
    }

    public function getMissedCleavageCount()
    {
        return $this->missedCleavageCount;
    }

    public function setQuantitation($quantitationMethod)
    {
        // TODO: Validate known quantitation method
        $this->quantitation = $quantitationMethod;
    }

    public function getQuantitation()
    {
        return $this->quantitation;
    }

    public function setTaxonomy($taxonomy)
    {
        // TODO: Validate taxonomy
        $this->taxonomy = $taxonomy;
    }

    public function getTaxonomy()
    {
        return $this->taxonomy;
    }

    public function setFixedModifications($fixedModifications)
    {
        // TODO: Validate mods
        $this->fixedModificiations = $fixedModifications;
    }

    public function getFixedModifications()
    {
        return $this->fixedModificiations;
    }

    public function setVariableModifications($variableModifications)
    {
        // TODO: Validate mods
        $this->variableModifications = $variableModifications;
    }

    public function getVariableModifications()
    {
        return $this->variableModifications;
    }

    public function setPrecursorTolerance($precursorTolerance)
    {
        // TODO: Validate float
        $this->precursorTolerance = $precursorTolerance;
    }

    public function getPrecursorTolerance()
    {
        return $this->precursorTolerance;
    }

    public function setPrecursorToleranceUnit($unit)
    {
        // Validate unit
        $this->precursorToleranceUnit = $unit;
    }

    public function getPrecursorToleranceUnit()
    {
        return $this->precursorToleranceUnit;
    }

    public function setPeptideIsotopeError($peptideIsotopeError)
    {
        // TODO: Validate int
        // TODO: Validate >= 0 && <= 2
        $this->peptideIsotopeError = $peptideIsotopeError;
    }

    public function getPeptideIsotopeError()
    {
        return $this->peptideIsotopeError;
    }

    public function setFragmentTolerance($fragmentTolerance)
    {
        // TODO: Validate float
        $this->fragmentTolerance = $fragmentTolerance;
    }

    public function getFragmentTolerance()
    {
        return $this->fragmentTolerance;
    }

    public function setFragmentToleranceUnit($fragmentToleranceUnit)
    {
        // TODO: Validate unit
        $this->fragmentToleranceUnit = $fragmentToleranceUnit;
    }

    public function getFragmentToleranceUnit()
    {
        return $this->fragmentToleranceUnit;
    }

    public function setCharge($charge)
    {
        // TODO: Validate charge
        $this->charge = $charge;
    }

    public function getCharge()
    {
        return $this->charge;
    }

    public function setFilePath($filePath)
    {
        // TODO: Validate file exists
        $this->file = $filePath;
    }

    public function getFilePath()
    {
        return $this->file;
    }

    public function setFileFormat($fileFormat)
    {
        // Validate valid file format
        $this->fileFormat = $fileFormat;
    }

    public function getFileFormat()
    {
        return $this->fileFormat;
    }

    /**
     * Certain data file formats, SCIEX API III, PerSeptive (.PKS), and Bruker (.XML), do not include m/z information for the precursor peptide.
     * For these formats only, the Precursor field is used to specify the m/z value of the parent peptide. The charge state is defined by the setting of the
     * Peptide Charge field.
     *
     * @param float $precursorMass
     *            Precursor mass value
     */
    public function setPrecursor($precursorMass)
    {
        // TODO: Validate float
        $this->precursor = $precursorMass;
    }

    public function getPrecursor()
    {
        return $this->precursor;
    }

    public function setInstrument($instrument)
    {
        // TODO: Validate instrument
        $this->instrument = $instrument;
    }

    public function getInstrument()
    {
        return $this->instrument;
    }

    public function setDecoyEnabled($bool)
    {
        // TODO: validate boolean
        $this->isDecoyEnabled = $bool;
    }

    public function isDecoyEnabled()
    {
        return $this->isDecoyEnabled ? 1 : 0;
    }

    public function setReport($top)
    {
        // TODO: Validiate Report top limit
        $this->report = $top;
    }

    public function getReport()
    {
        return $this->report;
    }

    public function setMassType($massType)
    {
        switch ($massType) {
            case MascotSearchParams::MASS_MONO:
            case MascotSearchParams::MASS_AVG:
                $this->mass = $massType;
                return;
            default:
                throw new \InvalidArgumentException('Mass type must be either monoistopic or average');
        }
    }

    public function getMassType()
    {
        return $this->mass;
    }
}
