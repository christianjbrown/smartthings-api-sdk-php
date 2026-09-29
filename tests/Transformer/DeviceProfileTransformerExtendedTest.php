<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Model\DeviceProfile;
use ChristianBrown\SmartThings\Model\DeviceProfileComponentInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileDetailsInterface;
use ChristianBrown\SmartThings\Model\DeviceRestrictionInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceProfile::class)]
#[CoversClass(DeviceProfileTransformer::class)]
final class DeviceProfileTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceProfileTransformer(self::createStub(DeviceProfileDetailsTransformerInterface::class));

        $actual = $transformer->transform([DeviceProfileTransformerInterface::KEY_ID => 'test-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'metadataAbsent' => [[], 'getMetadata', []];
        yield 'metadataWrongType' => [[DeviceProfileTransformerInterface::KEY_METADATA => 'not-array'], 'getMetadata', []];
        yield 'metadataValid' => [[DeviceProfileTransformerInterface::KEY_METADATA => ['test-metadata-key' => 'test-value', 'skipped' => 42]], 'getMetadata', ['test-metadata-key' => 'test-value']];
        yield 'presentationIdAbsent' => [[], 'getPresentationId', null];
        yield 'presentationIdWrongType' => [[DeviceProfileTransformerInterface::KEY_PRESENTATION_ID => 42], 'getPresentationId', null];
        yield 'presentationIdValid' => [[DeviceProfileTransformerInterface::KEY_PRESENTATION_ID => 'test-presentation-id'], 'getPresentationId', 'test-presentation-id'];
        yield 'migrationStatusAbsent' => [[], 'getMigrationStatus', null];
        yield 'migrationStatusWrongType' => [[DeviceProfileTransformerInterface::KEY_MIGRATION_STATUS => 42], 'getMigrationStatus', null];
        yield 'migrationStatusValid' => [[DeviceProfileTransformerInterface::KEY_MIGRATION_STATUS => 'test-migration-status'], 'getMigrationStatus', 'test-migration-status'];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $restrictions = self::createStub(DeviceRestrictionInterface::class);
        $preferences = [self::createStub(DevicePreferenceDefinitionInterface::class)];
        $components = [self::createStub(DeviceProfileComponentInterface::class)];
        $details = self::createStub(DeviceProfileDetailsInterface::class);
        $details->method('getRestrictions')->willReturn($restrictions);
        $details->method('getPreferences')->willReturn($preferences);
        $details->method('getComponents')->willReturn($components);

        $data = [DeviceProfileTransformerInterface::KEY_ID => 'test-id'] + [DeviceProfileTransformerInterface::KEY_RESTRICTIONS => []];
        $containerTransformer = self::createMock(DeviceProfileDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new DeviceProfileTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($restrictions, $actual->getRestrictions());
        self::assertSame($preferences, $actual->getPreferences());
        self::assertSame($components, $actual->getComponents());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(DeviceProfileDetailsInterface::class);
        $containerTransformer = self::createStub(DeviceProfileDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new DeviceProfileTransformer($containerTransformer);

        $actual = $transformer->transform([DeviceProfileTransformerInterface::KEY_ID => 'test-id'] + [DeviceProfileTransformerInterface::KEY_RESTRICTIONS => []]);

        self::assertNull($actual->getRestrictions());
        self::assertSame([], $actual->getPreferences());
        self::assertSame([], $actual->getComponents());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(DeviceProfileDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new DeviceProfileTransformer($containerTransformer);

        $actual = $transformer->transform([DeviceProfileTransformerInterface::KEY_ID => 'test-id']);

        self::assertNull($actual->getRestrictions());
        self::assertSame([], $actual->getPreferences());
        self::assertSame([], $actual->getComponents());
    }
}
