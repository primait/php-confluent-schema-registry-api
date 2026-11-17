<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Exception;

class VersionNotFoundException extends AbstractSchemaRegistryException
{
    public const int ERROR_CODE = 40402;
}
