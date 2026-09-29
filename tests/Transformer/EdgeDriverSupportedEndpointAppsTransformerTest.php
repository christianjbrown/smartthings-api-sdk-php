<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointApps;
use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsAppsItemInterface;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(EdgeDriverSupportedEndpointApps::class)]
#[CoversClass(EdgeDriverSupportedEndpointAppsTransformer::class)]
final class EdgeDriverSupportedEndpointAppsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $edgeDriverSupportedEndpointAppsAppsItemModel = self::createStub(EdgeDriverSupportedEndpointAppsAppsItemInterface::class);
        $edgeDriverSupportedEndpointAppsAppsItemTransformer = self::createStub(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::class);
        $edgeDriverSupportedEndpointAppsAppsItemTransformer->method('transform')->willReturn($edgeDriverSupportedEndpointAppsAppsItemModel);
        $data = [
            EdgeDriverSupportedEndpointAppsTransformerInterface::KEY_APPS => [['test-nested']],
        ];

        $transformer = new EdgeDriverSupportedEndpointAppsTransformer($edgeDriverSupportedEndpointAppsAppsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$edgeDriverSupportedEndpointAppsAppsItemModel], $actual->getApps());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new EdgeDriverSupportedEndpointAppsTransformer(self::createStub(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'appsAbsent' => [[], sprintf(EdgeDriverSupportedEndpointAppsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, EdgeDriverSupportedEndpointAppsTransformerInterface::KEY_APPS)];
        yield 'appsWrongType' => [[EdgeDriverSupportedEndpointAppsTransformerInterface::KEY_APPS => 'not-array'], sprintf(EdgeDriverSupportedEndpointAppsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, EdgeDriverSupportedEndpointAppsTransformerInterface::KEY_APPS)];
    }
}
