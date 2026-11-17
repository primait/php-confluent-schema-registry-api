<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Exception;

class InvalidAvroSchemaException extends AbstractSchemaRegistryException
{
    public const ERROR_CODE = 42201;
}
