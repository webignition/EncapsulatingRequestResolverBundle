<?php

declare(strict_types=1);

namespace webignition\SymfonyEncapsulatingRequestResolver\Tests\Functional\Services;

use webignition\SymfonyEncapsulatingRequestResolver\Services\Resolver;
use webignition\SymfonyEncapsulatingRequestResolver\Tests\AbstractResolverTest;
use webignition\SymfonyEncapsulatingRequestResolver\Tests\Functional\TestingKernel;

class ResolverTest extends AbstractResolverTest
{
    protected function createResolver(): Resolver
    {
        $kernel = new TestingKernel('test', true);
        $kernel->boot();

        $container = $kernel->getContainer();

        $resolver = $container->get(Resolver::class);
        \assert($resolver instanceof Resolver);

        return $resolver;
    }
}
