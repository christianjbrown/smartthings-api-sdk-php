<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaPage;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SchemaPage::class)]
#[CoversClass(SchemaPageTransformer::class)]
final class SchemaPageTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SchemaPageTransformerInterface::KEY_PAGE_TYPE => 'loggedIn',
            SchemaPageTransformerInterface::KEY_APP_NAME => 'Lifx (Connect)',
            SchemaPageTransformerInterface::KEY_ISA_ID => 'test-isa-id',
            SchemaPageTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            SchemaPageTransformerInterface::KEY_O_AUTH_LINK => 'https://example.com/oauth',
            SchemaPageTransformerInterface::KEY_PARTNER_NAME => 'LIFX Inc.',
        ];

        $transformer = new SchemaPageTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('loggedIn', $actual->getPageType());
        self::assertSame('Lifx (Connect)', $actual->getAppName());
        self::assertSame('test-isa-id', $actual->getIsaId());
        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame('https://example.com/oauth', $actual->getOAuthLink());
        self::assertSame('LIFX Inc.', $actual->getPartnerName());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches.
     *
     * @param array<string, mixed>   $data
     * @param array<string, ?string> $expected
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, array $expected): void
    {
        $transformer = new SchemaPageTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('requiresLogin', $actual->getPageType());
        self::assertSame($expected['appName'], $actual->getAppName());
        self::assertSame($expected['isaId'], $actual->getIsaId());
        self::assertSame($expected['locationId'], $actual->getLocationId());
        self::assertSame($expected['oAuthLink'], $actual->getOAuthLink());
        self::assertSame($expected['partnerName'], $actual->getPartnerName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, array<string, ?string>}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $pageType = SchemaPageTransformerInterface::KEY_PAGE_TYPE;
        $appName = SchemaPageTransformerInterface::KEY_APP_NAME;
        $isaId = SchemaPageTransformerInterface::KEY_ISA_ID;
        $locationId = SchemaPageTransformerInterface::KEY_LOCATION_ID;
        $oAuthLink = SchemaPageTransformerInterface::KEY_O_AUTH_LINK;
        $partnerName = SchemaPageTransformerInterface::KEY_PARTNER_NAME;

        $none = ['appName' => null, 'isaId' => null, 'locationId' => null, 'oAuthLink' => null, 'partnerName' => null];

        yield 'allAbsent' => [[$pageType => 'requiresLogin'], $none];
        yield 'allValid' => [
            [$pageType => 'requiresLogin', $appName => 'Lifx (Connect)', $isaId => 'test-isa-id', $locationId => 'test-location-id', $oAuthLink => 'https://example.com/oauth', $partnerName => 'LIFX Inc.'],
            ['appName' => 'Lifx (Connect)', 'isaId' => 'test-isa-id', 'locationId' => 'test-location-id', 'oAuthLink' => 'https://example.com/oauth', 'partnerName' => 'LIFX Inc.'],
        ];
        yield 'appNameWrongType' => [[$pageType => 'requiresLogin', $appName => 42], $none];
        yield 'isaIdWrongType' => [[$pageType => 'requiresLogin', $isaId => 42], $none];
        yield 'locationIdWrongType' => [[$pageType => 'requiresLogin', $locationId => 42], $none];
        yield 'oAuthLinkWrongType' => [[$pageType => 'requiresLogin', $oAuthLink => 42], $none];
        yield 'partnerNameWrongType' => [[$pageType => 'requiresLogin', $partnerName => 42], $none];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[SchemaPageTransformerInterface::KEY_PAGE_TYPE => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new SchemaPageTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SchemaPageTransformerInterface::UNEXPECTED_STRING_SPRINTF, SchemaPageTransformerInterface::KEY_PAGE_TYPE));
        $transformer->transform($data);
    }
}
