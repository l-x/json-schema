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

namespace Opis\JsonSchema\Exceptions;

use Opis\JsonSchema\{IContext, ISchema};

class UnresolvedRefException extends UnresolvedException
{

    protected string $ref;

    /**
     * @param string $ref
     * @param ISchema $schema
     * @param IContext $context
     */
    public function __construct(string $ref, ISchema $schema, IContext $context)
    {
        parent::__construct("Unresolved \$ref: {$ref}", $schema, $context);
        $this->ref = $ref;
    }

    /**
     * @return string
     */
    public function getRef(): string
    {
        return $this->ref;
    }
}