<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Exception;

class BackendDataStoreException extends AbstractSchemaRegistryException
{
    public const int ERROR_CODE = 50001;
}
