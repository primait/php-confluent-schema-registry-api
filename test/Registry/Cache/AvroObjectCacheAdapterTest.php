<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Test\Registry\Cache;

use PrimaAssicurazioni\SchemaRegistryApi\Registry\Cache\AvroObjectCacheAdapter;
use PrimaAssicurazioni\SchemaRegistryApi\Registry\CacheAdapter;

class AvroObjectCacheAdapterTest extends AbstractCacheAdapterTestCase
{
    protected function getAdapter(): CacheAdapter
    {
        return new AvroObjectCacheAdapter();
    }
}
