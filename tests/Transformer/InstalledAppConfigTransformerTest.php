<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppConfig;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledAppConfig::class)]
#[CoversClass(InstalledAppConfigTransformer::class)]
final class InstalledAppConfigTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            InstalledAppConfigTransformerInterface::KEY_CONFIGURATION_ID => 'test-configuration-id',
            InstalledAppConfigTransformerInterface::KEY_CONFIGURATION_STATUS => 'DONE',
            InstalledAppConfigTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id',
        ];

        $transformer = new InstalledAppConfigTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-configuration-id', $actual->getConfigurationId());
        self::assertSame('DONE', $actual->getConfigurationStatus());
        self::assertSame('test-installed-app-id', $actual->getInstalledAppId());
    }

    /**
     * Exercises the optional configurationStatus and installedAppId fields in
     * each of their three states: absent, present-but-wrong-type, or valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedConfigurationStatus, ?string $expectedInstalledAppId): void
    {
        $transformer = new InstalledAppConfigTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-configuration-id', $actual->getConfigurationId());
        self::assertSame($expectedConfigurationStatus, $actual->getConfigurationStatus());
        self::assertSame($expectedInstalledAppId, $actual->getInstalledAppId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $configurationStatusStates = [
            'configurationStatusAbsent' => [null, null],
            'configurationStatusWrongType' => [42, null],
            'configurationStatusValid' => ['DONE', 'DONE'],
        ];
        $installedAppIdStates = [
            'installedAppIdAbsent' => [null, null],
            'installedAppIdWrongType' => [42, null],
            'installedAppIdValid' => ['test-installed-app-id', 'test-installed-app-id'],
        ];

        foreach ($configurationStatusStates as $configurationStatusName => [$configurationStatusValue, $expectedConfigurationStatus]) {
            foreach ($installedAppIdStates as $installedAppIdName => [$installedAppIdValue, $expectedInstalledAppId]) {
                $data = [InstalledAppConfigTransformerInterface::KEY_CONFIGURATION_ID => 'test-configuration-id'];
                if (null !== $configurationStatusValue) {
                    $data[InstalledAppConfigTransformerInterface::KEY_CONFIGURATION_STATUS] = $configurationStatusValue;
                }
                if (null !== $installedAppIdValue) {
                    $data[InstalledAppConfigTransformerInterface::KEY_INSTALLED_APP_ID] = $installedAppIdValue;
                }

                yield sprintf('%s, %s', $configurationStatusName, $installedAppIdName) => [$data, $expectedConfigurationStatus, $expectedInstalledAppId];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[InstalledAppConfigTransformerInterface::KEY_CONFIGURATION_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new InstalledAppConfigTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledAppConfigTransformerInterface::UNEXPECTED_STRING_SPRINTF, InstalledAppConfigTransformerInterface::KEY_CONFIGURATION_ID));
        $transformer->transform($data);
    }
}
