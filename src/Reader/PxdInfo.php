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

/**
 *
 * @author Andrew Collins
 */
class PxdInfo
{

    const INFO_PATH = 'http://proteomecentral.proteomexchange.org/cgi/GetDataset?ID=%s&outputMode=XML&test=no';

    private $identifier;

    private $fileList = array();

    /**
     * Proteome Exchange identifer to search for.
     *
     * @param string $id
     *            Identifier must be specified as either "PXD###" or as an integer
     */
    public function __construct($identifier)
    {
        if (stripos($identifier, 'PXD') === 0) {
            $this->identifier = (int) substr($identifier, 3);
        } elseif (is_numeric($identifier) && (int) $identifier == $identifier) {
            $this->identifier = (int) $identifier;
        } else {
            throw new \InvalidArgumentException('Identifier must be either an integer or PXD#### string');
        }
        
        $this->parseInfo();
    }

    private function parseInfo()
    {
        $url = sprintf(PxdInfo::INFO_PATH, $this->identifier);
        $data = get_headers($url, 1);
        $status = explode(' ', $data[0], 3);
        
        if ($status[1] != 200) {
            throw new \InvalidArgumentException($status[2]);
        }
        
        $schema = new \SimpleXMLElement($url, null, true);
        
        foreach ($schema->FullDatasetLinkList->FullDatasetLink as $datasetLink) {
            if ((string) $datasetLink->cvParam->attributes()->accession == 'PRIDE:0000411') {
                $this->datasetBaseUrl = (string) $datasetLink->cvParam->attributes()->accession->value;
            }
        }
        
        $this->idString = $schema->attributes()->id;
        
        $file = array();
        if (isset($schema->DatasetFileList)) {
            foreach ($schema->DatasetFileList->DatasetFile as $datasetFile) {
                $file['id'] = (string) $datasetFile->attributes()->id;
                $file['name'] = (string) $datasetFile->attributes()->name;
                $file['location'] = (string) $datasetFile->cvParam->attributes()->value;
                
                $this->fileList[] = $file;
            }
        }
        
        $this->isInitialised = true;
    }

    public function getDatasetFileList()
    {
        return $this->fileList;
    }

    public function getIdString()
    {
        return $this->idString;
    }
}
