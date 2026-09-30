<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApi;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityStatusInterface;
use ChristianBrown\SmartThings\Model\ComponentStatusInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusReportInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityStatusTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ComponentStatusTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusReportTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceStatusApi::class)]
#[CoversClass(Token::class)]
final class DeviceStatusApiReportTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('provideAnEmptyResponseIsRejectedCases')]
    public function testAnEmptyResponseIsRejected(callable $call): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceStatusApiInterface::UNEXPECTED_RESPONSE);

        $call($this->api($requestSender));
    }

    /**
     * @return iterable<string, array{callable(DeviceStatusApiInterface): mixed}>
     */
    public static function provideAnEmptyResponseIsRejectedCases(): iterable
    {
        yield 'device' => [static fn (DeviceStatusApiInterface $api): DeviceStatusReportInterface => $api->getReportById('test-device')];
        yield 'component' => [static fn (DeviceStatusApiInterface $api): ComponentStatusInterface => $api->getComponentReport('test-device', 'main')];
        yield 'capability' => [static fn (DeviceStatusApiInterface $api): CapabilityStatusInterface => $api->getCapabilityReport('test-device', 'main', 'switch')];
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCapabilityReportCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(sprintf(DeviceStatusApiInterface::API_URL_CAPABILITY_SPRINTF, 'test-device', 'main', 'switch'), [], $this->headers())
            ->willReturn(['switch' => ['value' => 'on']]);
        $report = self::createStub(CapabilityStatusInterface::class);
        $transformer = self::createMock(CapabilityStatusTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with(['switch' => ['value' => 'on']])->willReturn($report);
        $api = $this->api($requestSender, capabilityStatusTransformer: $transformer);

        self::assertSame($report, $api->getCapabilityReport('test-device', 'main', 'switch'));
        self::assertSame($report, $api->getCapabilityReport('test-device', 'main', 'switch'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCapabilityReportSkipsTheCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['switch' => ['value' => 'on']]);
        $transformer = self::createStub(CapabilityStatusTransformerInterface::class);
        $transformer->method('transform')->willReturn(self::createStub(CapabilityStatusInterface::class));
        $api = $this->api($requestSender, capabilityStatusTransformer: $transformer);

        $api->getCapabilityReport('test-device', 'main', 'switch');
        $api->getCapabilityReport('test-device', 'main', 'switch', true);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetComponentReportCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(sprintf(DeviceStatusApiInterface::API_URL_COMPONENT_SPRINTF, 'test-device', 'main'), [], $this->headers())
            ->willReturn(['switch' => []]);
        $report = self::createStub(ComponentStatusInterface::class);
        $transformer = self::createMock(ComponentStatusTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with(['switch' => []])->willReturn($report);
        $api = $this->api($requestSender, componentStatusTransformer: $transformer);

        self::assertSame($report, $api->getComponentReport('test-device', 'main'));
        self::assertSame($report, $api->getComponentReport('test-device', 'main'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetComponentReportSkipsTheCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['switch' => []]);
        $transformer = self::createStub(ComponentStatusTransformerInterface::class);
        $transformer->method('transform')->willReturn(self::createStub(ComponentStatusInterface::class));
        $api = $this->api($requestSender, componentStatusTransformer: $transformer);

        $api->getComponentReport('test-device', 'main');
        $api->getComponentReport('test-device', 'main', true);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetReportByIdCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(sprintf(DeviceStatusApiInterface::API_URL_SPRINTF, 'test-device'), [], $this->headers())
            ->willReturn(['components' => []]);
        $report = self::createStub(DeviceStatusReportInterface::class);
        $transformer = self::createMock(DeviceStatusReportTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with(['components' => []])->willReturn($report);
        $api = $this->api($requestSender, deviceStatusReportTransformer: $transformer);

        self::assertSame($report, $api->getReportById('test-device'));
        self::assertSame($report, $api->getReportById('test-device'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetReportByIdSkipsTheCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['components' => []]);
        $transformer = self::createStub(DeviceStatusReportTransformerInterface::class);
        $transformer->method('transform')->willReturn(self::createStub(DeviceStatusReportInterface::class));
        $api = $this->api($requestSender, deviceStatusReportTransformer: $transformer);

        $api->getReportById('test-device');
        $api->getReportById('test-device', true);
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?DeviceStatusReportTransformerInterface $deviceStatusReportTransformer = null, ?ComponentStatusTransformerInterface $componentStatusTransformer = null, ?CapabilityStatusTransformerInterface $capabilityStatusTransformer = null): DeviceStatusApi
    {
        return new DeviceStatusApi($requestSender, self::createStub(DeviceStatusTransformerInterface::class), new Token('test-api-token'), $deviceStatusReportTransformer ?? self::createStub(DeviceStatusReportTransformerInterface::class), $componentStatusTransformer ?? self::createStub(ComponentStatusTransformerInterface::class), $capabilityStatusTransformer ?? self::createStub(CapabilityStatusTransformerInterface::class));
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
