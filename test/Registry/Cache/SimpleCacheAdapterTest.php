<?php

declare(strict_types=1);

namespace PrimaAssicurazioni\SchemaRegistryApi\Test\Registry\Cache;

use PrimaAssicurazioni\SchemaRegistryApi\Registry\Cache\SimpleCacheAdapter;
use PrimaAssicurazioni\SchemaRegistryApi\Registry\CacheAdapter;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

class SimpleCacheAdapterTest extends AbstractCacheAdapterTestCase
{
    protected function getAdapter(): CacheAdapter
    {
        return new SimpleCacheAdapter(new Psr16Cache(new ArrayAdapter()));
    }
}
