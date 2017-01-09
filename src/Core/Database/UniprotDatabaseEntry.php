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
namespace pgb_liv\php_ms\Core\Database;

/**
 * A sequence Database Entry object.
 * By default the identifier, description
 * and sequence are available. Additional fields will be available if the
 * description has been able to be parsed in the case of FASTA data.
 *
 * @author Andrew Collins
 */
class UniprotDatabaseEntry extends AbstractDatabaseEntry
{

    public function __construct($identifier, $description, $sequence)
    {
        parent::__construct($identifier, $description, $sequence);
        
        // Parse identifier
        $identifierParts = explode('|', $identifier, 3);
        if ($identifierParts[0] == 'sp') {
            $this->database = 'UniProtKB/Swiss-Prot';
        } elseif ($identifierParts[0] == 'tr') {
            $this->database = 'UniProtKB/TrEMBL';
        } else {
            $this->database = $identifierParts[0];
        }
        
        $this->accession = $identifierParts[1];
        $this->entryName = $identifierParts[2];
        
        // Parse description
        $osPosition = strpos($description, ' OS=');
        $this->proteinName = substr($description, 0, $osPosition);
        
        $matches = array();
        preg_match_all('/([OS|GN|PE|SV]{2})=(.+?(?=\s[GN|PE|SV]|$))/', $description, $matches);
        
        foreach ($matches[1] as $key => $value) {
            if ($value == 'OS') {
                $this->organismName = $matches[2][$key];
            } elseif ($value == 'GN') {
                $this->geneName = $matches[2][$key];
            } elseif ($value == 'PE') {
                $this->proteinExistence = $matches[2][$key];
            } elseif ($value == 'SV') {
                $this->sequenceVersion = $matches[2][$key];
            }
        }
    }
}
