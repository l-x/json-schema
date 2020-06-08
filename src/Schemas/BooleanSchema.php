<?php
/* ============================================================================
 * Copyright 2020 Zindex Software
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================================ */

namespace Opis\JsonSchema\Schemas;

use Opis\JsonSchema\IContext;
use Opis\JsonSchema\Info\{DataInfo, ISchemaInfo};
use Opis\JsonSchema\Errors\{ValidationError, IValidationError};

final class BooleanSchema extends AbstractSchema
{

    private bool $data;

    /**
     * @param ISchemaInfo $info
     */
    public function __construct(ISchemaInfo $info)
    {
        parent::__construct($info);
        $this->data = $info->data();
    }

    /**
     * @inheritDoc
     */
    public function validate(IContext $context): ?IValidationError
    {
        if ($this->data) {
            return null;
        }

        return new ValidationError('', $this, DataInfo::fromContext($context), 'Data not allowed');
    }
}