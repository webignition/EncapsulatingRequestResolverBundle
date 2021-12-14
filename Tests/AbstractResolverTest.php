<?php

declare(strict_types=1);

namespace webignition\EncapsulatingRequestResolverBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use webignition\EncapsulatingRequestResolverBundle\Model\EncapsulatingRequestInterface;
use webignition\EncapsulatingRequestResolverBundle\Services\Resolver;
use webignition\EncapsulatingRequestResolverBundle\Tests\Request\EncapsulatingCreateUserRequest;
use webignition\EncapsulatingRequestResolverBundle\Tests\Request\EncapsulatingRevokeRefreshTokenRequest;
use webignition\EncapsulatingRequestResolverBundle\Tests\Request\NonEncapsulatingRequestImplementingNothing;
use webignition\EncapsulatingRequestResolverBundle\Tests\Request\NonEncapsulatingRequestImplementingSomething;

abstract class AbstractResolverTest extends TestCase
{
    private Resolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resolver = $this->createResolver();
    }

    /**
     * @dataProvider supportsDataProvider
     */
    public function testSupports(Request $request, ArgumentMetadata $argumentMetadata, bool $expectedSupports): void
    {
        self::assertSame(
            $expectedSupports,
            $this->resolver->supports($request, $argumentMetadata)
        );
    }

    /**
     * @return array<mixed>
     */
    public function supportsDataProvider(): array
    {
        return [
            'null argument type is not supported' => [
                'request' => new Request(),
                'argumentMetadata' => new ArgumentMetadata(
                    'name',
                    null,
                    false,
                    false,
                    null
                ),
                'expectedSupports' => false,
            ],
            'non-existent argument type class is not supported' => [
                'request' => new Request(),
                'argumentMetadata' => new ArgumentMetadata(
                    'name',
                    'Acme\\NonExistentClass',
                    false,
                    false,
                    null
                ),
                'expectedSupports' => false,
            ],
            'argument type implementing nothing is not supported' => [
                'request' => new Request(),
                'argumentMetadata' => new ArgumentMetadata(
                    'name',
                    NonEncapsulatingRequestImplementingNothing::class,
                    false,
                    false,
                    null
                ),
                'expectedSupports' => false,
            ],
            'argument type implementing nothing relevant is not supported' => [
                'request' => new Request(),
                'argumentMetadata' => new ArgumentMetadata(
                    'name',
                    NonEncapsulatingRequestImplementingSomething::class,
                    false,
                    false,
                    null
                ),
                'expectedSupports' => false,
            ],
            'argument type implementing interface is supported' => [
                'request' => new Request(),
                'argumentMetadata' => new ArgumentMetadata(
                    'name',
                    EncapsulatingCreateUserRequest::class,
                    false,
                    false,
                    null
                ),
                'expectedSupports' => true,
            ],
        ];
    }

    /**
     * @dataProvider resolveDataProvider
     */
    public function testResolve(
        Request $request,
        ArgumentMetadata $argumentMetadata,
        EncapsulatingRequestInterface $expectedEncapsulatingRequest
    ): void {
        $generator = $this->resolver->resolve($request, $argumentMetadata);
        $encapsulatingRequest = $generator->current();

        self::assertEquals($expectedEncapsulatingRequest, $encapsulatingRequest);
    }

    /**
     * @return array<mixed>
     */
    public function resolveDataProvider(): array
    {
        $email = 'user@example.com';
        $password = 'password1!';

        $createUserRequest = new Request(
            [],
            [
                EncapsulatingCreateUserRequest::KEY_EMAIL => $email,
                EncapsulatingCreateUserRequest::KEY_PASSWORD => $password,
            ]
        );

        $tokenId = 'token-id';
        $revokeRefreshTokenRequest = new Request(
            [],
            [
                EncapsulatingRevokeRefreshTokenRequest::KEY_ID => $tokenId,
            ]
        );

        return [
            'resolve EncapsulatingCreateUserRequest' => [
                'request' => $createUserRequest,
                'argumentMetadata' => new ArgumentMetadata(
                    'name',
                    EncapsulatingCreateUserRequest::class,
                    false,
                    false,
                    null
                ),
                'expectedEncapsulatingRequest' => new EncapsulatingCreateUserRequest($email, $password),
            ],
            'resolve EncapsulatingRevokeRefreshTokenRequest' => [
                'request' => $revokeRefreshTokenRequest,
                'argumentMetadata' => new ArgumentMetadata(
                    'name',
                    EncapsulatingRevokeRefreshTokenRequest::class,
                    false,
                    false,
                    null
                ),
                'expectedEncapsulatingRequest' => new EncapsulatingRevokeRefreshTokenRequest($tokenId),
            ],
        ];
    }

    abstract protected function createResolver(): Resolver;
}
