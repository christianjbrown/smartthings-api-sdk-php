<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AppUiSettings;
use ChristianBrown\SmartThings\Transformer\AppUiSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AppUiSettingsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AppUiSettings::class)]
#[CoversClass(AppUiSettingsTransformer::class)]
final class AppUiSettingsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AppUiSettingsTransformerInterface::KEY_PLUGIN_ID => 'test-plugin-id',
            AppUiSettingsTransformerInterface::KEY_PLUGIN_URI => 'test-plugin-uri',
            AppUiSettingsTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true,
            AppUiSettingsTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true,
        ];

        $transformer = new AppUiSettingsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-plugin-id', $actual->getPluginId());
        self::assertSame('test-plugin-uri', $actual->getPluginUri());
        self::assertTrue($actual->getDashboardCardsEnabled());
        self::assertTrue($actual->getPreInstallDashboardCardsEnabled());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AppUiSettingsTransformer();

        $actual = $transformer->transform([AppUiSettingsTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true, AppUiSettingsTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'pluginIdAbsent' => [[], 'getPluginId', null];
        yield 'pluginIdWrongType' => [[AppUiSettingsTransformerInterface::KEY_PLUGIN_ID => 42], 'getPluginId', null];
        yield 'pluginIdValid' => [[AppUiSettingsTransformerInterface::KEY_PLUGIN_ID => 'test-plugin-id'], 'getPluginId', 'test-plugin-id'];
        yield 'pluginUriAbsent' => [[], 'getPluginUri', null];
        yield 'pluginUriWrongType' => [[AppUiSettingsTransformerInterface::KEY_PLUGIN_URI => 42], 'getPluginUri', null];
        yield 'pluginUriValid' => [[AppUiSettingsTransformerInterface::KEY_PLUGIN_URI => 'test-plugin-uri'], 'getPluginUri', 'test-plugin-uri'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new AppUiSettingsTransformer();

        $actual = $transformer->transform([AppUiSettingsTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true, AppUiSettingsTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true]);

        self::assertNull($actual->getPluginId());
        self::assertNull($actual->getPluginUri());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new AppUiSettingsTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'dashboardCardsEnabledAbsent' => [[AppUiSettingsTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true], sprintf(AppUiSettingsTransformerInterface::UNEXPECTED_BOOL_SPRINTF, AppUiSettingsTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED)];
        yield 'dashboardCardsEnabledWrongType' => [[AppUiSettingsTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true, AppUiSettingsTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => 'not-bool'], sprintf(AppUiSettingsTransformerInterface::UNEXPECTED_BOOL_SPRINTF, AppUiSettingsTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED)];
        yield 'preInstallDashboardCardsEnabledAbsent' => [[AppUiSettingsTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true], sprintf(AppUiSettingsTransformerInterface::UNEXPECTED_BOOL_SPRINTF, AppUiSettingsTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED)];
        yield 'preInstallDashboardCardsEnabledWrongType' => [[AppUiSettingsTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true, AppUiSettingsTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => 'not-bool'], sprintf(AppUiSettingsTransformerInterface::UNEXPECTED_BOOL_SPRINTF, AppUiSettingsTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED)];
    }
}
