<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Exception;

class SubjectNotFoundException extends AbstractSchemaRegistryException
{
    public const int ERROR_CODE = 40401;
}
