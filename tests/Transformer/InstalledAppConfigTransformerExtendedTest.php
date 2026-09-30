<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppConfig;
use ChristianBrown\SmartThings\Transformer\ConfigEntriesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledAppConfig::class)]
#[CoversClass(InstalledAppConfigTransformer::class)]
#[CoversClass(ValueReader::class)]
final class InstalledAppConfigTransformerExtendedTest extends TestCase
{
    /**
     * Each new field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new InstalledAppConfigTransformer(self::createStub(ConfigEntriesTransformerInterface::class), new ValueReader());

        $actual = $transformer->transform([InstalledAppConfigTransformerInterface::KEY_CONFIGURATION_ID => 'test-configuration-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'configAbsent' => [[], 'getConfig', []];
        yield 'configWrongType' => [[InstalledAppConfigTransformerInterface::KEY_CONFIG => 'not-array'], 'getConfig', []];
        yield 'configValid' => [[InstalledAppConfigTransformerInterface::KEY_CONFIG => ['test-config-key' => 'test-value']], 'getConfig', ['test-config-key' => 'test-value']];
        yield 'createdDateAbsent' => [[], 'getCreatedDate', null];
        yield 'createdDateWrongType' => [[InstalledAppConfigTransformerInterface::KEY_CREATED_DATE => 42], 'getCreatedDate', null];
        yield 'createdDateValid' => [[InstalledAppConfigTransformerInterface::KEY_CREATED_DATE => 'test-created-date'], 'getCreatedDate', 'test-created-date'];
        yield 'lastUpdatedDateAbsent' => [[], 'getLastUpdatedDate', null];
        yield 'lastUpdatedDateWrongType' => [[InstalledAppConfigTransformerInterface::KEY_LAST_UPDATED_DATE => 42], 'getLastUpdatedDate', null];
        yield 'lastUpdatedDateValid' => [[InstalledAppConfigTransformerInterface::KEY_LAST_UPDATED_DATE => 'test-last-updated-date'], 'getLastUpdatedDate', 'test-last-updated-date'];
    }
}
