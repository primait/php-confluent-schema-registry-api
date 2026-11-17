<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Test\Registry\Cache;

use PrimaAssicurazioni\SchemaRegistryApi\Registry\Cache\CacheItemPoolAdapter;
use PrimaAssicurazioni\SchemaRegistryApi\Registry\CacheAdapter;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class CacheItemPoolAdapterTest extends AbstractCacheAdapterTestCase
{
    protected function getAdapter(): CacheAdapter
    {
        return new CacheItemPoolAdapter(new ArrayAdapter());
    }
}
