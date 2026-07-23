<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\CapabilityApi;
use ChristianBrown\SmartThings\Api\CapabilityApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityInterface;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(CapabilityApi::class)]
#[CoversClass(Token::class)]
final class CapabilityApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                CapabilityApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilities = [self::createStub(CapabilityInterface::class), self::createStub(CapabilityInterface::class)];

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));
        $actual = $capabilityApi->getMultiple();

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleByNamespace(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_NAMESPACE_SPRINTF, 'test-namespace'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));
        $actual = $capabilityApi->getMultipleByNamespace('test-namespace');

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleByNamespaceCaches(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        // Second call for the same namespace is served from the cache without hitting the API.
        self::assertSame($capabilities, $capabilityApi->getMultipleByNamespace('test-namespace'));
        self::assertSame($capabilities, $capabilityApi->getMultipleByNamespace('test-namespace'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../capabilities'])]
    public function testGetMultipleByNamespaceEncodesNamespace(string $namespace): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_NAMESPACE_SPRINTF, rawurlencode($namespace)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));
        $actual = $capabilityApi->getMultipleByNamespace($namespace);

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleByNamespaceSkipsCache(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capabilities, $capabilityApi->getMultipleByNamespace('test-namespace'));
        self::assertSame($capabilities, $capabilityApi->getMultipleByNamespace('test-namespace', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleByNamespaceUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CapabilityApiInterface::KEY_ITEMS));
        $capabilityApi->getMultipleByNamespace('test-namespace', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($capabilities, $capabilityApi->getMultiple());
        self::assertSame($capabilities, $capabilityApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capabilities, $capabilityApi->getMultiple());
        self::assertSame($capabilities, $capabilityApi->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                CapabilityApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CapabilityApiInterface::KEY_ITEMS));
        $capabilityApi->getMultiple($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersion(): void
    {
        $data = ['test-capability-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, 'test-capability-id', 1),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capability = self::createStub(CapabilityInterface::class);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($capability);

        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));
        $actual = $capabilityApi->getOneByIdAndVersion('test-capability-id', 1);

        self::assertSame($capability, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersionCaches(): void
    {
        $data = ['test-capability-data'];

        $capability = self::createStub(CapabilityInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($capability);

        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        // Second call for the same id/version is served from the cache without hitting the API.
        self::assertSame($capability, $capabilityApi->getOneByIdAndVersion('test-capability-id', 1));
        self::assertSame($capability, $capabilityApi->getOneByIdAndVersion('test-capability-id', 1));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 2])]
    #[TestWith(['../../capabilities', 3])]
    public function testGetOneByIdAndVersionEncodesId(string $capabilityId, int $version): void
    {
        $data = ['test-capability-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, rawurlencode($capabilityId), $version),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capability = self::createStub(CapabilityInterface::class);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($capability);

        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));
        $actual = $capabilityApi->getOneByIdAndVersion($capabilityId, $version);

        self::assertSame($capability, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersionSkipsCache(): void
    {
        $data = ['test-capability-data'];

        $capability = self::createStub(CapabilityInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($capability);

        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capability, $capabilityApi->getOneByIdAndVersion('test-capability-id', 1));
        self::assertSame($capability, $capabilityApi->getOneByIdAndVersion('test-capability-id', 1, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByIdAndVersionUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, 'test-capability-id', 1),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $capabilityApi->getOneByIdAndVersion('test-capability-id', 1, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetVersions(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_VERSIONS_SPRINTF, 'test-capability-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));
        $actual = $capabilityApi->getVersions('test-capability-id');

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetVersionsCaches(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        // Second call for the same capability id is served from the cache without hitting the API.
        self::assertSame($capabilities, $capabilityApi->getVersions('test-capability-id'));
        self::assertSame($capabilities, $capabilityApi->getVersions('test-capability-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../capabilities'])]
    public function testGetVersionsEncodesId(string $capabilityId): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_VERSIONS_SPRINTF, rawurlencode($capabilityId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));
        $actual = $capabilityApi->getVersions($capabilityId);

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetVersionsSkipsCache(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capabilities, $capabilityApi->getVersions('test-capability-id'));
        self::assertSame($capabilities, $capabilityApi->getVersions('test-capability-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetVersionsUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CapabilityApiInterface::KEY_ITEMS));
        $capabilityApi->getVersions('test-capability-id', $skipCache);
    }
}
