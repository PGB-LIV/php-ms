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

use pgb_liv\php_ms\Search\Parameters\SearchParametersInterface;
use pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters;

/**
 * Client to perform MS-GF+ search and results retrieval
 *
 * @author Andrew Collins
 */
class MsgfPlusSearch
{

    private $exePath;

    private $javaPath;

    /**
     * Create a new instance of this class.
     * Must supply server details.
     *
     * @param string $exePath
     *            Path to the MSGFPlus.jar executable
     * @param string $javaPath
     *            Path to the JRE executable
     */
    public function __construct($exePath, $javaPath = 'java')
    {
        $this->exePath = $exePath;
        $this->javaPath = $javaPath;
    }

    public function search(SearchParametersInterface $parameters)
    {
        if (! is_a($parameters, 'pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters')) {
            throw new \InvalidArgumentException('Argument 1 expected to be of type MsgfPlusSearchParameters');
        }
        
        // TODO: Validate SpectraPath && Database have values
        
        $command = $this->getCommand($parameters);
        
        $result = $this->executeCommand($command);
        
        if (! is_null($parameters->getOutputFile())) {
            return $parameters->getOutputFile();
        } else {
            $extensionPos = strrpos($parameters->getSpectraPath(), '.');
            return substr($parameters->getSpectraPath(), 0, $extensionPos) . '.mzid';
        }
    }

    private function getCommand(MsgfPlusSearchParameters $parameters)
    {
        $command = $this->javaPath;
        $command .= ' -jar ';
        $command .= $this->exePath;
        
        $command .= ' -s ' . $parameters->getSpectraPath();
        $command .= ' -d ' . $parameters->getDatabases();
        
        if (! is_null($parameters->getOutputFile())) {
            $command .= ' -o ' . $parameters->getOutputFile();
        }
        
        if (! is_null($parameters->getPrecursorTolerance()) && ! is_null($parameters->getPrecursorToleranceUnit())) {
            $command .= ' -t ' . $parameters->getPrecursorTolerance() . $parameters->getPrecursorToleranceUnit();
        }
        
        if (! is_null($parameters->getIsotopeErrorRange())) {
            $command .= ' -t ' . $parameters->getIsotopeErrorRange();
        }
        
        if (! is_null($parameters->getIsotopeErrorRange())) {
            $command .= ' -ti ' . $parameters->getIsotopeErrorRange();
        }
        
        if (! is_null($parameters->getNumOfThreads())) {
            $command .= ' -thread ' . $parameters->getNumOfThreads();
        }
        
        if (! is_null($parameters->isDecoyEnabled())) {
            $command .= ' -tda ' . ($parameters->isDecoyEnabled() ? 1 : 0);
        }
        
        if (! is_null($parameters->getFragmentationMethodId())) {
            $command .= ' -m ' . $parameters->getFragmentationMethodId();
        }
        
        if (! is_null($parameters->getMs2DetectorId())) {
            $command .= ' -inst ' . $parameters->getMs2DetectorId();
        }
        
        if (! is_null($parameters->getEnzyme())) {
            $command .= ' -e ' . $parameters->getEnzyme();
        }
        
        if (! is_null($parameters->getProtocolId())) {
            $command .= ' -protocol ' . $parameters->getProtocolId();
        }
        
        if (! is_null($parameters->getTolerableTrypticTermini())) {
            $command .= ' -ntt ' . $parameters->getTolerableTrypticTermini();
        }
        
        if (! is_null($parameters->getModificationFile())) {
            $command .= ' -mod ' . $parameters->getModificationFile();
        }
        
        if (! is_null($parameters->getMinPeptideLength())) {
            $command .= ' -minLength ' . $parameters->getMinPeptideLength();
        }
        
        if (! is_null($parameters->getMinPeptideLength())) {
            $command .= ' -maxLength ' . $parameters->getMaxPeptideLength();
        }
        
        if (! is_null($parameters->getMinPrecursorCharge())) {
            $command .= ' -minCharge ' . $parameters->getMinPrecursorCharge();
        }
        
        if (! is_null($parameters->getMaxPeptideLength())) {
            $command .= ' -maxCharge ' . $parameters->getMaxPeptideLength();
        }
        
        if (! is_null($parameters->getNumMatchesPerSpectrum())) {
            $command .= ' -n ' . $parameters->getNumMatchesPerSpectrum();
        }
        
        if (! is_null($parameters->getAdditionalFeatures())) {
            $command .= ' -addFeatures ' . $parameters->getAdditionalFeatures();
        }
        
        if (! is_null($parameters->getChargeCarrierMass())) {
            $command .= ' -ccm ' . $parameters->getChargeCarrierMass();
        }
        
        if (! is_null($parameters->getShowQValue())) {
            $command .= ' -showQValue ' . $parameters->getShowQValue();
        }
        
        return $command;
    }

    /**
     * Executes the MSGF+ Command.
     *
     * @param string $command
     *            Complete command line argument to execute
     * @throws \InvalidArgumentException Thrown if MS-GF+ writes anything to stderr
     * @return string Path to MS-GF+ stdout log file
     */
    private function executeCommand($command)
    {
        $stdoutPath = tempnam(sys_get_temp_dir(), 'php-ms') . '.log';
        $stderrPath = tempnam(sys_get_temp_dir(), 'php-ms') . '.log';
        
        $descriptors = array(
            0 => array(
                'pipe',
                'r'
            ),
            1 => array(
                'file',
                $stdoutPath,
                'a'
            ),
            2 => array(
                'file',
                $stderrPath,
                'a'
            )
        );
        
        $process = proc_open($command, $descriptors, $pipes);
        proc_close($process);
        
        if (filesize($stderrPath) > 0) {
            throw new \InvalidArgumentException(file_get_contents($stderrPath));
        }
        
        return $stdoutPath;
    }
}
