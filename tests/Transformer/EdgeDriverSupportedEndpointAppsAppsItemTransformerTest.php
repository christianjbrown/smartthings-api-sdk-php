<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsAppsItem;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsAppsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(EdgeDriverSupportedEndpointAppsAppsItem::class)]
#[CoversClass(EdgeDriverSupportedEndpointAppsAppsItemTransformer::class)]
final class EdgeDriverSupportedEndpointAppsAppsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME => 'test-app-name',
            EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION => 'test-version',
        ];

        $transformer = new EdgeDriverSupportedEndpointAppsAppsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-app-name', $actual->getAppName());
        self::assertSame('test-version', $actual->getVersion());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new EdgeDriverSupportedEndpointAppsAppsItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'appNameAbsent' => [[EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION => 'test-version'], sprintf(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME)];
        yield 'appNameWrongType' => [[EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION => 'test-version', EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME => 42], sprintf(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME)];
        yield 'versionAbsent' => [[EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME => 'test-app-name'], sprintf(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION)];
        yield 'versionWrongType' => [[EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME => 'test-app-name', EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION => 42], sprintf(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION)];
    }
}
