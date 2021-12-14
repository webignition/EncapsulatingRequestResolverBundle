<?php

declare(strict_types=1);

namespace webignition\SymfonyEncapsulatingRequestResolver\Tests\Functional;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use webignition\SymfonyEncapsulatingRequestResolver\EncapsulatingRequestResolverBundle;

class TestingKernel extends Kernel
{
    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new EncapsulatingRequestResolverBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
    }
}
