<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceResultsInterface;
use ChristianBrown\SmartThings\Model\InstalledSchemaApp;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppDetailsInterface;
use ChristianBrown\SmartThings\Model\ViperAppLinksInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledSchemaApp::class)]
#[CoversClass(InstalledSchemaAppTransformer::class)]
final class InstalledSchemaAppTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new InstalledSchemaAppTransformer(self::createStub(InstalledSchemaAppDetailsTransformerInterface::class));

        $actual = $transformer->transform([InstalledSchemaAppTransformerInterface::KEY_ISA_ID => 'test-isa-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'endpointAppIdAbsent' => [[], 'getEndpointAppId', null];
        yield 'endpointAppIdWrongType' => [[InstalledSchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID => 42], 'getEndpointAppId', null];
        yield 'endpointAppIdValid' => [[InstalledSchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id'], 'getEndpointAppId', 'test-endpoint-app-id'];
        yield 'iconAbsent' => [[], 'getIcon', null];
        yield 'iconWrongType' => [[InstalledSchemaAppTransformerInterface::KEY_ICON => 42], 'getIcon', null];
        yield 'iconValid' => [[InstalledSchemaAppTransformerInterface::KEY_ICON => 'test-icon'], 'getIcon', 'test-icon'];
        yield 'icon2xAbsent' => [[], 'getIcon2x', null];
        yield 'icon2xWrongType' => [[InstalledSchemaAppTransformerInterface::KEY_ICON2X => 42], 'getIcon2x', null];
        yield 'icon2xValid' => [[InstalledSchemaAppTransformerInterface::KEY_ICON2X => 'test-icon2x'], 'getIcon2x', 'test-icon2x'];
        yield 'icon3xAbsent' => [[], 'getIcon3x', null];
        yield 'icon3xWrongType' => [[InstalledSchemaAppTransformerInterface::KEY_ICON3X => 42], 'getIcon3x', null];
        yield 'icon3xValid' => [[InstalledSchemaAppTransformerInterface::KEY_ICON3X => 'test-icon3x'], 'getIcon3x', 'test-icon3x'];
        yield 'partnerSTConnectionAbsent' => [[], 'getPartnerSTConnection', null];
        yield 'partnerSTConnectionWrongType' => [[InstalledSchemaAppTransformerInterface::KEY_PARTNER_STCONNECTION => 42], 'getPartnerSTConnection', null];
        yield 'partnerSTConnectionValid' => [[InstalledSchemaAppTransformerInterface::KEY_PARTNER_STCONNECTION => 'test-partner-stconnection'], 'getPartnerSTConnection', 'test-partner-stconnection'];
        yield 'stEulaFileNameAbsent' => [[], 'getStEulaFileName', null];
        yield 'stEulaFileNameWrongType' => [[InstalledSchemaAppTransformerInterface::KEY_ST_EULA_FILE_NAME => 42], 'getStEulaFileName', null];
        yield 'stEulaFileNameValid' => [[InstalledSchemaAppTransformerInterface::KEY_ST_EULA_FILE_NAME => 'test-st-eula-file-name'], 'getStEulaFileName', 'test-st-eula-file-name'];
        yield 'stEulaLocksmithKeyAbsent' => [[], 'getStEulaLocksmithKey', null];
        yield 'stEulaLocksmithKeyWrongType' => [[InstalledSchemaAppTransformerInterface::KEY_ST_EULA_LOCKSMITH_KEY => 42], 'getStEulaLocksmithKey', null];
        yield 'stEulaLocksmithKeyValid' => [[InstalledSchemaAppTransformerInterface::KEY_ST_EULA_LOCKSMITH_KEY => 'test-st-eula-locksmith-key'], 'getStEulaLocksmithKey', 'test-st-eula-locksmith-key'];
        yield 'driverIdAbsent' => [[], 'getDriverId', null];
        yield 'driverIdWrongType' => [[InstalledSchemaAppTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
        yield 'driverIdValid' => [[InstalledSchemaAppTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getDriverId', 'test-driver-id'];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $devices = [self::createStub(DeviceResultsInterface::class)];
        $viperAppLinks = self::createStub(ViperAppLinksInterface::class);
        $details = self::createStub(InstalledSchemaAppDetailsInterface::class);
        $details->method('getDevices')->willReturn($devices);
        $details->method('getViperAppLinks')->willReturn($viperAppLinks);

        $data = [InstalledSchemaAppTransformerInterface::KEY_ISA_ID => 'test-isa-id'] + [InstalledSchemaAppTransformerInterface::KEY_DEVICES => []];
        $containerTransformer = self::createMock(InstalledSchemaAppDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new InstalledSchemaAppTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($devices, $actual->getDevices());
        self::assertSame($viperAppLinks, $actual->getViperAppLinks());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(InstalledSchemaAppDetailsInterface::class);
        $containerTransformer = self::createStub(InstalledSchemaAppDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new InstalledSchemaAppTransformer($containerTransformer);

        $actual = $transformer->transform([InstalledSchemaAppTransformerInterface::KEY_ISA_ID => 'test-isa-id'] + [InstalledSchemaAppTransformerInterface::KEY_DEVICES => []]);

        self::assertSame([], $actual->getDevices());
        self::assertNull($actual->getViperAppLinks());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(InstalledSchemaAppDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new InstalledSchemaAppTransformer($containerTransformer);

        $actual = $transformer->transform([InstalledSchemaAppTransformerInterface::KEY_ISA_ID => 'test-isa-id']);

        self::assertSame([], $actual->getDevices());
        self::assertNull($actual->getViperAppLinks());
    }
}
