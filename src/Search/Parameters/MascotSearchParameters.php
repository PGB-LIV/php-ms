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
namespace pgb_liv\php_ms\Search\Parameters;

use pgb_liv\php_ms\Core\Tolerance;

/**
 * Encapsulation class for Mascot search parameters
 *
 * @author Andrew Collins
 */
class MascotSearchParameters extends AbstractSearchParameters implements SearchParametersInterface
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

    private $title;

    private $quantitation = 'None';

    private $taxonomy = 'All Entries';

    private $peptideIsotopeError = 0;

    private $charge = '2+';

    private $mass = 'Monoisotopic';

    private $fileFormat = 'Mascot generic';

    private $precursor;

    private $instrument = 'Default';

    private $report = 'Auto';

    public function __construct()
    {
        // Set defaults
        $this->setEnzyme('Trypsin');
        $this->setMissedCleavageCount(1);
        $this->setPrecursorTolerance(new Tolerance(1.2, Tolerance::DA));
        $this->setFragmentTolerance(new Tolerance(0.6, Tolerance::DA));
        $this->setDecoyEnabled(true);
    }

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

    public function setQuantitation($quantitationMethod)
    {
        // TODO: Validate quantitation
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

    public function setPeptideIsotopeError($peptideIsotopeError)
    {
        if (! is_int($peptideIsotopeError) || $peptideIsotopeError < 0 || $peptideIsotopeError > 2) {
            throw new \InvalidArgumentException('Argument 1 must be an integer value between 0 and 2');
        }
        
        $this->peptideIsotopeError = $peptideIsotopeError;
    }

    public function getPeptideIsotopeError()
    {
        return $this->peptideIsotopeError;
    }

    public function setCharge($charge)
    {
        $this->charge = $charge;
    }

    public function getCharge()
    {
        return $this->charge;
    }

    public function setFileFormat($fileFormat)
    {
        switch ($fileFormat) {            
            case 'Mascot generic':
            case 'Sequest (.DTA)':
            case 'Finnigan (.ASC)':
            case 'Micromass (.PKL)':
            case 'PerSeptive (.PKS)':
            case 'Sciex API III':
            case 'Bruker (.XML)':
            case 'mzData (.XML)':
            case 'mzML (.mzML)':
                $this->fileFormat = $fileFormat;
                break;
            default:
                throw new \InvalidArgumentException('Argument 1 must specify a known file format');
        }
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
        if ((! is_float($precursorMass) && ! is_int($precursorMass)) || $precursorMass < 0) {
            throw new \InvalidArgumentException('Argument 1 must be a float or integer value greater than 0');
        }
        
        $this->precursor = $precursorMass;
    }

    public function getPrecursor()
    {
        return $this->precursor;
    }

    public function setInstrument($instrument)
    {
        switch ($instrument) {
            case 'Default':
            case 'ESI-QUAD-TOF':
            case 'MALDI-TOF-PSD':
            case 'ESI-TRAP':
            case 'ESI-QUAD':
            case 'ESI-FTICR':
            case 'MALDI-TOF-TOF':
            case 'ESI-4SECTOR':
            case 'FTMS-ECD':
            case 'ETD-TRAP':
            case 'MALDI-QUAD-TOF':
            case 'MALDI-QIT-TOF':
            case 'MALDI-ISD':
            case 'CID+ETD':
                $this->instrument = $instrument;
                break;
            default:
                throw new \InvalidArgumentException('Argument 1 must specify a known instrument type');
        }
    }

    public function getInstrument()
    {
        return $this->instrument;
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
            case MascotSearchParameters::MASS_MONO:
            case MascotSearchParameters::MASS_AVG:
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
    
    public function setMissedCleavageCount($maxCleave)
    {
        if (! is_int($maxCleave) || $maxCleave < 0 || $maxCleave > 9) {
            throw new \InvalidArgumentException('Argument 1 must be an unsigned integer between 0 and 9');
        }
        
        parent::setMissedCleavageCount($maxCleave);
    }
}
