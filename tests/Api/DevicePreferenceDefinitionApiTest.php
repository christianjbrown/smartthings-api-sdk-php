<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApi;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(DevicePreferenceDefinitionApi::class)]
#[CoversClass(Token::class)]
final class DevicePreferenceDefinitionApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DevicePreferenceDefinitionApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $definitions = [self::createStub(DevicePreferenceDefinitionInterface::class), self::createStub(DevicePreferenceDefinitionInterface::class)];

        $definitionsTransformer = self::createMock(DevicePreferenceDefinitionsTransformerInterface::class);
        $definitionsTransformer->expects(self::once())->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($definitions);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $definitionsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple();

        self::assertSame($definitions, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $definitions = [self::createStub(DevicePreferenceDefinitionInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $definitionsTransformer = self::createMock(DevicePreferenceDefinitionsTransformerInterface::class);
        $definitionsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($definitions);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $definitionsTransformer, new Token('test-api-token'));

        // Second call with the same filter is served from the cache without hitting the API.
        self::assertSame($definitions, $api->getMultiple());
        self::assertSame($definitions, $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleFiltersByNamespace(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DevicePreferenceDefinitionApiInterface::API_URL,
                [DevicePreferenceDefinitionApiInterface::KEY_NAMESPACE => 'test-namespace'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $definitions = [self::createStub(DevicePreferenceDefinitionInterface::class)];

        $definitionsTransformer = self::createMock(DevicePreferenceDefinitionsTransformerInterface::class);
        $definitionsTransformer->expects(self::once())->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($definitions);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $definitionsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple('test-namespace');

        self::assertSame($definitions, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $definitions = [self::createStub(DevicePreferenceDefinitionInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $definitionsTransformer = self::createMock(DevicePreferenceDefinitionsTransformerInterface::class);
        $definitionsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($definitions);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $definitionsTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($definitions, $api->getMultiple());
        self::assertSame($definitions, $api->getMultiple(null, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DevicePreferenceDefinitionApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DevicePreferenceDefinitionApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DevicePreferenceDefinitionApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DevicePreferenceDefinitionApiInterface::KEY_ITEMS));
        $api->getMultiple(null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-definition-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_SPRINTF, 'test-preference-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $definitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getOneById('test-preference-id');

        self::assertSame($definition, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-definition-data'];

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $definitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($definition, $api->getOneById('test-preference-id'));
        self::assertSame($definition, $api->getOneById('test-preference-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../devicepreferences'])]
    public function testGetOneByIdEncodesId(string $preferenceId): void
    {
        $data = ['test-definition-data'];

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_SPRINTF, rawurlencode($preferenceId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $definitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getOneById($preferenceId);

        self::assertSame($definition, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-definition-data'];

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $definitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($definition, $api->getOneById('test-preference-id'));
        self::assertSame($definition, $api->getOneById('test-preference-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByIdUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneById('test-preference-id', $skipCache);
    }
}
