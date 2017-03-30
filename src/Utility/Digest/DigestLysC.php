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
namespace pgb_liv\php_ms\Utility\Digest;

/**
 *
 * @author Andrew Collins
 */
class DigestLysC extends DigestRegularExpression implements DigestInterface
{

    /**
     * Regular expression for Lys-C.
     *
     * @var string
     * @link http://purl.obolibrary.org/obo/MS_1001335
     */
    const CLEAVAGE_RULE = '/(?<=K)(?!P)/';

    public function __construct()
    {
        parent::__construct(DigestTrypsin::CLEAVAGE_RULE);
        $this->setName('Endoproteinase Lys-C');
    }
}
