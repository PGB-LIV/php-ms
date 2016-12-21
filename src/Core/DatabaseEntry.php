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
namespace pgb_liv\php_ms\Core;

/**
 * A sequence Database Entry object. By default the identifier, description
 * and sequence are available. Additional fields will be available if the 
 * description has been able to be parsed in the case of FASTA data.
 *
 * @author Andrew Collins
 */
class DatabaseEntry implements \Iterator
{

	private $description;
	
	private $sequence;
	
	private $identifier;
	
	private $database;
	
	private $accession;
	
	private $entryName
	
	private $proteinName;	
	
	private $organismName;
	
	private $geneName;
	
	private $proteinExistence;
	
	private $sequenceVersion;
	
    public function __construct($identifier, $description, $sequence)
    {
		$this->identifier = $identifier;
		$this->description = $description;
		$this->sequence = $sequence;
    }
	
	public function getIdentifier()
	{
		return $this->identifier;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function getSequence()
	{
		return $this->sequence;
	}
}
