<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Exception;

class InvalidCompatibilityLevelException extends AbstractSchemaRegistryException
{
    public const int ERROR_CODE = 42203;
}
