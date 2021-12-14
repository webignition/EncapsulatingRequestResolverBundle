<?php

declare(strict_types=1);

namespace webignition\EncapsulatingRequestResolverBundle\Model;

use Symfony\Component\HttpFoundation\Request;

interface EncapsulatingRequestInterface
{
    public static function create(Request $request): object;
}
