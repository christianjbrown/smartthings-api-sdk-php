<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\HubInstalledDriver;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformer;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubInstalledDriver::class)]
#[CoversClass(HubInstalledDriverTransformer::class)]
final class HubInstalledDriverTransformerExtendedTest extends TestCase
{
    /**
     * Each new field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new HubInstalledDriverTransformer();

        $actual = $transformer->transform([HubInstalledDriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'permissionsAbsent' => [[], 'getPermissions', []];
        yield 'permissionsWrongType' => [[HubInstalledDriverTransformerInterface::KEY_PERMISSIONS => 'not-array'], 'getPermissions', []];
        yield 'permissionsValid' => [[HubInstalledDriverTransformerInterface::KEY_PERMISSIONS => ['test-permissions-key' => 'test-value']], 'getPermissions', ['test-permissions-key' => 'test-value']];
        yield 'isWWSTAbsent' => [[], 'getIsWWST', null];
        yield 'isWWSTWrongType' => [[HubInstalledDriverTransformerInterface::KEY_IS_WWST => 'not-bool'], 'getIsWWST', null];
        yield 'isWWSTValid' => [[HubInstalledDriverTransformerInterface::KEY_IS_WWST => true], 'getIsWWST', true];
    }
}
