<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\App;
use ChristianBrown\SmartThings\Transformer\AppTransformer;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(App::class)]
#[CoversClass(AppTransformer::class)]
final class AppTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AppTransformerInterface::KEY_APP_ID => 'test-app-id',
            AppTransformerInterface::KEY_APP_NAME => 'test-app-name',
            AppTransformerInterface::KEY_APP_TYPE => 'WEBHOOK_SMART_APP',
            AppTransformerInterface::KEY_DISPLAY_NAME => 'test-display-name',
        ];

        $transformer = new AppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-app-id', $actual->getAppId());
        self::assertSame('test-app-name', $actual->getAppName());
        self::assertSame('WEBHOOK_SMART_APP', $actual->getAppType());
        self::assertSame('test-display-name', $actual->getDisplayName());
    }

    /**
     * Exercises the optional appName, appType, and displayName fields in each of
     * their three states: absent, present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedAppName, ?string $expectedAppType, ?string $expectedDisplayName): void
    {
        $transformer = new AppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-app-id', $actual->getAppId());
        self::assertSame($expectedAppName, $actual->getAppName());
        self::assertSame($expectedAppType, $actual->getAppType());
        self::assertSame($expectedDisplayName, $actual->getDisplayName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $states = [
            'Absent' => [null, null],
            'WrongType' => [42, null],
            'Valid' => ['test-value', 'test-value'],
        ];

        foreach ($states as $appNameName => [$appNameValue, $expectedAppName]) {
            foreach ($states as $appTypeName => [$appTypeValue, $expectedAppType]) {
                foreach ($states as $displayNameName => [$displayNameValue, $expectedDisplayName]) {
                    $data = [AppTransformerInterface::KEY_APP_ID => 'test-app-id'];
                    if (null !== $appNameValue) {
                        $data[AppTransformerInterface::KEY_APP_NAME] = $appNameValue;
                    }
                    if (null !== $appTypeValue) {
                        $data[AppTransformerInterface::KEY_APP_TYPE] = $appTypeValue;
                    }
                    if (null !== $displayNameValue) {
                        $data[AppTransformerInterface::KEY_DISPLAY_NAME] = $displayNameValue;
                    }

                    yield sprintf('appName%s, appType%s, displayName%s', $appNameName, $appTypeName, $displayNameName) => [$data, $expectedAppName, $expectedAppType, $expectedDisplayName];
                }
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[AppTransformerInterface::KEY_APP_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new AppTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AppTransformerInterface::UNEXPECTED_STRING_SPRINTF, AppTransformerInterface::KEY_APP_ID));
        $transformer->transform($data);
    }
}
