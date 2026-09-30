<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApi;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\ModeInterface;
use ChristianBrown\SmartThings\Transformer\ModesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ModeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LocationModeApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class LocationModeApiHeaderTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateModeSendsLanguage(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')->willReturn('test-location');
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(sprintf(LocationModeApiInterface::API_URL_LIST_SPRINTF, 'test-location'), [], $this->headers() + [ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], [LocationModeApiInterface::KEY_LABEL => 'Away'])
            ->willReturn(['test-data']);
        $mode = self::createStub(ModeInterface::class);
        $transformer = self::createStub(ModeTransformerInterface::class);
        $transformer->method('transform')->willReturn($mode);
        $api = $this->api($requestSender, modeTransformer: $transformer);

        self::assertSame($mode, $api->createMode($location, 'Away', 'fr-FR'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCurrentSendsLanguageAndCachesPerVariant(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')->willReturn('test-location');
        $url = sprintf(LocationModeApiInterface::API_URL_CURRENT_SPRINTF, 'test-location');
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [$url, [], $this->headers(), ['plain']],
                [$url, [], $this->headers() + [ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], ['variant']],
            ]);
        $plain = self::createStub(ModeInterface::class);
        $variant = self::createStub(ModeInterface::class);
        $transformer = self::createStub(ModeTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, modeTransformer: $transformer);

        self::assertSame($plain, $api->getCurrent($location));
        self::assertSame($variant, $api->getCurrent($location, false, 'fr-FR'));
        self::assertSame($plain, $api->getCurrent($location));
        self::assertSame($variant, $api->getCurrent($location, false, 'fr-FR'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSendsLanguageAndCachesPerVariant(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')->willReturn('test-location');
        $url = sprintf(LocationModeApiInterface::API_URL_LIST_SPRINTF, 'test-location');
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [$url, [], $this->headers(), [LocationModeApiInterface::KEY_ITEMS => ['plain']]],
                [$url, [], $this->headers() + [ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], [LocationModeApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(ModeInterface::class)];
        $variant = [self::createStub(ModeInterface::class)];
        $transformer = self::createStub(ModesTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, modesTransformer: $transformer);

        self::assertSame($plain, $api->getMultiple($location));
        self::assertSame($variant, $api->getMultiple($location, false, 'fr-FR'));
        self::assertSame($plain, $api->getMultiple($location));
        self::assertSame($variant, $api->getMultiple($location, false, 'fr-FR'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneSendsLanguageAndCachesPerVariant(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')->willReturn('test-location');
        $url = sprintf(LocationModeApiInterface::API_URL_SPRINTF, 'test-location', 'test-mode');
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [$url, [], $this->headers(), ['plain']],
                [$url, [], $this->headers() + [ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], ['variant']],
            ]);
        $plain = self::createStub(ModeInterface::class);
        $variant = self::createStub(ModeInterface::class);
        $transformer = self::createStub(ModeTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, modeTransformer: $transformer);

        self::assertSame($plain, $api->getOneByLocationAndId($location, 'test-mode'));
        self::assertSame($variant, $api->getOneByLocationAndId($location, 'test-mode', false, 'fr-FR'));
        self::assertSame($plain, $api->getOneByLocationAndId($location, 'test-mode'));
        self::assertSame($variant, $api->getOneByLocationAndId($location, 'test-mode', false, 'fr-FR'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateModeSendsLanguage(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')->willReturn('test-location');
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(sprintf(LocationModeApiInterface::API_URL_SPRINTF, 'test-location', 'test-mode'), [], $this->headers() + [ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], [LocationModeApiInterface::KEY_LABEL => 'Away'])
            ->willReturn(['test-data']);
        $mode = self::createStub(ModeInterface::class);
        $transformer = self::createStub(ModeTransformerInterface::class);
        $transformer->method('transform')->willReturn($mode);
        $api = $this->api($requestSender, modeTransformer: $transformer);

        self::assertSame($mode, $api->updateMode($location, 'test-mode', 'Away', 'fr-FR'));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?ModeTransformerInterface $modeTransformer = null, ?ModesTransformerInterface $modesTransformer = null): LocationModeApi
    {
        return new LocationModeApi($requestSender, $modeTransformer ?? self::createStub(ModeTransformerInterface::class), $modesTransformer ?? self::createStub(ModesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
