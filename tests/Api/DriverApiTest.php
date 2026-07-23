<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DriverApi;
use ChristianBrown\SmartThings\Api\DriverApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DriverInterface;
use ChristianBrown\SmartThings\Transformer\DriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(DriverApi::class)]
#[CoversClass(Token::class)]
final class DriverApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDefaults(): void
    {
        $data = [
            DriverApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DriverApiInterface::API_URL_DEFAULT,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $drivers = [self::createStub(DriverInterface::class)];

        $driversTransformer = self::createMock(DriversTransformerInterface::class);
        $driversTransformer->expects(self::once())->method('transform')
            ->with($data[DriverApiInterface::KEY_ITEMS])
            ->willReturn($drivers);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), $driversTransformer, new Token('test-api-token'));

        self::assertSame($drivers, $api->getDefaults());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDefaultsCaches(): void
    {
        $drivers = [self::createStub(DriverInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([DriverApiInterface::KEY_ITEMS => ['test-item-1']]);

        $driversTransformer = self::createMock(DriversTransformerInterface::class);
        $driversTransformer->expects(self::once())->method('transform')->willReturn($drivers);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), $driversTransformer, new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($drivers, $api->getDefaults());
        self::assertSame($drivers, $api->getDefaults());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDefaultsSkipsCache(): void
    {
        $drivers = [self::createStub(DriverInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([DriverApiInterface::KEY_ITEMS => ['test-item-1']]);

        $driversTransformer = self::createMock(DriversTransformerInterface::class);
        $driversTransformer->expects(self::exactly(2))->method('transform')->willReturn($drivers);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), $driversTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($drivers, $api->getDefaults());
        self::assertSame($drivers, $api->getDefaults(true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            DriverApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DriverApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $drivers = [self::createStub(DriverInterface::class), self::createStub(DriverInterface::class)];

        $driversTransformer = self::createMock(DriversTransformerInterface::class);
        $driversTransformer->expects(self::once())->method('transform')
            ->with($data[DriverApiInterface::KEY_ITEMS])
            ->willReturn($drivers);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), $driversTransformer, new Token('test-api-token'));

        self::assertSame($drivers, $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $drivers = [self::createStub(DriverInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([DriverApiInterface::KEY_ITEMS => ['test-item-1']]);

        $driversTransformer = self::createMock(DriversTransformerInterface::class);
        $driversTransformer->expects(self::once())->method('transform')->willReturn($drivers);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), $driversTransformer, new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($drivers, $api->getMultiple());
        self::assertSame($drivers, $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $drivers = [self::createStub(DriverInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([DriverApiInterface::KEY_ITEMS => ['test-item-1']]);

        $driversTransformer = self::createMock(DriversTransformerInterface::class);
        $driversTransformer->expects(self::exactly(2))->method('transform')->willReturn($drivers);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), $driversTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($drivers, $api->getMultiple());
        self::assertSame($drivers, $api->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DriverApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DriverApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($data);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DriverApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DriverApiInterface::KEY_ITEMS));
        $api->getMultiple($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-driver-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DriverApiInterface::API_URL_SPRINTF, 'test-driver-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $driver = self::createStub(DriverInterface::class);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($driver);

        $api = new DriverApi($requestSender, $driverTransformer, self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        self::assertSame($driver, $api->getOneById('test-driver-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersion(): void
    {
        $data = ['test-driver-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DriverApiInterface::API_URL_VERSION_SPRINTF, 'test-driver-id', 'test-version'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $driver = self::createStub(DriverInterface::class);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($driver);

        $api = new DriverApi($requestSender, $driverTransformer, self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        self::assertSame($driver, $api->getOneByIdAndVersion('test-driver-id', 'test-version'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersionCaches(): void
    {
        $driver = self::createStub(DriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-driver-data']);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')->willReturn($driver);

        $api = new DriverApi($requestSender, $driverTransformer, self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same id and version is served from the cache without hitting the API.
        self::assertSame($driver, $api->getOneByIdAndVersion('test-driver-id', 'test-version'));
        self::assertSame($driver, $api->getOneByIdAndVersion('test-driver-id', 'test-version'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 'x/y z'])]
    #[TestWith(['../../drivers', '../../versions'])]
    public function testGetOneByIdAndVersionEncodesIds(string $driverId, string $version): void
    {
        $data = ['test-driver-data'];

        $driver = self::createStub(DriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DriverApiInterface::API_URL_VERSION_SPRINTF, rawurlencode($driverId), rawurlencode($version)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($driver);

        $api = new DriverApi($requestSender, $driverTransformer, self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        self::assertSame($driver, $api->getOneByIdAndVersion($driverId, $version));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersionSkipsCache(): void
    {
        $driver = self::createStub(DriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-driver-data']);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::exactly(2))->method('transform')->willReturn($driver);

        $api = new DriverApi($requestSender, $driverTransformer, self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($driver, $api->getOneByIdAndVersion('test-driver-id', 'test-version'));
        self::assertSame($driver, $api->getOneByIdAndVersion('test-driver-id', 'test-version', true));
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
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DriverApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneByIdAndVersion('test-driver-id', 'test-version', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $driver = self::createStub(DriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-driver-data']);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')->willReturn($driver);

        $api = new DriverApi($requestSender, $driverTransformer, self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($driver, $api->getOneById('test-driver-id'));
        self::assertSame($driver, $api->getOneById('test-driver-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../drivers'])]
    public function testGetOneByIdEncodesId(string $driverId): void
    {
        $data = ['test-driver-data'];

        $driver = self::createStub(DriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DriverApiInterface::API_URL_SPRINTF, rawurlencode($driverId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($driver);

        $api = new DriverApi($requestSender, $driverTransformer, self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        self::assertSame($driver, $api->getOneById($driverId));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $driver = self::createStub(DriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-driver-data']);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::exactly(2))->method('transform')->willReturn($driver);

        $api = new DriverApi($requestSender, $driverTransformer, self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($driver, $api->getOneById('test-driver-id'));
        self::assertSame($driver, $api->getOneById('test-driver-id', true));
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
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new DriverApi($requestSender, self::createStub(DriverTransformerInterface::class), self::createStub(DriversTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DriverApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneById('test-driver-id', $skipCache);
    }
}
