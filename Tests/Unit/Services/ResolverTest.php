<?php

declare(strict_types=1);

namespace Unit\Services;

use webignition\SymfonyEncapsulatingRequestResolver\Services\Resolver;
use webignition\SymfonyEncapsulatingRequestResolver\Tests\AbstractResolverTest;

class ResolverTest extends AbstractResolverTest
{
    protected function createResolver(): Resolver
    {
        return new Resolver();
    }
}
