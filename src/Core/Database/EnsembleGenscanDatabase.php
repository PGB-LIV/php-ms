<?php
/**
 * Copyright 2019 University of Liverpool
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
 * Class for Ensemble GENSCAN (GENSCAN) database
 *
 * @author Andrew Collins
 */
class EnsembleGenscanDatabase extends AbstractDatabase
{

    const PREFIX = 'GENSCAN';

    /**
     * Sets the database prefix
     *
     * @param string $prefix
     *            value to set
     */
    protected function __construct()
    {
        parent::__construct(self::PREFIX, 'Ensemble/GENSCAN');
        $this->setSource('https://www.ensembl.org');
    }
}
