<?php

declare(strict_types=1);

namespace webignition\EncapsulatingRequestResolverBundle\Tests\Request;

use Symfony\Component\HttpFoundation\Request;

class NonEncapsulatingRequestImplementingSomething extends Request implements \Countable
{
    public function count(): int
    {
        return 0;
    }
}
