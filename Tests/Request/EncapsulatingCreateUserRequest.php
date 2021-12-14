<?php

declare(strict_types=1);

namespace webignition\EncapsulatingRequestResolverBundle\Tests\Request;

use Symfony\Component\HttpFoundation\Request;
use webignition\EncapsulatingRequestResolverBundle\Model\EncapsulatingRequestInterface;

class EncapsulatingCreateUserRequest implements EncapsulatingRequestInterface
{
    public const KEY_EMAIL = 'email';
    public const KEY_PASSWORD = 'password';

    public function __construct(
        private string $email,
        private string $password
    ) {
    }

    public static function create(Request $request): object
    {
        $requestData = $request->request;

        return new EncapsulatingCreateUserRequest(
            (string) $requestData->get(self::KEY_EMAIL),
            (string) $requestData->get(self::KEY_PASSWORD)
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
