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

    /**
     * Perform the MS-GF+ search using the specified parameters.
     * Any paramaters not specified will use the MS-GF+ defaults.
     *
     * @param SearchParametersInterface $parameters
     *            Paramaters object for any arguments to send to MS-GF+
     * @throws \InvalidArgumentException Thrown if any of the required properties are missing
     * @return string Path to the results file
     */
    public function search(SearchParametersInterface $parameters)
    {
        if (! is_a($parameters, 'pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters')) {
            throw new \InvalidArgumentException('Argument 1 expected to be of type MsgfPlusSearchParameters');
        }
        
        if (is_null($parameters->getSpectraPath()) || ! file_exists($parameters->getSpectraPath())) {
            throw new \InvalidArgumentException('Valid Spectra file must be specified in paramaters.');
        }
        
        if (is_null($parameters->getDatabases()) || ! file_exists($parameters->getDatabases())) {
            throw new \InvalidArgumentException('Valid database file must be specified in paramaters.');
        }
        
        $command = $this->getCommand($parameters);
        
        $this->executeCommand($command);
        
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
        
        $command .= ' -s "' . $parameters->getSpectraPath() . '"';
        $command .= ' -d "' . $parameters->getDatabases() . '"';
        
        $command .= $this->appendArgument(' -o', $parameters->getOutputFile());
        
        if (! is_null($parameters->getPrecursorTolerance())) {
            $command .= ' -t ' . $parameters->getPrecursorTolerance()->getTolerance() .
                 $parameters->getPrecursorTolerance()->getUnit();
        }
        
        $command .= $this->appendArgument(' -ti', $parameters->getIsotopeErrorRange());
        $command .= $this->appendArgument(' -thread', $parameters->getNumOfThreads());
        $command .= $this->appendArgument(' -tda', $parameters->isDecoyEnabled() ? 1 : 0);
        $command .= $this->appendArgument(' -m', $parameters->getFragmentationMethodId());
        $command .= $this->appendArgument(' -inst', $parameters->getMs2DetectorId());
        $command .= $this->appendArgument(' -e', $parameters->getEnzyme());
        
        $command .= $this->appendArgument(' -protocol', $parameters->getProtocolId());
        $command .= $this->appendArgument(' -ntt', $parameters->getTolerableTrypticTermini());
        
        if (! is_null($parameters->getModificationFile())) {
            $command .= ' -mod ' . $parameters->getModificationFile();
        } elseif (count($parameters->getModifications()) > 0) {
            $path = MsgfPlusSearchParameters::createModificationFile($parameters->getModifications());
            $command .= ' -mod "' . $path . '"';
        }
        
        $command .= $this->appendArgument(' -minLength', $parameters->getMinPeptideLength());
        $command .= $this->appendArgument(' -maxLength', $parameters->getMaxPeptideLength());
        $command .= $this->appendArgument(' -minCharge', $parameters->getMinPrecursorCharge());
        $command .= $this->appendArgument(' -maxCharge', $parameters->getMaxPrecursorCharge());
        $command .= $this->appendArgument(' -n', $parameters->getNumMatchesPerSpectrum());
        $command .= $this->appendArgument(' -addFeatures', $parameters->getAdditionalFeatures());
        $command .= $this->appendArgument(' -ccm', $parameters->getChargeCarrierMass());
        
        return $command . $this->appendArgument(' -showQValue', $parameters->getShowQValue());
    }

    private function appendArgument($key, $value)
    {
        if (is_null($value)) {
            return '';
        }
        
        return $key . ' ' . $value;
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
        $stdoutPath = tempnam(sys_get_temp_dir(), 'php-msMsgfOut');
        $stderrPath = tempnam(sys_get_temp_dir(), 'php-msMsGfErr');
        
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
