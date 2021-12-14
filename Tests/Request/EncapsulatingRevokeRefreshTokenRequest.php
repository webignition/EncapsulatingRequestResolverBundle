<?php

declare(strict_types=1);

namespace webignition\EncapsulatingRequestResolverBundle\Tests\Request;

use Symfony\Component\HttpFoundation\Request;
use webignition\EncapsulatingRequestResolverBundle\Model\EncapsulatingRequestInterface;

class EncapsulatingRevokeRefreshTokenRequest implements EncapsulatingRequestInterface
{
    public const KEY_ID = 'id';

    public function __construct(
        private string $id,
    ) {
    }

    public static function create(Request $request): EncapsulatingRevokeRefreshTokenRequest
    {
        return new EncapsulatingRevokeRefreshTokenRequest(
            (string) $request->request->get(self::KEY_ID)
        );
    }

    public function getId(): string
    {
        return $this->id;
    }
}
