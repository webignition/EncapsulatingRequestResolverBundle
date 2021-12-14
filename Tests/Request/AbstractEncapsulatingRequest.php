<?php

declare(strict_types=1);

namespace webignition\SymfonyEncapsulatingRequestResolver\Tests\Request;

use Symfony\Component\HttpFoundation\Request;
use webignition\SymfonyEncapsulatingRequestResolver\Model\EncapsulatingRequestInterface;

abstract class AbstractEncapsulatingRequest implements EncapsulatingRequestInterface
{
    public function __construct(Request $request)
    {
        $this->processRequest($request);
    }
}
