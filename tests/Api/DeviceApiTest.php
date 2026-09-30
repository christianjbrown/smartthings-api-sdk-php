<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCommand;
use ChristianBrown\SmartThings\Model\DeviceCommandResult;
use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;
use ChristianBrown\SmartThings\Model\DeviceEvent;
use ChristianBrown\SmartThings\Model\DeviceInstallApp;
use ChristianBrown\SmartThings\Model\DeviceInstallRequest;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DeviceListQuery;
use ChristianBrown\SmartThings\Model\UpdateDeviceRequest;
use ChristianBrown\SmartThings\Serializer\DeviceCommandSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceEventSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceEventSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceInstallRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceInstallRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(DeviceApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(DeviceCommand::class)]
#[CoversClass(DeviceCommandResult::class)]
#[CoversClass(DeviceCommandResultsTransformer::class)]
#[CoversClass(DeviceCommandResultTransformer::class)]
#[CoversClass(DeviceCommandSerializer::class)]
#[CoversClass(DeviceEvent::class)]
#[CoversClass(DeviceEventSerializer::class)]
#[CoversClass(DeviceInstallApp::class)]
#[CoversClass(DeviceInstallRequest::class)]
#[CoversClass(DeviceInstallRequestSerializer::class)]
#[CoversClass(DeviceListQuery::class)]
#[CoversClass(Token::class)]
#[CoversClass(UpdateDeviceRequest::class)]
#[CoversClass(UpdateDeviceRequestSerializer::class)]
final class DeviceApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateEvents(): void
    {
        $event = new DeviceEvent('active');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(DeviceApiInterface::API_URL_EVENTS_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [DeviceApiInterface::KEY_DEVICE_EVENTS => [['test-serialized-event']]]
            )
            ->willReturn([]);

        $deviceEventSerializer = self::createMock(DeviceEventSerializerInterface::class);
        $deviceEventSerializer->expects(self::once())->method('serialize')
            ->with([$event])
            ->willReturn([['test-serialized-event']]);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), $deviceEventSerializer, new RequestUrlBuilder());
        $deviceApi->createEvents('test-device-id', [$event]);

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateEventsDefaultsCollaborator(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $deviceApi->createEvents('test-device-id', [new DeviceEvent('active')]);

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteDevice(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $deviceApi->deleteDevice('test-device-id');

        $this->addToAssertionCount(1);
    }

    /**
     * deleteDevice() invalidates the cached copy of this device, so a subsequent
     * getOneById() call hits the API again instead of returning a stale device.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteDeviceInvalidatesCache(): void
    {
        $device = self::createStub(DeviceInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-device-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $deviceTransformer->method('transform')
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        $deviceApi->getOneById('test-device-id');
        $deviceApi->deleteDevice('test-device-id');
        $deviceApi->getOneById('test-device-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testExecuteCommands(): void
    {
        $data = [DeviceApiInterface::KEY_RESULTS => [['test-result']]];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(DeviceApiInterface::API_URL_COMMANDS_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [DeviceApiInterface::KEY_COMMANDS => [['test-serialized-command']]]
            )
            ->willReturn($data);

        $command = new DeviceCommand('switch', 'on');

        $deviceCommandSerializer = self::createMock(DeviceCommandSerializerInterface::class);
        $deviceCommandSerializer->expects(self::once())->method('serialize')
            ->with([$command])
            ->willReturn([['test-serialized-command']]);

        $results = [self::createStub(DeviceCommandResultInterface::class)];

        $deviceCommandResultsTransformer = self::createMock(DeviceCommandResultsTransformerInterface::class);
        $deviceCommandResultsTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceApiInterface::KEY_RESULTS])
            ->willReturn($results);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), $deviceCommandSerializer, $deviceCommandResultsTransformer, self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $actual = $deviceApi->executeCommands('test-device-id', [$command]);

        self::assertSame($results, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testExecuteCommandsEncodesIdWithRealCollaborators(): void
    {
        $data = [DeviceApiInterface::KEY_RESULTS => [[DeviceCommandResultTransformerInterface::KEY_STATUS => 'ACCEPTED']]];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(DeviceApiInterface::API_URL_COMMANDS_SPRINTF, rawurlencode('a/b c')),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [DeviceApiInterface::KEY_COMMANDS => [[DeviceCommandSerializerInterface::KEY_CAPABILITY => 'switch', DeviceCommandSerializerInterface::KEY_COMMAND => 'on']]]
            )
            ->willReturn($data);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        // The real serializer and results transformer, so the encoded body and the parsed results are checked.
        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), new DeviceCommandSerializer(), new DeviceCommandResultsTransformer(new DeviceCommandResultTransformer()), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $actual = $deviceApi->executeCommands('a/b c', [new DeviceCommand('switch', 'on')]);

        self::assertSame('ACCEPTED', $actual[0]->getStatus());
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-results-key-missing' => true]])]
    #[TestWith([[DeviceApiInterface::KEY_RESULTS => 'test-not-array']])]
    public function testExecuteCommandsUnexpectedResponse(array $data): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('post')->willReturn($data);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DeviceApiInterface::KEY_RESULTS));
        $deviceApi->executeCommands('test-device-id', []);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([true, 'true'])]
    #[TestWith([false, 'false'])]
    public function testExecuteCommandsWithOrdered(bool $ordered, string $expectedQueryValue): void
    {
        $data = [DeviceApiInterface::KEY_RESULTS => []];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(DeviceApiInterface::API_URL_COMMANDS_SPRINTF, 'test-device-id'),
                [DeviceApiInterface::KEY_ORDERED => $expectedQueryValue],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [DeviceApiInterface::KEY_COMMANDS => []]
            )
            ->willReturn($data);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);
        $deviceCommandResultsTransformer = self::createStub(DeviceCommandResultsTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), new DeviceCommandSerializer(), $deviceCommandResultsTransformer, self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $deviceApi->executeCommands('test-device-id', [], $ordered);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class), self::createStub(DeviceInterface::class)];

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $actual = $deviceApi->getMultiple();

        self::assertSame($devices, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleAppliesTheQuery(): void
    {
        $data = [DeviceApiInterface::KEY_ITEMS => ['test-item-1']];
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceApiInterface::API_URL.'?capabilitiesMode=or&capability=switch&capability=lock&includeStatus=true&locationId=explicit-location',
                [],
                [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')]
            )
            ->willReturn($data);
        $devices = [self::createStub(DeviceInterface::class)];
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);
        $devicesTransformer->method('transform')->willReturn($devices);

        $query = (new DeviceListQuery())->setCapabilities(['switch', 'lock'])->setCapabilitiesMode('or')->setIncludeStatus(true)->setLocationIds(['query-location']);
        $deviceApi = new DeviceApi($requestSender, self::createStub(DeviceTransformerInterface::class), $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        self::assertSame($devices, $deviceApi->getMultiple('explicit-location', false, $query));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        // Second call is served from the cache without hitting the API.
        self::assertSame($devices, $deviceApi->getMultiple());
        self::assertSame($devices, $deviceApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCachesPerLocation(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $devices = [self::createStub(DeviceInterface::class)];

        // A distinct locationId is a distinct cache key, so it hits the API again.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        self::assertSame($devices, $deviceApi->getMultiple('test-location-a'));
        self::assertSame($devices, $deviceApi->getMultiple('test-location-b'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleFiltersByLocation(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceApiInterface::API_URL.'?locationId=test-location-id',
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class), self::createStub(DeviceInterface::class)];

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $actual = $deviceApi->getMultiple('test-location-id');

        self::assertSame($devices, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($devices, $deviceApi->getMultiple());
        self::assertSame($devices, $deviceApi->getMultiple(null, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DeviceApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DeviceApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DeviceApiInterface::KEY_ITEMS));
        $deviceApi->getMultiple(null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-device-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $device = self::createStub(DeviceInterface::class);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $actual = $deviceApi->getOneById('test-device-id');

        self::assertSame($device, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-device-data'];

        $device = self::createStub(DeviceInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        // Second call for the same deviceId is served from the cache without hitting the API.
        self::assertSame($device, $deviceApi->getOneById('test-device-id'));
        self::assertSame($device, $deviceApi->getOneById('test-device-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../devices'])]
    public function testGetOneByIdEncodesId(string $deviceId): void
    {
        $data = ['test-device-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, rawurlencode($deviceId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $device = self::createStub(DeviceInterface::class);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $actual = $deviceApi->getOneById($deviceId);

        self::assertSame($device, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSendsIncludeStatusAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'), [], [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')], ['plain']],
                [sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id').'?includeStatus=true', [], [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')], ['variant']],
            ]);
        $plain = self::createStub(DeviceInterface::class);
        $variant = self::createStub(DeviceInterface::class);
        $transformer = self::createStub(DeviceTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $deviceApi = new DeviceApi($requestSender, $transformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        self::assertSame($plain, $deviceApi->getOneById('test-device-id'));
        self::assertSame($variant, $deviceApi->getOneById('test-device-id', false, true));
        self::assertSame($plain, $deviceApi->getOneById('test-device-id'));
        self::assertSame($variant, $deviceApi->getOneById('test-device-id', false, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-device-data'];

        $device = self::createStub(DeviceInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($device, $deviceApi->getOneById('test-device-id'));
        self::assertSame($device, $deviceApi->getOneById('test-device-id', true));
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
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceApiInterface::UNEXPECTED_RESPONSE);
        $deviceApi->getOneById('test-device-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testInstallDevice(): void
    {
        $data = ['test-device-data'];

        $request = new DeviceInstallRequest('test-location-id', new DeviceInstallApp('test-profile-id', 'test-installed-app-id'));

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                DeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $deviceInstallRequestSerializer = self::createMock(DeviceInstallRequestSerializerInterface::class);
        $deviceInstallRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), $deviceInstallRequestSerializer, self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $actual = $deviceApi->installDevice($request);

        self::assertSame($device, $actual);
    }

    /**
     * installDevice() populates the device cache, so a subsequent getOneById() for
     * the installed device is served from it without hitting the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testInstallDevicePopulatesCache(): void
    {
        $request = new DeviceInstallRequest('test-location-id', new DeviceInstallApp('test-profile-id', 'test-installed-app-id'));

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('post')
            ->willReturn(['test-device-data']);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())
            ->method('transform')
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        self::assertSame($device, $deviceApi->installDevice($request));
        self::assertSame($device, $deviceApi->getOneById('test-device-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testInstallDeviceUnexpectedResponse(): void
    {
        $request = new DeviceInstallRequest('test-location-id', new DeviceInstallApp('test-profile-id', 'test-installed-app-id'));

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceApiInterface::UNEXPECTED_RESPONSE);
        $deviceApi->installDevice($request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateDevice(): void
    {
        $data = ['test-device-data'];

        $request = (new UpdateDeviceRequest())->setLabel('test-label');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $updateDeviceRequestSerializer = self::createMock(UpdateDeviceRequestSerializerInterface::class);
        $updateDeviceRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $device = self::createStub(DeviceInterface::class);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), $updateDeviceRequestSerializer, self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());
        $actual = $deviceApi->updateDevice('test-device-id', $request);

        self::assertSame($device, $actual);
    }

    /**
     * updateDevice() refreshes the cached copy of this device, so a subsequent
     * getOneById() for the same id is served from it.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateDevicePopulatesCache(): void
    {
        $request = (new UpdateDeviceRequest())->setLabel('test-label');

        $device = self::createStub(DeviceInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->willReturn(['test-device-data']);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())
            ->method('transform')
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        self::assertSame($device, $deviceApi->updateDevice('test-device-id', $request));
        self::assertSame($device, $deviceApi->getOneById('test-device-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateDeviceUnexpectedResponse(): void
    {
        $request = new UpdateDeviceRequest();

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'), self::createStub(DeviceCommandSerializerInterface::class), self::createStub(DeviceCommandResultsTransformerInterface::class), self::createStub(DeviceInstallRequestSerializerInterface::class), self::createStub(UpdateDeviceRequestSerializerInterface::class), self::createStub(DeviceEventSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceApiInterface::UNEXPECTED_RESPONSE);
        $deviceApi->updateDevice('test-device-id', $request);
    }
}
