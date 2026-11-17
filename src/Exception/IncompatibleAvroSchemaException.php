<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Exception;

class IncompatibleAvroSchemaException extends AbstractSchemaRegistryException
{
    public const int ERROR_CODE = 40901;
    public const int LEGACY_ERROR_CODE = 409;
}
