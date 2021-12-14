<?php

declare(strict_types=1);

namespace Unit\Services;

use webignition\EncapsulatingRequestResolverBundle\Services\Resolver;
use webignition\EncapsulatingRequestResolverBundle\Tests\AbstractResolverTest;

class ResolverTest extends AbstractResolverTest
{
    protected function createResolver(): Resolver
    {
        return new Resolver();
    }
}
