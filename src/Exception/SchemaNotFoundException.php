<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Exception;

class SchemaNotFoundException extends AbstractSchemaRegistryException
{
    public const int ERROR_CODE = 40403;
}
