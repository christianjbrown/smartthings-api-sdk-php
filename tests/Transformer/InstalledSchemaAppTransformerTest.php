<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledSchemaApp;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(InstalledSchemaApp::class)]
#[CoversClass(InstalledSchemaAppTransformer::class)]
final class InstalledSchemaAppTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            InstalledSchemaAppTransformerInterface::KEY_ISA_ID => 'test-isa-id',
            InstalledSchemaAppTransformerInterface::KEY_APP_NAME => 'Lifx (Connect)',
            InstalledSchemaAppTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            InstalledSchemaAppTransformerInterface::KEY_O_AUTH_LINK => 'https://example.com/oauth',
            InstalledSchemaAppTransformerInterface::KEY_PAGE_TYPE => 'loggedIn',
            InstalledSchemaAppTransformerInterface::KEY_PARTNER_NAME => 'LIFX Inc.',
        ];

        $transformer = new InstalledSchemaAppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-isa-id', $actual->getIsaId());
        self::assertSame('Lifx (Connect)', $actual->getAppName());
        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame('https://example.com/oauth', $actual->getOAuthLink());
        self::assertSame('loggedIn', $actual->getPageType());
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
        $transformer = new InstalledSchemaAppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-isa-id', $actual->getIsaId());
        self::assertSame($expected['appName'], $actual->getAppName());
        self::assertSame($expected['locationId'], $actual->getLocationId());
        self::assertSame($expected['oAuthLink'], $actual->getOAuthLink());
        self::assertSame($expected['pageType'], $actual->getPageType());
        self::assertSame($expected['partnerName'], $actual->getPartnerName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, array<string, ?string>}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = InstalledSchemaAppTransformerInterface::KEY_ISA_ID;
        $appName = InstalledSchemaAppTransformerInterface::KEY_APP_NAME;
        $locationId = InstalledSchemaAppTransformerInterface::KEY_LOCATION_ID;
        $oAuthLink = InstalledSchemaAppTransformerInterface::KEY_O_AUTH_LINK;
        $pageType = InstalledSchemaAppTransformerInterface::KEY_PAGE_TYPE;
        $partnerName = InstalledSchemaAppTransformerInterface::KEY_PARTNER_NAME;

        $none = ['appName' => null, 'locationId' => null, 'oAuthLink' => null, 'pageType' => null, 'partnerName' => null];

        yield 'allAbsent' => [[$id => 'test-isa-id'], $none];
        yield 'allValid' => [
            [$id => 'test-isa-id', $appName => 'Lifx (Connect)', $locationId => 'test-location-id', $oAuthLink => 'https://example.com/oauth', $pageType => 'loggedIn', $partnerName => 'LIFX Inc.'],
            ['appName' => 'Lifx (Connect)', 'locationId' => 'test-location-id', 'oAuthLink' => 'https://example.com/oauth', 'pageType' => 'loggedIn', 'partnerName' => 'LIFX Inc.'],
        ];
        yield 'appNameWrongType' => [[$id => 'test-isa-id', $appName => 42], $none];
        yield 'locationIdWrongType' => [[$id => 'test-isa-id', $locationId => 42], $none];
        yield 'oAuthLinkWrongType' => [[$id => 'test-isa-id', $oAuthLink => 42], $none];
        yield 'pageTypeWrongType' => [[$id => 'test-isa-id', $pageType => 42], $none];
        yield 'partnerNameWrongType' => [[$id => 'test-isa-id', $partnerName => 42], $none];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[InstalledSchemaAppTransformerInterface::KEY_ISA_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new InstalledSchemaAppTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledSchemaAppTransformerInterface::UNEXPECTED_STRING_SPRINTF, InstalledSchemaAppTransformerInterface::KEY_ISA_ID));
        $transformer->transform($data);
    }
}
