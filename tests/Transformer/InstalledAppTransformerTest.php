<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledApp;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledApp::class)]
#[CoversClass(InstalledAppTransformer::class)]
final class InstalledAppTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id',
            InstalledAppTransformerInterface::KEY_APP_ID => 'test-app-id',
            InstalledAppTransformerInterface::KEY_DISPLAY_NAME => 'test-display-name',
            InstalledAppTransformerInterface::KEY_INSTALLED_APP_STATUS => 'AUTHORIZED',
            InstalledAppTransformerInterface::KEY_INSTALLED_APP_TYPE => 'WEBHOOK_SMART_APP',
            InstalledAppTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
        ];

        $transformer = new InstalledAppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-installed-app-id', $actual->getInstalledAppId());
        self::assertSame('test-app-id', $actual->getAppId());
        self::assertSame('test-display-name', $actual->getDisplayName());
        self::assertSame('AUTHORIZED', $actual->getInstalledAppStatus());
        self::assertSame('WEBHOOK_SMART_APP', $actual->getInstalledAppType());
        self::assertSame('test-location-id', $actual->getLocationId());
    }

    public function testTransformAllOptionalsAbsent(): void
    {
        $transformer = new InstalledAppTransformer();

        $actual = $transformer->transform([InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id']);

        self::assertSame('test-installed-app-id', $actual->getInstalledAppId());
        self::assertNull($actual->getAppId());
        self::assertNull($actual->getDisplayName());
        self::assertNull($actual->getInstalledAppStatus());
        self::assertNull($actual->getInstalledAppType());
        self::assertNull($actual->getLocationId());
    }

    /**
     * Each optional field is silently skipped when present but not a string.
     */
    #[DataProvider('provideTransformOptionalFieldWrongTypeCases')]
    public function testTransformOptionalFieldWrongType(string $key): void
    {
        $data = [
            InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id',
            $key => 42,
        ];

        $transformer = new InstalledAppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-installed-app-id', $actual->getInstalledAppId());
        self::assertNull($actual->getAppId());
        self::assertNull($actual->getDisplayName());
        self::assertNull($actual->getInstalledAppStatus());
        self::assertNull($actual->getInstalledAppType());
        self::assertNull($actual->getLocationId());
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideTransformOptionalFieldWrongTypeCases(): iterable
    {
        yield 'appId' => [InstalledAppTransformerInterface::KEY_APP_ID];
        yield 'displayName' => [InstalledAppTransformerInterface::KEY_DISPLAY_NAME];
        yield 'installedAppStatus' => [InstalledAppTransformerInterface::KEY_INSTALLED_APP_STATUS];
        yield 'installedAppType' => [InstalledAppTransformerInterface::KEY_INSTALLED_APP_TYPE];
        yield 'locationId' => [InstalledAppTransformerInterface::KEY_LOCATION_ID];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new InstalledAppTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledAppTransformerInterface::UNEXPECTED_STRING_SPRINTF, InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID));
        $transformer->transform($data);
    }
}
