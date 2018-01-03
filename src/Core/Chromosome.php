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
 * Class for chromosome identification object, provides storage for assigning a name, strand and version.
 *
 * @author Andrew Collins
 */
class Chromosome
{

    /**
     * Name of this chromosome
     *
     * @var string
     */
    private $name;

    /**
     * Strand of this chomosome
     *
     * @var string
     */
    private $strand;

    /**
     * The reference genome and versioning string as used for mapping.
     * All coordinates are within this frame of reference
     *
     * @var string
     */
    private $genomeReferenceVersion;

    /**
     * Sets the chromosome name
     *
     * @param string $name
     *            value to set
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the name for this chromosome
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the chromosome strand
     *
     * @param string $strand
     *            value to set
     */
    public function setStrand($strand)
    {
        $this->strand = $strand;
    }

    /**
     * Gets the chromosome strand
     *
     * @return string
     */
    public function getStrand()
    {
        return $this->strand;
    }

    /**
     * Sets the reference genome and versioning string as used for mapping.
     * All coordinates are within this frame of reference
     *
     * @param string $version
     *            Version value to set to
     */
    public function setGenomeReferenceVersion($version)
    {
        $this->genomeReferenceVersion = $version;
    }

    /**
     * Gets the reference genome and versioning string as used for mapping.
     * All coordinates are within this frame of reference.
     *
     * @return string
     */
    public function getGenomeReferenceVersion()
    {
        return $this->genomeReferenceVersion;
    }
}
