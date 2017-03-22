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

    const ENZYME_TRYPSIN = 'Trypsin';

    const ENZYME_TRYPSIN_P = 'Trypsin/P';

    const ENZYME_ARG_C = 'Arg-C';

    const ENZYME_ASP_N = 'Asp-N';

    const ENZYME_ASP_N_AMBIC = 'Asp-N_ambic';

    const ENZYME_CHYMOTRYPSIN = 'Chymotrypsin';

    const ENZYME_CNBR = 'CNBr';

    const ENZYME_CNBR_TRYPSIN = 'CNBr+Trypsin';

    const ENZYME_FORMIC_ACID = 'Formic_acid';

    const ENZYME_LYS_C = 'Lys-C';

    const ENZYME_LYS_C_P = 'Lys-C/P';

    const ENZYME_LYSC_ASPN = 'LysC+AspN';

    const ENZYME_LYS_N = 'Lys-N';

    const ENZYME_PEPSINA = 'PepsinA';

    const ENZYME_SEMITRYPSIN = 'semiTrypsin';

    const ENZYME_TRYPCHYMO = 'TrypChymo';

    const ENZYME_TRYPSINMSIPI = 'TrypsinMSIPI';

    const ENZYME_TRYPSINMSIPI_P = 'TrypsinMSIPI/P';

    const ENZYME_V8_DE = 'V8-DE';

    const ENZYME_V8_E = 'V8-E';

    const ENZYME_NONE = 'None';

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
        switch ($enzyme) {
            case MascotSearchParams::ENZYME_TRYPSIN:
            case MascotSearchParams::ENZYME_TRYPSIN_P:
            case MascotSearchParams::ENZYME_ARG_C:
            case MascotSearchParams::ENZYME_ASP_N:
            case MascotSearchParams::ENZYME_ASP_N_AMBIC:
            case MascotSearchParams::ENZYME_CHYMOTRYPSIN:
            case MascotSearchParams::ENZYME_CNBR:
            case MascotSearchParams::ENZYME_CNBR_TRYPSIN:
            case MascotSearchParams::ENZYME_FORMIC_ACID:
            case MascotSearchParams::ENZYME_LYS_C:
            case MascotSearchParams::ENZYME_LYS_C_P:
            case MascotSearchParams::ENZYME_LYSC + ASPN:
            case MascotSearchParams::ENZYME_LYS_N:
            case MascotSearchParams::ENZYME_PEPSINA:
            case MascotSearchParams::ENZYME_SEMITRYPSIN:
            case MascotSearchParams::ENZYME_TRYPCHYMO:
            case MascotSearchParams::ENZYME_TRYPSINMSIPI:
            case MascotSearchParams::ENZYME_TRYPSINMSIPI_P:
            case MascotSearchParams::ENZYME_V8_DE:
            case MascotSearchParams::ENZYME_V8_E:
            case MascotSearchParams::ENZYME_NONE:
                $this->enzyme = $enzyme;
                
                break;
            
            default:
                throw new \InvalidArgumentException('Argument 1 must use a known enzyme');
        }
    }

    public function getEnzyme()
    {
        return $this->enzyme;
    }

    public function setMissedCleavageCount($maxCleave)
    {
        if (! is_int($maxCleave) || $maxCleave < 0 || $maxCleave > 9) {
            throw new \InvalidArgumentException('Argument 1 must be an integer value between 0 and 9');
        }
        
        $this->missedCleavageCount = $maxCleave;
    }

    public function getMissedCleavageCount()
    {
        return $this->missedCleavageCount;
    }

    public function setQuantitation($quantitationMethod)
    {
        switch ($quantitationMethod) {
            case 'None':
            case 'iTRAQ 4plex':
            case 'iTRAQ 8plex':
            case 'TMT 6plex':
            case 'TMT 2plex':
            case '18O multiplex':
            case 'SILAC K+6 R+6 multiplex':
            case 'IPTL (Succinyl and IMID) multiplex':
            case 'ICPL duplex pre-digest [MD]':
            case 'ICPL duplex post-digest [MD]':
            case 'ICPL triplex pre-digest [MD]':
            case '18O corrected [MD]':
            case '15N Metabolic [MD]':
            case '15N + 13C Metabolic [MD]':
            case 'SILAC K+6 R+10 [MD]':
            case 'SILAC K+6 R+10 Arg-Pro [MD]':
            case 'SILAC K+6 R+6 [MD]':
            case 'SILAC R+6 R+10 [MD]':
            case 'SILAC K+8 R+10 [MD]':
            case 'SILAC K+4 K+8 R+6 R+10 [MD]':
            case 'ICAT ABI Cleavable [MD]':
            case 'ICAT D8 [MD]':
            case 'Dimethylation [MD]':
            case 'NBS Shimadzu [MD]':
            case 'Label-free [MD]':
            case 'Average [MD]':
                $this->quantitation = $quantitationMethod;
                break;
            default:
                throw new \InvalidArgumentException('Argument 1 must use a known quantitation method');
        }
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
        if ((! is_float($precursorTolerance) && ! is_int($precursorTolerance)) || $precursorTolerance < 0) {
            throw new \InvalidArgumentException('Argument 1 must be a float or integer value greater than 0');
        }
        
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
        if (! is_int($peptideIsotopeError) || $peptideIsotopeError < 0 || $peptideIsotopeError > 2) {
            throw new \InvalidArgumentException('Argument 1 must be an integer value between 0 and 2');
        }
        
        $this->peptideIsotopeError = $peptideIsotopeError;
    }

    public function getPeptideIsotopeError()
    {
        return $this->peptideIsotopeError;
    }

    public function setFragmentTolerance($fragmentTolerance)
    {
        if ((! is_float($fragmentTolerance) && ! is_int($fragmentTolerance)) || $fragmentTolerance < 0) {
            throw new \InvalidArgumentException('Argument 1 must be a float or integer value greater than 0');
        }
        
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
        switch ($charge) {
            case '8-':
            case '7-':
            case '6-':
            case '5-':
            case '4-':
            case '3-':
            case '2-, 3- and 4-':
            case '2- and 3-':
            case '2-':
            case '1-, 2- and 3-':
            case '1-':
            case 'Mr':
            case '1+':
            case '1+, 2+ and 3+':
            case '2+':
            case '2+ and 3+':
            case '2+, 3+ and 4+':
            case '3+':
            case '4+':
            case '5+':
            case '6+':
            case '7+':
            case '8+':
                $this->charge = $charge;
                break;
            default:
                throw new \InvalidArgumentException('Argument 1 must use a known charge option');
        }
    }

    public function getCharge()
    {
        return $this->charge;
    }

    public function setFilePath($filePath)
    {
        if (! file_exists($filePath)) {
            throw new \InvalidArgumentException('Argument 1 must specify a valid file');
        }
        
        $this->file = $filePath;
    }

    public function getFilePath()
    {
        return $this->file;
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

    public function setDecoyEnabled($bool)
    {
        if (! is_bool($bool)) {
            throw new \InvalidArgumentException('Argument 1 must be a boolean value');
        }
        
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

    public function isValidModification($modification)
    {
        switch ($modification) {
            case '15dB-biotin (C)':
            case '2-succinyl (C)':
            case '2HPG (R)':
            case '3-deoxyglucosone (R)':
            case '3sulfo (N-term)':
            case '4-ONE (C)':
            case '4-ONE (H)':
            case '4-ONE (K)':
            case '4-ONE+Delta:H(-2)O(-1) (C)':
            case '4-ONE+Delta:H(-2)O(-1) (H)':
            case '4-ONE+Delta:H(-2)O(-1) (K)':
            case '4AcAllylGal (C)':
            case 'a-type-ion (C-term)':
            case 'AccQTag (K)':
            case 'AccQTag (N-term)':
            case 'Acetyl (C)':
            case 'Acetyl (H)':
            case 'Acetyl (K)':
            case 'Acetyl (N-term)':
            case 'Acetyl (Protein N-term)':
            case 'Acetyl (S)':
            case 'Acetyl (T)':
            case 'Acetyl (Y)':
            case 'Acetyl:2H(3) (K)':
            case 'Acetyl:2H(3) (N-term)':
            case 'ADP-Ribosyl (C)':
            case 'ADP-Ribosyl (E)':
            case 'ADP-Ribosyl (N)':
            case 'ADP-Ribosyl (R)':
            case 'ADP-Ribosyl (S)':
            case 'AEBS (H)':
            case 'AEBS (K)':
            case 'AEBS (Protein N-term)':
            case 'AEBS (S)':
            case 'AEBS (Y)':
            case 'AEC-MAEC (S)':
            case 'AEC-MAEC (T)':
            case 'AEC-MAEC:2H(4) (S)':
            case 'AEC-MAEC:2H(4) (T)':
            case 'Amidated (C-term)':
            case 'Amidated (Protein C-term)':
            case 'Amidine (K)':
            case 'Amidine (N-term)':
            case 'Amidino (C)':
            case 'Amino (Y)':
            case 'Ammonia-loss (N)':
            case 'Ammonia-loss (N-term C)':
            case 'Ammonia-loss (Protein N-term S)':
            case 'Ammonia-loss (Protein N-term T)':
            case 'Archaeol (C)':
            case 'Arg-&gt;GluSA (R)':
            case 'Arg-&gt;Npo (R)':
            case 'Arg-&gt;Orn (R)':
            case 'Arg2PG (R)':
            case 'Argbiotinhydrazide (R)':
            case 'AROD (C)':
            case 'Atto495Maleimide (C)':
            case 'Bacillosamine (N)':
            case 'BADGE (C)':
            case 'BDMAPP (H)':
            case 'BDMAPP (K)':
            case 'BDMAPP (Protein N-term)':
            case 'BDMAPP (W)':
            case 'BDMAPP (Y)':
            case 'Benzoyl (K)':
            case 'Benzoyl (N-term)':
            case 'BHT (C)':
            case 'BHT (H)':
            case 'BHT (K)':
            case 'BHTOH (C)':
            case 'BHTOH (H)':
            case 'BHTOH (K)':
            case 'Biotin (K)':
            case 'Biotin (N-term)':
            case 'Biotin-HPDP (C)':
            case 'Biotin-PEG-PRA (M)':
            case 'Biotin-PEO-Amine (D)':
            case 'Biotin-PEO-Amine (E)':
            case 'Biotin-PEO-Amine (Protein C-term)':
            case 'Biotin-PEO4-hydrazide (C-term)':
            case 'Biotin-phenacyl (C)':
            case 'Biotin-phenacyl (H)':
            case 'Biotin-phenacyl (S)':
            case 'BisANS (K)':
            case 'BMOE (C)':
            case 'Bodipy (C)':
            case 'Bromo (F)':
            case 'Bromo (H)':
            case 'Bromo (W)':
            case 'Bromobimane (C)':
            case 'C8-QAT (K)':
            case 'C8-QAT (N-term)':
            case 'CAF (N-term)':
            case 'CAMthiopropanoyl (K)':
            case 'CAMthiopropanoyl (Protein N-term)':
            case 'Can-FP-biotin (S)':
            case 'Can-FP-biotin (T)':
            case 'Can-FP-biotin (Y)':
            case 'Carbamidomethyl (C)':
            case 'Carbamidomethyl (D)':
            case 'Carbamidomethyl (E)':
            case 'Carbamidomethyl (H)':
            case 'Carbamidomethyl (K)':
            case 'Carbamidomethyl (N-term)':
            case 'CarbamidomethylDTT (C)':
            case 'Carbamyl (C)':
            case 'Carbamyl (K)':
            case 'Carbamyl (M)':
            case 'Carbamyl (N-term)':
            case 'Carbamyl (R)':
            case 'Carboxy (D)':
            case 'Carboxy (E)':
            case 'Carboxy (K)':
            case 'Carboxy (Protein N-term M)':
            case 'Carboxy (W)':
            case 'Carboxy-&gt;Thiocarboxy (Protein C-term G)':
            case 'Carboxyethyl (K)':
            case 'Carboxymethyl (C)':
            case 'Carboxymethyl (K)':
            case 'Carboxymethyl (N-term)':
            case 'Carboxymethyl (W)':
            case 'Carboxymethyl:13C(2) (C)':
            case 'CarboxymethylDTT (C)':
            case 'Cation:Ag (C-term)':
            case 'Cation:Ag (DE)':
            case 'Cation:Ca[II] (C-term)':
            case 'Cation:Ca[II] (DE)':
            case 'Cation:Cu[I] (C-term)':
            case 'Cation:Cu[I] (DE)':
            case 'Cation:Fe[II] (C-term)':
            case 'Cation:Fe[II] (DE)':
            case 'Cation:K (C-term)':
            case 'Cation:K (DE)':
            case 'Cation:Li (C-term)':
            case 'Cation:Li (DE)':
            case 'Cation:Mg[II] (C-term)':
            case 'Cation:Mg[II] (DE)':
            case 'Cation:Na (C-term)':
            case 'Cation:Na (DE)':
            case 'Cation:Ni[II] (C-term)':
            case 'Cation:Ni[II] (DE)':
            case 'Cation:Zn[II] (C-term)':
            case 'Cation:Zn[II] (DE)':
            case 'cGMP (C)':
            case 'cGMP (S)':
            case 'cGMP+RMP-loss (C)':
            case 'cGMP+RMP-loss (S)':
            case 'CHDH (D)':
            case 'Chlorination (Y)':
            case 'Cholesterol (Protein C-term)':
            case 'ChromoBiotin (K)':
            case 'CLIP_TRAQ_1 (K)':
            case 'CLIP_TRAQ_1 (N-term)':
            case 'CLIP_TRAQ_1 (Y)':
            case 'CLIP_TRAQ_2 (K)':
            case 'CLIP_TRAQ_2 (N-term)':
            case 'CLIP_TRAQ_2 (Y)':
            case 'CLIP_TRAQ_3 (K)':
            case 'CLIP_TRAQ_3 (N-term)':
            case 'CLIP_TRAQ_3 (Y)':
            case 'CLIP_TRAQ_4 (K)':
            case 'CLIP_TRAQ_4 (N-term)':
            case 'CLIP_TRAQ_4 (Y)':
            case 'CoenzymeA (C)':
            case 'Crotonaldehyde (C)':
            case 'Crotonaldehyde (H)':
            case 'Crotonaldehyde (K)':
            case 'CuSMo (C)':
            case 'Cy3b-maleimide (C)':
            case 'Cyano (C)':
            case 'CyDye-Cy3 (C)':
            case 'CyDye-Cy5 (C)':
            case 'Cys-&gt;Dha (C)':
            case 'Cys-&gt;ethylaminoAla (C)':
            case 'Cys-&gt;methylaminoAla (C)':
            case 'Cys-&gt;Oxoalanine (C)':
            case 'Cys-&gt;PyruvicAcid (Protein N-term C)':
            case 'Cysteinyl (C)':
            case 'Cytopiloyne (C)':
            case 'Cytopiloyne (K)':
            case 'Cytopiloyne (N-term)':
            case 'Cytopiloyne (P)':
            case 'Cytopiloyne (R)':
            case 'Cytopiloyne (S)':
            case 'Cytopiloyne (Y)':
            case 'Cytopiloyne+water (C)':
            case 'Cytopiloyne+water (K)':
            case 'Cytopiloyne+water (N-term)':
            case 'Cytopiloyne+water (R)':
            case 'Cytopiloyne+water (S)':
            case 'Cytopiloyne+water (T)':
            case 'Cytopiloyne+water (Y)':
            case 'DAET (S)':
            case 'DAET (T)':
            case 'Dansyl (K)':
            case 'Dansyl (N-term)':
            case 'Deamidated (NQ)':
            case 'Deamidated (Protein N-term F)':
            case 'Deamidated (R)':
            case 'Deamidated:18O(1) (NQ)':
            case 'Decanoyl (S)':
            case 'Decanoyl (T)':
            case 'Dehydrated (D)':
            case 'Dehydrated (N-term C)':
            case 'Dehydrated (Protein C-term N)':
            case 'Dehydrated (Protein C-term Q)':
            case 'Dehydrated (S)':
            case 'Dehydrated (T)':
            case 'Dehydrated (Y)':
            case 'Dehydro (C)':
            case 'Delta:H(1)O(-1)18O(1) (N)':
            case 'Delta:H(2)C(2) (H)':
            case 'Delta:H(2)C(2) (K)':
            case 'Delta:H(2)C(3) (K)':
            case 'Delta:H(2)C(3)O(1) (K)':
            case 'Delta:H(2)C(3)O(1) (R)':
            case 'Delta:H(2)C(5) (K)':
            case 'Delta:H(4)C(2) (H)':
            case 'Delta:H(4)C(2) (K)':
            case 'Delta:H(4)C(2)O(-1)S(1) (S)':
            case 'Delta:H(4)C(3) (H)':
            case 'Delta:H(4)C(3) (K)':
            case 'Delta:H(4)C(3)O(1) (C)':
            case 'Delta:H(4)C(3)O(1) (H)':
            case 'Delta:H(4)C(3)O(1) (K)':
            case 'Delta:H(4)C(6) (K)':
            case 'Delta:H(5)C(2) (P)':
            case 'Delta:H(6)C(6)O(1) (K)':
            case 'Delta:H(8)C(6)O(2) (K)':
            case 'Delta:Hg(1) (C)':
            case 'Delta:S(-1)Se(1) (C)':
            case 'Delta:S(-1)Se(1) (M)':
            case 'Delta:Se(1) (C)':
            case 'Deoxy (D)':
            case 'Deoxy (S)':
            case 'Deoxy (T)':
            case 'DeStreak (C)':
            case 'Dethiomethyl (M)':
            case 'DFDNB (K)':
            case 'DFDNB (N)':
            case 'DFDNB (Q)':
            case 'DFDNB (R)':
            case 'dHex (S)':
            case 'dHex (T)':
            case 'dHex(1)Hex(3)HexNAc(4) (N)':
            case 'dHex(1)Hex(4)HexNAc(4) (N)':
            case 'dHex(1)Hex(5)HexNAc(4) (N)':
            case 'DHP (C)':
            case 'Diacylglycerol (C)':
            case 'Dibromo (Y)':
            case 'dichlorination (Y)':
            case 'Didehydro (C-term K)':
            case 'Didehydro (S)':
            case 'Didehydro (T)':
            case 'Didehydro (Y)':
            case 'Didehydroretinylidene (K)':
            case 'Diethyl (K)':
            case 'Diethyl (N-term)':
            case 'Dihydroxyimidazolidine (R)':
            case 'Diiodo (Y)':
            case 'Diironsubcluster (C)':
            case 'Diisopropylphosphate (K)':
            case 'Diisopropylphosphate (S)':
            case 'Diisopropylphosphate (T)':
            case 'Diisopropylphosphate (Y)':
            case 'Dimethyl (K)':
            case 'Dimethyl (N)':
            case 'Dimethyl (N-term)':
            case 'Dimethyl (Protein N-term P)':
            case 'Dimethyl (R)':
            case 'Dimethyl:2H(4) (K)':
            case 'Dimethyl:2H(4) (N-term)':
            case 'Dimethyl:2H(4) (Protein N-term)':
            case 'Dimethyl:2H(4)13C(2) (K)':
            case 'Dimethyl:2H(4)13C(2) (N-term)':
            case 'Dimethyl:2H(6) (K)':
            case 'Dimethyl:2H(6) (N-term)':
            case 'Dimethyl:2H(6) (Protein N-term)':
            case 'Dimethyl:2H(6)13C(2) (K)':
            case 'Dimethyl:2H(6)13C(2) (N-term)':
            case 'Dimethyl:2H(6)13C(2) (R)':
            case 'DimethylamineGMBS (C)':
            case 'DimethylArsino (C)':
            case 'DimethylpyrroleAdduct (K)':
            case 'Dioxidation (C)':
            case 'Dioxidation (F)':
            case 'Dioxidation (K)':
            case 'Dioxidation (M)':
            case 'Dioxidation (P)':
            case 'Dioxidation (R)':
            case 'Dioxidation (W)':
            case 'Dioxidation (Y)':
            case 'Diphthamide (H)':
            case 'Dipyrrolylmethanemethyl (C)':
            case 'dNIC (N-term)':
            case 'DNPS (C)':
            case 'DNPS (W)':
            case 'DTBP (K)':
            case 'DTBP (N)':
            case 'DTBP (Protein N-term)':
            case 'DTBP (Q)':
            case 'DTBP (R)':
            case 'DTT_C (C)':
            case 'DTT_C:2H(6) (C)':
            case 'DTT_ST (S)':
            case 'DTT_ST (T)':
            case 'DTT_ST:2H(6) (S)':
            case 'DTT_ST:2H(6) (T)':
            case 'DyLight-maleimide (C)':
            case 'EDT-iodoacetyl-PEO-biotin (S)':
            case 'EDT-iodoacetyl-PEO-biotin (T)':
            case 'EDT-maleimide-PEO-biotin (S)':
            case 'EDT-maleimide-PEO-biotin (T)':
            case 'EQAT (C)':
            case 'EQAT:2H(5) (C)':
            case 'EQIGG (K)':
            case 'ESP (K)':
            case 'ESP (N-term)':
            case 'ESP:2H(10) (K)':
            case 'ESP:2H(10) (N-term)':
            case 'Ethanedithiol (S)':
            case 'Ethanedithiol (T)':
            case 'Ethanolamine (C-term)':
            case 'Ethanolamine (D)':
            case 'Ethanolamine (E)':
            case 'Ethanolyl (C)':
            case 'Ethoxyformyl (H)':
            case 'Ethyl (C-term)':
            case 'Ethyl (D)':
            case 'Ethyl (E)':
            case 'Ethyl (K)':
            case 'Ethyl (N-term)':
            case 'Ethyl (Protein N-term)':
            case 'EthylAmide (N)':
            case 'EthylAmide (Q)':
            case 'ethylamino (S)':
            case 'ethylamino (T)':
            case 'ExacTagAmine (K)':
            case 'ExacTagThiol (C)':
            case 'FAD (C)':
            case 'FAD (H)':
            case 'FAD (Y)':
            case 'Farnesyl (C)':
            case 'Fluorescein (C)':
            case 'Fluoro (F)':
            case 'Fluoro (W)':
            case 'Fluoro (Y)':
            case 'FMN (S)':
            case 'FMN (T)':
            case 'FMNC (C)':
            case 'FMNH (C)':
            case 'FMNH (H)':
            case 'FNEM (C)':
            case 'Formyl (K)':
            case 'Formyl (N-term)':
            case 'Formyl (Protein N-term)':
            case 'Formyl (S)':
            case 'Formyl (T)':
            case 'FormylMet (Protein N-term)':
            case 'FP-Biotin (K)':
            case 'FP-Biotin (S)':
            case 'FP-Biotin (T)':
            case 'FP-Biotin (Y)':
            case 'FTC (C)':
            case 'FTC (K)':
            case 'FTC (P)':
            case 'FTC (R)':
            case 'FTC (S)':
            case 'G-H1 (R)':
            case 'Galactosyl (K)':
            case 'GalNAzBiotin (N)':
            case 'GalNAzBiotin (S)':
            case 'GalNAzBiotin (T)':
            case 'GeranylGeranyl (C)':
            case 'GIST-Quat (K)':
            case 'GIST-Quat (N-term)':
            case 'GIST-Quat:2H(3) (K)':
            case 'GIST-Quat:2H(3) (N-term)':
            case 'GIST-Quat:2H(6) (K)':
            case 'GIST-Quat:2H(6) (N-term)':
            case 'GIST-Quat:2H(9) (K)':
            case 'GIST-Quat:2H(9) (N-term)':
            case 'Gln-&gt;pyro-Glu (N-term Q)':
            case 'Glu (E)':
            case 'Glu (Protein C-term)':
            case 'Glu-&gt;pyro-Glu (N-term E)':
            case 'Glucosylgalactosyl (K)':
            case 'Glucuronyl (Protein N-term)':
            case 'Glucuronyl (S)':
            case 'GluGlu (E)':
            case 'GluGlu (Protein C-term)':
            case 'GluGluGlu (E)':
            case 'GluGluGlu (Protein C-term)':
            case 'GluGluGluGlu (E)':
            case 'GluGluGluGlu (Protein C-term)':
            case 'Glutathione (C)':
            case 'Gly-loss+Amide (C-term G)':
            case 'Glycerophospho (S)':
            case 'GlycerylPE (E)':
            case 'Glycosyl (P)':
            case 'GlyGly (C)':
            case 'GlyGly (K)':
            case 'GlyGly (S)':
            case 'GlyGly (T)':
            case 'GPIanchor (Protein C-term)':
            case 'Guanidinyl (K)':
            case 'Heme (C)':
            case 'Heme (H)':
            case 'Hep (K)':
            case 'Hep (N)':
            case 'Hep (Q)':
            case 'Hep (R)':
            case 'Hep (S)':
            case 'Hep (T)':
            case 'Hex (C)':
            case 'Hex (K)':
            case 'Hex (N)':
            case 'Hex (N-term)':
            case 'Hex (R)':
            case 'Hex (T)':
            case 'Hex (W)':
            case 'Hex (Y)':
            case 'Hex(1)HexNAc(1)dHex(1) (N)':
            case 'Hex(1)HexNAc(1)NeuAc(1) (N)':
            case 'Hex(1)HexNAc(1)NeuAc(1) (S)':
            case 'Hex(1)HexNAc(1)NeuAc(1) (T)':
            case 'Hex(1)HexNAc(1)NeuAc(2) (N)':
            case 'Hex(1)HexNAc(1)NeuAc(2) (S)':
            case 'Hex(1)HexNAc(1)NeuAc(2) (T)':
            case 'Hex(1)HexNAc(2) (N)':
            case 'Hex(1)HexNAc(2)dHex(1) (N)':
            case 'Hex(1)HexNAc(2)dHex(1)Pent(1) (N)':
            case 'Hex(1)HexNAc(2)dHex(2) (N)':
            case 'Hex(1)HexNAc(2)Pent(1) (N)':
            case 'Hex(2) (K)':
            case 'Hex(2) (R)':
            case 'Hex(2)HexNAc(2) (N)':
            case 'Hex(2)HexNAc(2)dHex(1) (N)':
            case 'Hex(2)HexNAc(2)Pent(1) (N)':
            case 'Hex(3) (N)':
            case 'Hex(3)HexNAc(1)Pent(1) (N)':
            case 'Hex(3)HexNAc(2) (N)':
            case 'Hex(3)HexNAc(2)P(1) (N)':
            case 'Hex(3)HexNAc(4) (N)':
            case 'Hex(4)HexNAc(4) (N)':
            case 'Hex(5)HexNAc(2) (N)':
            case 'Hex(5)HexNAc(4) (N)':
            case 'Hex1HexNAc1 (S)':
            case 'Hex1HexNAc1 (T)':
            case 'HexN (K)':
            case 'HexN (N)':
            case 'HexN (T)':
            case 'HexN (W)':
            case 'HexNAc (N)':
            case 'HexNAc (S)':
            case 'HexNAc (T)':
            case 'HexNAc(1)dHex(1) (N)':
            case 'HexNAc(1)dHex(2) (N)':
            case 'HexNAc(2) (N)':
            case 'HexNAc(2)dHex(1) (N)':
            case 'HexNAc(2)dHex(2) (N)':
            case 'HMVK (C)':
            case 'HNE (CHK)':
            case 'HNE+Delta:H(2) (C)':
            case 'HNE+Delta:H(2) (H)':
            case 'HNE+Delta:H(2) (K)':
            case 'HNE-BAHAH (C)':
            case 'HNE-BAHAH (H)':
            case 'HNE-BAHAH (K)':
            case 'HNE-Delta:H(2)O (C)':
            case 'HNE-Delta:H(2)O (H)':
            case 'HNE-Delta:H(2)O (K)':
            case 'HPG (R)':
            case 'Hydroxycinnamyl (C)':
            case 'Hydroxyfarnesyl (C)':
            case 'Hydroxyheme (E)':
            case 'Hydroxymethyl (N)':
            case 'HydroxymethylOP (K)':
            case 'Hydroxytrimethyl (K)':
            case 'Hypusine (K)':
            case 'IBTP (C)':
            case 'ICAT-C (C)':
            case 'ICAT-C:13C(9) (C)':
            case 'ICAT-D (C)':
            case 'ICAT-D:2H(8) (C)':
            case 'ICAT-G (C)':
            case 'ICAT-G:2H(8) (C)':
            case 'ICAT-H (C)':
            case 'ICAT-H:13C(6) (C)':
            case 'ICPL (K)':
            case 'ICPL (N-term)':
            case 'ICPL (Protein N-term)':
            case 'ICPL:13C(6) (K)':
            case 'ICPL:13C(6) (N-term)':
            case 'ICPL:13C(6) (Protein N-term)':
            case 'ICPL:13C(6)2H(4) (K)':
            case 'ICPL:13C(6)2H(4) (N-term)':
            case 'ICPL:13C(6)2H(4) (Protein N-term)':
            case 'ICPL:2H(4) (K)':
            case 'ICPL:2H(4) (N-term)':
            case 'ICPL:2H(4) (Protein N-term)':
            case 'IDEnT (C)':
            case 'IED-Biotin (C)':
            case 'IGBP (C)':
            case 'IGBP:13C(2) (C)':
            case 'IMID (K)':
            case 'IMID:2H(4) (K)':
            case 'Iminobiotin (K)':
            case 'Iminobiotin (N-term)':
            case 'Iodo (H)':
            case 'Iodo (Y)':
            case 'IodoU-AMP (F)':
            case 'IodoU-AMP (W)':
            case 'IodoU-AMP (Y)':
            case 'Isopropylphospho (S)':
            case 'Isopropylphospho (T)':
            case 'Isopropylphospho (Y)':
            case 'iTRAQ4plex (K)':
            case 'iTRAQ4plex (N-term)':
            case 'iTRAQ4plex (Y)':
            case 'iTRAQ4plex114 (K)':
            case 'iTRAQ4plex114 (N-term)':
            case 'iTRAQ4plex114 (Y)':
            case 'iTRAQ4plex115 (K)':
            case 'iTRAQ4plex115 (N-term)':
            case 'iTRAQ4plex115 (Y)':
            case 'iTRAQ8plex (K)':
            case 'iTRAQ8plex (N-term)':
            case 'iTRAQ8plex (Y)':
            case 'iTRAQ8plex:13C(6)15N(2) (K)':
            case 'iTRAQ8plex:13C(6)15N(2) (N-term)':
            case 'iTRAQ8plex:13C(6)15N(2) (Y)':
            case 'Label:13C(1)2H(3) (M)':
            case 'Label:13C(1)2H(3)+Oxidation (M)':
            case 'Label:13C(4)15N(2)+GlyGly (K)':
            case 'Label:13C(5) (P)':
            case 'Label:13C(5)15N(1) (M)':
            case 'Label:13C(5)15N(1) (P)':
            case 'Label:13C(5)15N(1) (V)':
            case 'Label:13C(6) (I)':
            case 'Label:13C(6) (K)':
            case 'Label:13C(6) (L)':
            case 'Label:13C(6) (R)':
            case 'Label:13C(6)+Acetyl (K)':
            case 'Label:13C(6)+GlyGly (K)':
            case 'Label:13C(6)15N(1) (I)':
            case 'Label:13C(6)15N(1) (L)':
            case 'Label:13C(6)15N(2) (K)':
            case 'Label:13C(6)15N(2)+Acetyl (K)':
            case 'Label:13C(6)15N(2)+GlyGly (K)':
            case 'Label:13C(6)15N(4) (R)':
            case 'Label:13C(8)15N(2) (R)':
            case 'Label:13C(9) (F)':
            case 'Label:13C(9) (Y)':
            case 'Label:13C(9)+Phospho (Y)':
            case 'Label:13C(9)15N(1) (F)':
            case 'Label:15N(2)2H(9) (K)':
            case 'Label:15N(4) (R)':
            case 'Label:18O(1) (C-term)':
            case 'Label:18O(1) (S)':
            case 'Label:18O(1) (T)':
            case 'Label:18O(1) (Y)':
            case 'Label:18O(2) (C-term)':
            case 'Label:2H(3) (L)':
            case 'Label:2H(4) (K)':
            case 'Label:2H(4)+Acetyl (K)':
            case 'Label:2H(4)+GlyGly (K)':
            case 'Label:2H(9)13C(6)15N(2) (K)':
            case 'lapachenole (C)':
            case 'Leu-&gt;MetOx (L)':
            case 'LeuArgGlyGly (K)':
            case 'LG-anhydrolactam (K)':
            case 'LG-anhydrolactam (N-term)':
            case 'LG-anhyropyrrole (K)':
            case 'LG-anhyropyrrole (N-term)':
            case 'LG-Hlactam-K (K)':
            case 'LG-Hlactam-K (Protein N-term)':
            case 'LG-Hlactam-R (R)':
            case 'LG-lactam-K (K)':
            case 'LG-lactam-K (Protein N-term)':
            case 'LG-lactam-R (R)':
            case 'LG-pyrrole (K)':
            case 'LG-pyrrole (N-term)':
            case 'Lipoyl (K)':
            case 'Lys-&gt;Allysine (K)':
            case 'Lys-&gt;AminoadipicAcid (K)':
            case 'Lys-&gt;CamCys (K)':
            case 'Lys-&gt;MetOx (K)':
            case 'Lys-loss (Protein C-term K)':
            case 'Lysbiotinhydrazide (K)':
            case 'maleimide (C)':
            case 'maleimide (K)':
            case 'maleimide-3-saccharide (C)':
            case 'maleimide-3-saccharide (K)':
            case 'maleimide-5-saccharide (C)':
            case 'maleimide-5-saccharide (K)':
            case 'Maleimide-PEO2-Biotin (C)':
            case 'Malonyl (C)':
            case 'Malonyl (S)':
            case 'MDCC (C)':
            case 'Menadione (C)':
            case 'Menadione (K)':
            case 'Menadione-HQ (C)':
            case 'Menadione-HQ (K)':
            case 'MercaptoEthanol (S)':
            case 'MercaptoEthanol (T)':
            case 'Met-&gt;Aha (M)':
            case 'Met-&gt;Hpg (M)':
            case 'Met-&gt;Hse (C-term M)':
            case 'Met-&gt;Hsl (C-term M)':
            case 'Met-loss (Protein N-term M)':
            case 'Met-loss+Acetyl (Protein N-term M)':
            case 'Methyl (C)':
            case 'Methyl (C-term)':
            case 'Methyl (DE)':
            case 'Methyl (H)':
            case 'Methyl (I)':
            case 'Methyl (K)':
            case 'Methyl (L)':
            case 'Methyl (N)':
            case 'Methyl (N-term)':
            case 'Methyl (Protein N-term)':
            case 'Methyl (Q)':
            case 'Methyl (R)':
            case 'Methyl (S)':
            case 'Methyl (T)':
            case 'Methyl+Acetyl:2H(3) (K)':
            case 'Methyl+Deamidated (N)':
            case 'Methyl+Deamidated (Q)':
            case 'Methyl-PEO12-Maleimide (C)':
            case 'Methyl:2H(2) (K)':
            case 'Methyl:2H(3) (C-term)':
            case 'Methyl:2H(3) (D)':
            case 'Methyl:2H(3) (E)':
            case 'Methyl:2H(3)13C(1) (R)':
            case 'Methylamine (S)':
            case 'Methylamine (T)':
            case 'Methylmalonylation (S)':
            case 'Methylphosphonate (S)':
            case 'Methylphosphonate (T)':
            case 'Methylphosphonate (Y)':
            case 'Methylpyrroline (K)':
            case 'Methylthio (C)':
            case 'Methylthio (D)':
            case 'Methylthio (N)':
            case 'MG-H1 (R)':
            case 'Microcin (Protein C-term)':
            case 'MicrocinC7 (Protein C-term)':
            case 'Molybdopterin (C)':
            case 'MolybdopterinGD (C)':
            case 'MolybdopterinGD (D)':
            case 'MolybdopterinGD+Delta:S(-1)Se(1) (C)':
            case 'mTRAQ (K)':
            case 'mTRAQ (N-term)':
            case 'mTRAQ (Y)':
            case 'mTRAQ:13C(3)15N(1) (K)':
            case 'mTRAQ:13C(3)15N(1) (N-term)':
            case 'mTRAQ:13C(3)15N(1) (Y)':
            case 'MTSL (C)':
            case 'Myristoleyl (Protein N-term G)':
            case 'Myristoyl (C)':
            case 'Myristoyl (K)':
            case 'Myristoyl (N-term G)':
            case 'Myristoyl+Delta:H(-4) (Protein N-term G)':
            case 'NA-LNO2 (C)':
            case 'NA-LNO2 (H)':
            case 'NA-OA-NO2 (C)':
            case 'NA-OA-NO2 (H)':
            case 'NBS (W)':
            case 'NBS:13C(6) (W)':
            case 'NDA (K)':
            case 'NDA (N-term)':
            case 'NEIAA (C)':
            case 'NEIAA (Y)':
            case 'NEIAA:2H(5) (C)':
            case 'NEIAA:2H(5) (Y)':
            case 'NEM:2H(5) (C)':
            case 'Nethylmaleimide (C)':
            case 'Nethylmaleimide+water (C)':
            case 'Nethylmaleimide+water (K)':
            case 'NHS-LC-Biotin (K)':
            case 'NHS-LC-Biotin (N-term)':
            case 'NIC (N-term)':
            case 'NIPCAM (C)':
            case 'Nitro (W)':
            case 'Nitro (Y)':
            case 'Nitrosyl (C)':
            case 'Nmethylmaleimide (C)':
            case 'Nmethylmaleimide (K)':
            case 'Nmethylmaleimide+water (C)':
            case 'NO_SMX_SEMD (C)':
            case 'NO_SMX_SIMD (C)':
            case 'NO_SMX_SMCT (C)':
            case 'O-Diethylphosphate (K)':
            case 'O-Diethylphosphate (S)':
            case 'O-Diethylphosphate (T)':
            case 'O-Diethylphosphate (Y)':
            case 'O-Dimethylphosphate (S)':
            case 'O-Dimethylphosphate (T)':
            case 'O-Dimethylphosphate (Y)':
            case 'O-Ethylphosphate (S)':
            case 'O-Ethylphosphate (T)':
            case 'O-Ethylphosphate (Y)':
            case 'O-Isopropylmethylphosphonate (S)':
            case 'O-Isopropylmethylphosphonate (T)':
            case 'O-Isopropylmethylphosphonate (Y)':
            case 'O-Methylphosphate (S)':
            case 'O-Methylphosphate (T)':
            case 'O-Methylphosphate (Y)':
            case 'O-pinacolylmethylphosphonate (S)':
            case 'O-pinacolylmethylphosphonate (T)':
            case 'O-pinacolylmethylphosphonate (Y)':
            case 'Octanoyl (S)':
            case 'Octanoyl (T)':
            case 'OxArgBiotin (R)':
            case 'OxArgBiotinRed (R)':
            case 'Oxidation (C)':
            case 'Oxidation (C-term G)':
            case 'Oxidation (D)':
            case 'Oxidation (F)':
            case 'Oxidation (HW)':
            case 'Oxidation (K)':
            case 'Oxidation (M)':
            case 'Oxidation (N)':
            case 'Oxidation (P)':
            case 'Oxidation (R)':
            case 'Oxidation (Y)':
            case 'OxLysBiotin (K)':
            case 'OxLysBiotinRed (K)':
            case 'OxProBiotin (P)':
            case 'OxProBiotinRed (P)':
            case 'Palmitoleyl (C)':
            case 'Palmitoleyl (S)':
            case 'Palmitoleyl (T)':
            case 'Palmitoyl (C)':
            case 'Palmitoyl (K)':
            case 'Palmitoyl (Protein N-term)':
            case 'Palmitoyl (S)':
            case 'Palmitoyl (T)':
            case 'Pentylamine (Q)':
            case 'PentylamineBiotin (Q)':
            case 'PEO-Iodoacetyl-LC-Biotin (C)':
            case 'PET (S)':
            case 'PET (T)':
            case 'PGA1-biotin (C)':
            case 'Phe-&gt;CamCys (F)':
            case 'Phenylisocyanate (N-term)':
            case 'Phenylisocyanate:2H(5) (N-term)':
            case 'Phospho (C)':
            case 'Phospho (D)':
            case 'Phospho (H)':
            case 'Phospho (R)':
            case 'Phospho (ST)':
            case 'Phospho (Y)':
            case 'Phosphoadenosine (H)':
            case 'Phosphoadenosine (K)':
            case 'Phosphoadenosine (T)':
            case 'Phosphoadenosine (Y)':
            case 'Phosphoguanosine (H)':
            case 'Phosphoguanosine (K)':
            case 'PhosphoHex (S)':
            case 'PhosphoHexNAc (S)':
            case 'Phosphopantetheine (S)':
            case 'Phosphopropargyl (S)':
            case 'Phosphopropargyl (T)':
            case 'Phosphopropargyl (Y)':
            case 'PhosphoribosyldephosphoCoA (S)':
            case 'PhosphoUridine (H)':
            case 'PhosphoUridine (Y)':
            case 'Phycocyanobilin (C)':
            case 'Phycoerythrobilin (C)':
            case 'Phytochromobilin (C)':
            case 'Piperidine (K)':
            case 'Piperidine (N-term)':
            case 'Pro-&gt;pyro-Glu (P)':
            case 'Pro-&gt;Pyrrolidinone (P)':
            case 'Pro-&gt;Pyrrolidone (P)':
            case 'probiotinhydrazide (P)':
            case 'Propargylamine (C-term)':
            case 'Propargylamine (D)':
            case 'Propargylamine (E)':
            case 'Propionamide (C)':
            case 'Propionamide:2H(3) (C)':
            case 'Propionyl (K)':
            case 'Propionyl (N-term)':
            case 'Propionyl (S)':
            case 'Propionyl:13C(3) (K)':
            case 'Propionyl:13C(3) (N-term)':
            case 'PropylNAGthiazoline (C)':
            case 'Puromycin (C-term -Nemrt)':
            case 'PyMIC (N-term)':
            case 'PyridoxalPhosphate (K)':
            case 'Pyridylacetyl (K)':
            case 'Pyridylacetyl (N-term)':
            case 'Pyridylethyl (C)':
            case 'Pyro-carbamidomethyl (N-term C)':
            case 'pyrophospho (S)':
            case 'pyrophospho (T)':
            case 'PyruvicAcidIminyl (K)':
            case 'PyruvicAcidIminyl (Protein N-term C)':
            case 'PyruvicAcidIminyl (Protein N-term V)':
            case 'QAT (C)':
            case 'QAT:2H(3) (C)':
            case 'QEQTGG (K)':
            case 'QQQTGG (K)':
            case 'Quinone (W)':
            case 'Quinone (Y)':
            case 'Retinylidene (K)':
            case 'Ser-&gt;LacticAcid (Protein N-term S)':
            case 'SerTyr (N-term)':
            case 'SMA (K)':
            case 'SMA (N-term)':
            case 'SMCC-maleimide (C)':
            case 'SPITC (K)':
            case 'SPITC (N-term)':
            case 'SPITC:13C(6) (K)':
            case 'SPITC:13C(6) (N-term)':
            case 'Succinyl (K)':
            case 'Succinyl (N-term)':
            case 'Succinyl (Protein N-term)':
            case 'Succinyl:13C(4) (K)':
            case 'Succinyl:13C(4) (N-term)':
            case 'Succinyl:2H(4) (K)':
            case 'Succinyl:2H(4) (N-term)':
            case 'SulfanilicAcid (C-term)':
            case 'SulfanilicAcid (D)':
            case 'SulfanilicAcid (E)':
            case 'SulfanilicAcid:13C(6) (C-term)':
            case 'SulfanilicAcid:13C(6) (D)':
            case 'SulfanilicAcid:13C(6) (E)':
            case 'Sulfide (C)':
            case 'Sulfide (D)':
            case 'Sulfo (C)':
            case 'Sulfo (S)':
            case 'Sulfo (T)':
            case 'Sulfo (Y)':
            case 'Sulfo-NHS-LC-LC-Biotin (K)':
            case 'Sulfo-NHS-LC-LC-Biotin (N-term)':
            case 'SulfoGMBS (C)':
            case 'SUMO2135 (K)':
            case 'SUMO3549 (K)':
            case 'Thioacyl (K)':
            case 'Thioacyl (N-term)':
            case 'thioacylpropionamide (K)':
            case 'Thiocarbamidomethylation (D)':
            case 'Thiophos-S-S-biotin (S)':
            case 'Thiophos-S-S-biotin (T)':
            case 'Thiophos-S-S-biotin (Y)':
            case 'Thiophospho (S)':
            case 'Thiophospho (T)':
            case 'Thiophospho (Y)':
            case 'Thrbiotinhydrazide (T)':
            case 'Thyroxine (Y)':
            case 'TMAB (K)':
            case 'TMAB (N-term)':
            case 'TMAB:2H(9) (K)':
            case 'TMAB:2H(9) (N-term)':
            case 'TMPP-Ac (N-term)':
            case 'TMT (K)':
            case 'TMT (N-term)':
            case 'TMT2plex (K)':
            case 'TMT2plex (N-term)':
            case 'TMT6plex (K)':
            case 'TMT6plex (N-term)':
            case 'TNBS (K)':
            case 'TNBS (N-term)':
            case 'trifluoro (L)':
            case 'Triiodo (Y)':
            case 'Triiodothyronine (Y)':
            case 'Trimethyl (K)':
            case 'Trimethyl (Protein N-term A)':
            case 'Trimethyl (R)':
            case 'Trioxidation (C)':
            case 'Tripalmitate (Protein N-term C)':
            case 'Trp-&gt;Hydroxykynurenin (W)':
            case 'Trp-&gt;Kynurenin (W)':
            case 'Trp-&gt;Oxolactone (W)':
            case 'Tyr-&gt;Dha (Y)':
            case 'VFQQQTGG (K)':
            case 'VIEVYQEQTGG (K)':
            case 'Xlink:B10621 (C)':
            case 'Xlink:DMP (K)':
            case 'Xlink:DMP (Protein N-term)':
            case 'Xlink:DMP-s (K)':
            case 'Xlink:DMP-s (Protein N-term)':
            case 'Xlink:novobiocin (N-term)':
            case 'Xlink:SSD (K)':
            case 'ZGB (K)':
            case 'ZGB (N-term)':
                return true;
            default:
                return false;
        }
    }
}
