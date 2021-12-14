<?php

declare(strict_types=1);

namespace webignition\EncapsulatingRequestResolverBundle\Tests\Request;

use Symfony\Component\HttpFoundation\Request;
use webignition\EncapsulatingRequestResolverBundle\Model\EncapsulatingRequestInterface;

abstract class AbstractEncapsulatingRequest implements EncapsulatingRequestInterface
{
    public function __construct(Request $request)
    {
        $this->processRequest($request);
    }
}
