<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppUi;
use ChristianBrown\SmartThings\Transformer\InstalledAppUiTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppUiTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledAppUi::class)]
#[CoversClass(InstalledAppUiTransformer::class)]
final class InstalledAppUiTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            InstalledAppUiTransformerInterface::KEY_PLUGIN_ID => 'test-plugin-id',
            InstalledAppUiTransformerInterface::KEY_PLUGIN_URI => 'test-plugin-uri',
            InstalledAppUiTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true,
            InstalledAppUiTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true,
        ];

        $transformer = new InstalledAppUiTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-plugin-id', $actual->getPluginId());
        self::assertSame('test-plugin-uri', $actual->getPluginUri());
        self::assertTrue($actual->getDashboardCardsEnabled());
        self::assertTrue($actual->getPreInstallDashboardCardsEnabled());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new InstalledAppUiTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'dashboardCardsEnabledAbsent' => [[InstalledAppUiTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true], 'getDashboardCardsEnabled', null];
        yield 'dashboardCardsEnabledWrongType' => [[InstalledAppUiTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true, InstalledAppUiTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => 'not-bool'], 'getDashboardCardsEnabled', null];
        yield 'preInstallDashboardCardsEnabledAbsent' => [[InstalledAppUiTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true], 'getPreInstallDashboardCardsEnabled', null];
        yield 'preInstallDashboardCardsEnabledWrongType' => [[InstalledAppUiTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true, InstalledAppUiTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => 'not-bool'], 'getPreInstallDashboardCardsEnabled', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new InstalledAppUiTransformer();

        $actual = $transformer->transform([InstalledAppUiTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true, InstalledAppUiTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'pluginIdAbsent' => [[], 'getPluginId', null];
        yield 'pluginIdWrongType' => [[InstalledAppUiTransformerInterface::KEY_PLUGIN_ID => 42], 'getPluginId', null];
        yield 'pluginIdValid' => [[InstalledAppUiTransformerInterface::KEY_PLUGIN_ID => 'test-plugin-id'], 'getPluginId', 'test-plugin-id'];
        yield 'pluginUriAbsent' => [[], 'getPluginUri', null];
        yield 'pluginUriWrongType' => [[InstalledAppUiTransformerInterface::KEY_PLUGIN_URI => 42], 'getPluginUri', null];
        yield 'pluginUriValid' => [[InstalledAppUiTransformerInterface::KEY_PLUGIN_URI => 'test-plugin-uri'], 'getPluginUri', 'test-plugin-uri'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new InstalledAppUiTransformer();

        $actual = $transformer->transform([InstalledAppUiTransformerInterface::KEY_DASHBOARD_CARDS_ENABLED => true, InstalledAppUiTransformerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true]);

        self::assertNull($actual->getPluginId());
        self::assertNull($actual->getPluginUri());
    }
}
