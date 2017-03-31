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

/**
 * Encapsulation class for MS-GF+ search parameters
 *
 * @author Andrew Collins
 */
class MsgfPlusSearchParameters extends AbstractSearchParameters implements SearchParametersInterface
{

    private $outputFile;

    private $isotopeErrorRange;

    private $numOfThreads;

    private $fragmentationMethodId;

    private $ms2DetectorId;

    private $protocolId;

    private $tolerableTrypticTermini;

    private $modificationFile;

    private $minPeptideLength;

    private $maxPeptideLength;

    private $minPrecursorCharge;

    private $maxPrecursorCharge;

    private $numMatchesPerSpec;

    private $additionalFeatures;

    private $showQValue;

    private $chargeCarrierMass;

    /**
     * Filename where the output (mzIdentML 1.1 format) will be written.
     * File extension must be "mzid" (case sensitive).
     * By default, the output file name will be "[SpectrumFileName].mzid".
     * E.g. for the input spectrum file "test.mzML", the output will be written to "test.mzid" if this parameter is not specified.
     *
     * @param string $filePath
     *            Full file path to the file that MS-GF+ should create
     */
    public function setOutputFile($filePath)
    {
        $this->outputFile = $filePath;
    }

    /**
     * Gets the current output file path
     *
     * @return string
     */
    public function getOutputFile()
    {
        return $this->outputFile;
    }

    /**
     * Takes into account of the error introduced by choosing non-monoisotopic peak for fragmentation.
     * If the parent mass tolerance is equal to or larger than 0.5Da or 500ppm, this parameter will be ignored.
     * The combination of -t and -ti determines the precursor mass tolerance.
     * E.g. "-t 20ppm -ti -1,2" tests abs(exp-calc-n*1.00335Da)<20ppm for n=-1, 0, 1, 2.
     *
     * @param string $range            
     */
    public function setIsotopeErrorRange($range)
    {
        $this->isotopeErrorRange = $range;
    }

    public function getIsotopeErrorRange()
    {
        return $this->isotopeErrorRange;
    }

    /**
     * (Number of concurrent threads to be executed, Default: Number of available cores)
     *
     * Number of concurrent threads to be executed together.
     * Default value is the number of available logical cores (e.g. 8 for quad-core processor with hyper-threading support).
     *
     * @param int $threadCount
     *            Number of concurrent threads to be executed
     */
    public function setNumOfThreads($threadCount)
    {
        $this->numOfThreads = $threadCount;
    }

    public function getNumOfThreads()
    {
        return $this->numOfThreads;
    }

    /**
     * (0: as written in the spectrum or CID if no info (Default), 1: CID, 2: ETD, 3: HCD, 4: Merge spectra from the same precursor)
     *
     * Fragmentation method identifier (used to determine the scoring model).
     * If the identifier is 0 and fragmentation method is written in the spectrum file (e.g. mzML files), MS-GF+ will recognize the fragmentation method and use
     * a relevant scoring model.
     * If the identifier is 0 and there is no fragmentation method information in the spectrum (e.g. mgf files), CID model will be used by default.
     * If the identifier is non-zero and the spectrum has fragmentation method information, only the spectra that match with the identifier will be processed.
     * If the identifier is non-zero and the spectrum has no fragmentation method information, MS-GF+ will process all spectra assuming the specified
     * fragmentation method.
     * If the identifier is 4, MS/MS spectra from the same precursor ion (e.g. CID/ETD pairs, CID/HCD/ETD triplets) will be merged and the "merged" spectrum
     * will be used for searching instead of individual spectra. See Kim et al., MCP 2010 for details.
     *
     * @param int $method
     *            Fragmentation method identifier
     */
    public function setFragmentationMethodId($method)
    {
        // TODO: Validate int >= 0 && <= 4
        $this->fragmentationMethodId = $method;
    }

    public function getFragmentationMethodId()
    {
        return $this->fragmentationMethodId;
    }

    /**
     * (0: Low-res LCQ/LTQ (Default for CID and ETD), 1: High-res LTQ (Default for HCD), 2: TOF, 3: Q-Exactive)
     *
     * Identifier of the instrument to generate MS/MS spectra (used to determine the scoring model).
     * For "hybrid" spectra with high-precision MS1 and low-precision MS2, use 0.
     * For usual low-precision instruments (e.g. Thermo LTQ), use 0.
     * If MS/MS fragment ion peaks are of high-precision (e.g. tolerance = 10ppm), use 2.
     * For TOF instruments, use 2.
     * For Q-Exactive HCD spectra, use 3.
     * For other HCD spectra, use 1.
     *
     * @param int $identifier
     *            Identifier of the instrument to generate MS/MS spectra
     */
    public function setMs2DetectorId($identifier)
    {
        // TODO: Validate int >= 0 && <= 3
        $this->ms2DetectorId = $identifier;
    }

    public function getMs2DetectorId()
    {
        return $this->ms2DetectorId;
    }

    /**
     * Enzyme identifier.
     * Trypsin (1) will be used by default.
     * 0: unspecific cleavage, 1: Trypsin (default), 2: Chymotrypsin, 3: Lys-C, 4: Lys-N, 5: glutamyl endopeptidase (Glu-C), 6: Arg-C, 7: Asp-N, 8: alphaLP, 9:
     * no cleavage
     * Use 9 for peptidomics studies
     *
     * @param int $enzyme
     *            Enzyme identifier
     */
    public function setEnzyme($enzyme)
    {
        // TODO: Validate int >= 0 && <= 9
        parent::setEnzyme($enzyme);
    }

    /**
     * Protocol identifier.
     * Protocols are used to enable scoring parameters for enriched and/or labeled samples.
     * 0: No protocol (Default)
     * 1: Phosphorylation: for phosphopeptide enriched samples
     * 2: iTRAQ: for iTRAQ-labeled samples
     * 3: iTRAQPhospho: for phosphopeptide enriched and iTRAQ-labeled samples
     *
     * @param int $identifier
     *            Protocol identifier
     */
    public function setProtocolId($identifier)
    {
        $this->protocolId = $identifier;
    }

    public function getProtocolId()
    {
        return $this->protocolId;
    }

    /**
     * This parameter is used to apply the enzyme cleavage specificity rule when searching the database.
     * Specifies the minimum number of termini matching the enzyme specificity rule.
     * For example, for trypsin, K.ACDEFGHR.C (NTT=2), G.ACDEFGHR.C (NTT=1), K.ACDEFGHI.C (NTT=1) and G.ACDEFGHR.C (NTT=0).
     * '-ntt 2' will search for fully tryptic peptides only.
     * By default, -ntt 2 will be used. Using -ntt 1 (or 0) will make the search significantly slower.
     *
     * @param int $identifier
     *            Number of tolerable (tryptic) termini
     */
    public function setTolerableTrypticTermini($identifier)
    {
        // TODO: validate int >= 0 && <= 2
        $this->tolerableTrypticTermini = $identifier;
    }

    public function getTolerableTrypticTermini()
    {
        return $this->tolerableTrypticTermini;
    }

    /**
     * Modification file name.
     * ModificationFile contains the modifications to be considered in the search.
     * If -mod option is not specified, standard amino acids with fixed Carboamidomethylation C will be used.
     *
     * @see https://omics.pnl.gov/download/attachments/13533355/Mods.txt?version=2&modificationDate=1358975546000 Example modification file.
     *     
     * @param string $filePath
     *            Modification file path
     */
    public function setModificationFile($filePath)
    {
        // TODO: Validate file exists
        $this->modificationFile = $filePath;
    }

    public function getModificationFile()
    {
        return $this->modificationFile;
    }

    /**
     * Minimum length of the peptide to be considered.
     * (Default: 6)
     *
     * @param int $length            
     */
    public function setMinPeptideLength($length)
    {
        // TODO: Validate int
        $this->minPeptideLength = $length;
    }

    public function getMinPeptideLength()
    {
        return $this->minPeptideLength;
    }

    /**
     * Maximum length of the peptide to be considered.
     * (Default: 40)
     *
     * @param int $length            
     */
    public function setMaxPeptideLength($length)
    {
        // TODO: Validate int
        $this->maxPeptideLength = $length;
    }

    public function getMaxPeptideLength()
    {
        return $this->maxPeptideLength;
    }

    /**
     * Minimum precursor charge to consider.
     * This parameter is used only for spectra with no charge.
     * (Default: 2)
     *
     * @param int $charge            
     */
    public function setMinPrecursorCharge($charge)
    {
        // TODO: Validate int
        $this->minPrecursorCharge = $charge;
    }

    public function getMinPrecursorCharge()
    {
        return $this->minPrecursorCharge;
    }

    /**
     * Maximum precursor charge to consider.
     * This parameter is used only for spectra with no charge.
     * (Default: 3)
     *
     * @param int $charge            
     */
    public function setMaxPrecursorCharge($charge)
    {
        // TODO: Validate int
        $this->maxPrecursorCharge = $charge;
    }

    public function getMaxPrecursorCharge()
    {
        return $this->maxPrecursorCharge;
    }

    /**
     * Expected false discovery rates (EFDRs) will be reported only when this value is 1.
     *
     * @param int $psmCount
     *            Number of peptide matches per spectrum to report.
     */
    public function setNumMatchesPerSpectrum($psmCount)
    {
        // TODO: Validate uint
        $this->numMatchesPerSpec = $psmCount;
    }

    public function getNumMatchesPerSpectrum()
    {
        return $this->numMatchesPerSpec;
    }

    /**
     * If 0, only basic scores are reported.
     * If 1, the following features are reported
     * MS2IonCurrent: Summed intensity of all product ions
     * ExplainedIonCurrentRatio: Summed intensity of all matched product ions (e.g. b, b-H2O, y, etc.) divided by MS2IonCurrent
     * NTermIonCurrentRatio: Summed intensity of all matched prefix ions (e.g. b, b-H2O, etc.) divided by MS2IonCurrent
     * CTermIonCurrentRatio: Summed intensity of all matched suffix ions (e.g. y, y-H2O, etc.) divided by MS2IonCurrent
     *
     * @param bool $bool            
     */
    public function setAdditionalFeatures($bool)
    {
        // TODO: Validate bool
        $this->additionalFeatures = $bool;
    }

    public function getAdditionalFeatures()
    {
        return $this->additionalFeatures;
    }

    /**
     * If 0, QValue and PepQValue are not reported.
     * If 1, QValue (PSM-level Q-value) and PepQValue (peptide-level Q-value) are reported (Default).
     * This parameter is ignored when "-tda 0".
     *
     * @param bool $bool            
     */
    public function setShowQValue($bool)
    {
        // TODO: Validate bool
        $this->showQValue = $bool;
    }

    public function getShowQValue()
    {
        return $this->showQValue;
    }

    /**
     * Mass of charge carrier, Default: mass of proton (1.00727649)
     *
     * @param float $mass
     *            Mass of charge carrier
     */
    public function setChargeCarrierMass($mass)
    {
        // TODO: Validate float
        $this->chargeCarrierMass = $mass;
    }

    public function getChargeCarrierMass()
    {
        return $this->chargeCarrierMass;
    }
}
