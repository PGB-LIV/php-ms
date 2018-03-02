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
 * Interface to ion properties of an object
 *
 * @author Andrew Collins
 */
interface ModifiableSequenceInterface
{

    /**
     * Sets the sequence for this object
     *
     * @param string $sequence
     *            The amino-acid sequence to set
     */
    public function setSequence($sequence);

    /**
     * Gets the sequence for this object
     *
     * @return string
     */
    public function getSequence();

    /**
     * Adds the specified modification to this protein
     *
     * @param Modification $modification
     *            Modification object to apply
     */
    public function addModification(Modification $modification);

    /**
     * Adds the specified modifications to this protein
     *
     * @param Modification[] $modifications
     *            Modifications to apply
     */
    public function addModifications(array $modifications);

    /**
     * Gets the modifications
     *
     * @return Modification[]
     */
    public function getModifications();

    /**
     * Returns whether this protein contains modifications or not
     *
     * @return boolean True if the object contains modifications
     */
    public function isModified();

    /**
     * Sets whether this sequence is a decoy sequence
     *
     * @param bool $bool
     *            Value to set to
     */
    public function setIsDecoy($bool);

    /**
     * Gets whether this sequence is a decoy sequence
     *
     * @return boolean
     */
    public function isDecoy();

    /**
     * Gets the length of the sequence in this object
     *
     * @return int
     */
    public function getLength();

    /**
     * Gets the theoretical monoisotopic neutral mass for this sequence and it's modifications
     *
     * @return double The neutral mass of the sequence
     * @deprecated Use getMonoisotopicMass() directly
     */
    public function getMass();

    /**
     * Gets the theoretical monoisotopic neutral mass for this sequence and it's modifications
     *
     * @return double The neutral mass of the sequence
     */
    public function getMonoisotopicMass();

    /**
     * Calculates the theoretical mass/charge value for this sequence.
     * Note: To get the experimental value, check the PrecursorIon data that this peptide might be a child of.
     *
     * @param int $charge
     *            The charge value to use for the calculation
     */
    public function getMonoisotopicMassCharge($charge);

    /**
     * Reverses the current sequence.
     * Suitable for creating decoy sequences
     */
    public function reverseSequence();
}
