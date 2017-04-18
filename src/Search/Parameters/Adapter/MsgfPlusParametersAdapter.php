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
namespace pgb_liv\php_ms\Search\Parameters\Adapter;

use pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters;
use pgb_liv\php_ms\Reader\MzIdentMlReader1Interface;

/**
 * Converts the parameters retreived from file formats to MS-GF+ parameters objects
 *
 * @author Andrew Collins
 */
class MsgfPlusParametersAdapter
{

    public static function fromMzIdentML(MzIdentMlReader1Interface $reader)
    {
        $protocols = $reader->getAnalysisProtocolCollection();
        $parameters = array();
        foreach ($protocols['spectrum'] as $protocol) {
            if ($protocol['software']['name'] == 'MS-GF+') {
                $parameters[] = MsgfPlusParametersAdapter::createParameters($reader, $protocol);
            }
        }
        
        return $parameters;
    }

    private static function createParameters(MzIdentMlReader1Interface $reader, array $parameters)
    {
        $inputs = $reader->getInputs();
        $database = current($inputs['SearchDatabase']);
        $spectra = current($inputs['SearchDatabase']);
        $enzyme = current($parameters['enzymes']);
        
        $msgf = new MsgfPlusSearchParameters();
        
        if (isset($database)) {
            $msgf->setDatabases($database['location']);
        }
        
        $msgf->setSpectraPath($spectra['location'], true);
        
        foreach ($parameters['modifications'] as $modification) {
            $msgf->addModification($modification);
        }
        
        if (isset($parameters['additions']['user']['ChargeCarrierMass'])) {
            $msgf->setChargeCarrierMass((float) $parameters['additions']['user']['ChargeCarrierMass']);
        }
        
        if (isset($parameters['additions']['user']['TargetDecoyApproach'])) {
            $msgf->setDecoyEnabled($parameters['additions']['user']['TargetDecoyApproach'] == 'true');
        }
        
        if (isset($enzyme)) {
            // TODO: Add other enzymes that are supported
            switch ($enzyme['EnzymeName']['accession']) {
                case 'MS:1001251':
                    $msgf->setEnzyme(1);
                    break;
                default:
                    throw new \InvalidArgumentException('Unknown enzyme accession');
            }
        }
        
        if (isset($parameters['additions']['user']['FragmentMethod'])) {
            switch ($parameters['additions']['user']['FragmentMethod']) {
                case 'As written in the spectrum or CID if no info':
                    $msgf->setFragmentationMethodId(0);
                    break;
                case 'CID':
                    $msgf->setFragmentationMethodId(1);
                    break;
                case 'ETD':
                    $msgf->setFragmentationMethodId(2);
                    break;
                case 'HCD':
                    $msgf->setFragmentationMethodId(3);
                    break;
                default:
                    throw new \InvalidArgumentException('Unknown FragmentMethod type');
            }
        }
        
        if (isset($parameters['additions']['user']['MinIsotopeError']) &&
             isset($parameters['additions']['user']['MaxIsotopeError'])) {
            $msgf->setIsotopeErrorRange(
                $parameters['additions']['user']['MinIsotopeError'] . ',' .
                 $parameters['additions']['user']['MaxIsotopeError']);
        }
        
        if (isset($parameters['additions']['user']['MaxPepLength'])) {
            $msgf->setMaxPeptideLength((int) $parameters['additions']['user']['MaxPepLength']);
        }
        
        if (isset($parameters['additions']['user']['MinPepLength'])) {
            $msgf->setMinPeptideLength((int) $parameters['additions']['user']['MinPepLength']);
        }
        
        if (isset($parameters['additions']['user']['MaxCharge'])) {
            $msgf->setMaxPrecursorCharge((int) $parameters['additions']['user']['MaxCharge']);
        }
        
        if (isset($parameters['additions']['user']['MinCharge'])) {
            $msgf->setMinPrecursorCharge((int) $parameters['additions']['user']['MinCharge']);
        }
        
        if (isset($parameters['additions']['user']['Instrument'])) {
            switch ($parameters['additions']['user']['Instrument']) {
                case 'LowRes':
                    $msgf->setMs2DetectorId(0);
                    break;
                case 'HighRes':
                    $msgf->setMs2DetectorId(1);
                    break;
                case 'TOF':
                    $msgf->setMs2DetectorId(2);
                    break;
                case 'Q-Exactive':
                    $msgf->setMs2DetectorId(3);
                    break;
                default:
                    throw new \InvalidArgumentException('Unknown Instrument type');
            }
        }
        
        if (isset($parameters['additions']['user']['NumMatchesPerSpec'])) {
            $msgf->setNumMatchesPerSpectrum((int) $parameters['additions']['user']['NumMatchesPerSpec']);
        }
        
        // TODO: Support async tolerance
        if (isset($parameters['parentTolerance'][0])) {
            $msgf->setPrecursorTolerance($parameters['parentTolerance'][0]);
        }
        
        if (isset($parameters['additions']['user']['Protocol'])) {
            switch ($parameters['additions']['user']['Protocol']) {
                case 'No protocol':
                    $msgf->setProtocolId(0);
                    break;
                case 'Phosphorylation':
                    $msgf->setProtocolId(1);
                    break;
                case 'iTRAQ':
                    $msgf->setProtocolId(2);
                    break;
                case 'iTRAQPhospho':
                    $msgf->setProtocolId(3);
                    break;
                default:
                    throw new \InvalidArgumentException('Unknown Protocol type');
            }
        }
        
        if (isset($parameters['additions']['user']['NumTolerableTermini'])) {
            $msgf->setTolerableTrypticTermini((int) $parameters['additions']['user']['NumTolerableTermini']);
        }
        
        return $msgf;
    }
}
