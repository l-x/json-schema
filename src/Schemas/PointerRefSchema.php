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

use Opis\JsonSchema\{ISchema, JsonPointer, IContext};
use Opis\JsonSchema\Info\ISchemaInfo;
use Opis\JsonSchema\Variables\IVariables;
use Opis\JsonSchema\Errors\IValidationError;
use Opis\JsonSchema\Exceptions\UnresolvedRefException;

class PointerRefSchema extends AbstractRefSchema
{

    protected JsonPointer $pointer;

    /** @var bool|null|ISchema */
    protected $resolved = false;

    /**
     * @param ISchemaInfo $info
     * @param JsonPointer $pointer
     * @param IVariables|null $mapper
     * @param IVariables|null $globals
     * @param array|null $slots
     */
    public function __construct(ISchemaInfo $info, JsonPointer $pointer,
                                ?IVariables $mapper, ?IVariables $globals, ?array $slots = null)
    {
        parent::__construct($info, $mapper, $globals, $slots);
        $this->pointer = $pointer;
    }

    /**
     * @inheritDoc
     */
    public function validate(IContext $context): ?IValidationError
    {
        if ($this->resolved === false) {
            $this->resolved = $this->resolvePointer($context->loader(), $this->pointer,
                $this->resolveBaseUri($this->info), $this->info->path());
        }

        if ($this->resolved === null) {
            throw new UnresolvedRefException((string)$this->pointer, $this, $context);
        }

        return $this->resolved->validate($this->createContext($context, $this->mapper, $this->globals, $this->slots));
    }
}