<?php

declare(strict_types=1);

namespace webignition\EncapsulatingRequestResolverBundle\Tests\Functional\Services;

use webignition\EncapsulatingRequestResolverBundle\Services\Resolver;
use webignition\EncapsulatingRequestResolverBundle\Tests\AbstractResolverTest;
use webignition\EncapsulatingRequestResolverBundle\Tests\Functional\TestingKernel;

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
