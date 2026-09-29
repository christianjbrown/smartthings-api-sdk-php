<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Location;
use ChristianBrown\SmartThings\Model\LocationDetailsInterface;
use ChristianBrown\SmartThings\Model\LocationParentInterface;
use ChristianBrown\SmartThings\Transformer\LocationDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Location::class)]
#[CoversClass(LocationTransformer::class)]
final class LocationTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new LocationTransformer(self::createStub(LocationDetailsTransformerInterface::class));

        $actual = $transformer->transform([LocationTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'countryCodeAbsent' => [[], 'getCountryCode', null];
        yield 'countryCodeWrongType' => [[LocationTransformerInterface::KEY_COUNTRY_CODE => 42], 'getCountryCode', null];
        yield 'countryCodeValid' => [[LocationTransformerInterface::KEY_COUNTRY_CODE => 'test-country-code'], 'getCountryCode', 'test-country-code'];
        yield 'latitudeAbsent' => [[], 'getLatitude', null];
        yield 'latitudeWrongType' => [[LocationTransformerInterface::KEY_LATITUDE => 'not-number'], 'getLatitude', null];
        yield 'latitudeValid' => [[LocationTransformerInterface::KEY_LATITUDE => 1.5], 'getLatitude', 1.5];
        yield 'longitudeAbsent' => [[], 'getLongitude', null];
        yield 'longitudeWrongType' => [[LocationTransformerInterface::KEY_LONGITUDE => 'not-number'], 'getLongitude', null];
        yield 'longitudeValid' => [[LocationTransformerInterface::KEY_LONGITUDE => 1.5], 'getLongitude', 1.5];
        yield 'regionRadiusAbsent' => [[], 'getRegionRadius', null];
        yield 'regionRadiusWrongType' => [[LocationTransformerInterface::KEY_REGION_RADIUS => 'not-int'], 'getRegionRadius', null];
        yield 'regionRadiusValid' => [[LocationTransformerInterface::KEY_REGION_RADIUS => 7], 'getRegionRadius', 7];
        yield 'temperatureScaleAbsent' => [[], 'getTemperatureScale', null];
        yield 'temperatureScaleWrongType' => [[LocationTransformerInterface::KEY_TEMPERATURE_SCALE => 42], 'getTemperatureScale', null];
        yield 'temperatureScaleValid' => [[LocationTransformerInterface::KEY_TEMPERATURE_SCALE => 'test-temperature-scale'], 'getTemperatureScale', 'test-temperature-scale'];
        yield 'timeZoneIdAbsent' => [[], 'getTimeZoneId', null];
        yield 'timeZoneIdWrongType' => [[LocationTransformerInterface::KEY_TIME_ZONE_ID => 42], 'getTimeZoneId', null];
        yield 'timeZoneIdValid' => [[LocationTransformerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id'], 'getTimeZoneId', 'test-time-zone-id'];
        yield 'localeAbsent' => [[], 'getLocale', null];
        yield 'localeWrongType' => [[LocationTransformerInterface::KEY_LOCALE => 42], 'getLocale', null];
        yield 'localeValid' => [[LocationTransformerInterface::KEY_LOCALE => 'test-locale'], 'getLocale', 'test-locale'];
        yield 'backgroundImageAbsent' => [[], 'getBackgroundImage', null];
        yield 'backgroundImageWrongType' => [[LocationTransformerInterface::KEY_BACKGROUND_IMAGE => 42], 'getBackgroundImage', null];
        yield 'backgroundImageValid' => [[LocationTransformerInterface::KEY_BACKGROUND_IMAGE => 'test-background-image'], 'getBackgroundImage', 'test-background-image'];
        yield 'additionalPropertiesAbsent' => [[], 'getAdditionalProperties', []];
        yield 'additionalPropertiesWrongType' => [[LocationTransformerInterface::KEY_ADDITIONAL_PROPERTIES => 'not-array'], 'getAdditionalProperties', []];
        yield 'additionalPropertiesValid' => [[LocationTransformerInterface::KEY_ADDITIONAL_PROPERTIES => ['test-additional-properties-key' => 'test-value', 'skipped' => 42]], 'getAdditionalProperties', ['test-additional-properties-key' => 'test-value']];
        yield 'allowedAbsent' => [[], 'getAllowed', []];
        yield 'allowedWrongType' => [[LocationTransformerInterface::KEY_ALLOWED => 'not-array'], 'getAllowed', []];
        yield 'allowedValid' => [[LocationTransformerInterface::KEY_ALLOWED => ['test-allowed-1', 42, 'test-allowed-2']], 'getAllowed', ['test-allowed-1', 'test-allowed-2']];
        yield 'createdAbsent' => [[], 'getCreated', null];
        yield 'createdWrongType' => [[LocationTransformerInterface::KEY_CREATED => 42], 'getCreated', null];
        yield 'createdValid' => [[LocationTransformerInterface::KEY_CREATED => 'test-created'], 'getCreated', 'test-created'];
        yield 'lastModifiedAbsent' => [[], 'getLastModified', null];
        yield 'lastModifiedWrongType' => [[LocationTransformerInterface::KEY_LAST_MODIFIED => 42], 'getLastModified', null];
        yield 'lastModifiedValid' => [[LocationTransformerInterface::KEY_LAST_MODIFIED => 'test-last-modified'], 'getLastModified', 'test-last-modified'];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $parent = self::createStub(LocationParentInterface::class);
        $details = self::createStub(LocationDetailsInterface::class);
        $details->method('getParent')->willReturn($parent);

        $data = [LocationTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + [LocationTransformerInterface::KEY_PARENT => []];
        $containerTransformer = self::createMock(LocationDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new LocationTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($parent, $actual->getParent());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(LocationDetailsInterface::class);
        $containerTransformer = self::createStub(LocationDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new LocationTransformer($containerTransformer);

        $actual = $transformer->transform([LocationTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + [LocationTransformerInterface::KEY_PARENT => []]);

        self::assertNull($actual->getParent());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(LocationDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new LocationTransformer($containerTransformer);

        $actual = $transformer->transform([LocationTransformerInterface::KEY_LOCATION_ID => 'test-location-id']);

        self::assertNull($actual->getParent());
    }
}
