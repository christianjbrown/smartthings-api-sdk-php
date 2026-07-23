<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Hub;
use ChristianBrown\SmartThings\Transformer\HubTransformer;
use ChristianBrown\SmartThings\Transformer\HubTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Hub::class)]
#[CoversClass(HubTransformer::class)]
final class HubTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HubTransformerInterface::KEY_ID => 'test-hub-id',
            HubTransformerInterface::KEY_EUI => 'test-eui',
            HubTransformerInterface::KEY_FIRMWARE_VERSION => '1.2.3',
            HubTransformerInterface::KEY_NAME => 'Home Hub',
            HubTransformerInterface::KEY_OWNER => 'test-owner',
            HubTransformerInterface::KEY_SERIAL_NUMBER => 'test-serial',
        ];

        $transformer = new HubTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-hub-id', $actual->getId());
        self::assertSame('test-eui', $actual->getEui());
        self::assertSame('1.2.3', $actual->getFirmwareVersion());
        self::assertSame('Home Hub', $actual->getName());
        self::assertSame('test-owner', $actual->getOwner());
        self::assertSame('test-serial', $actual->getSerialNumber());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?string $expectedEui, ?string $expectedFirmwareVersion, ?string $expectedName, ?string $expectedOwner, ?string $expectedSerialNumber): void
    {
        $transformer = new HubTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-hub-id', $actual->getId());
        self::assertSame($expectedEui, $actual->getEui());
        self::assertSame($expectedFirmwareVersion, $actual->getFirmwareVersion());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedOwner, $actual->getOwner());
        self::assertSame($expectedSerialNumber, $actual->getSerialNumber());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = HubTransformerInterface::KEY_ID;
        $eui = HubTransformerInterface::KEY_EUI;
        $firmware = HubTransformerInterface::KEY_FIRMWARE_VERSION;
        $name = HubTransformerInterface::KEY_NAME;
        $owner = HubTransformerInterface::KEY_OWNER;
        $serial = HubTransformerInterface::KEY_SERIAL_NUMBER;

        yield 'allAbsent' => [[$id => 'test-hub-id'], null, null, null, null, null];
        yield 'allValid' => [[$id => 'test-hub-id', $eui => 'test-eui', $firmware => '1.2.3', $name => 'Home Hub', $owner => 'test-owner', $serial => 'test-serial'], 'test-eui', '1.2.3', 'Home Hub', 'test-owner', 'test-serial'];
        yield 'euiWrongType' => [[$id => 'test-hub-id', $eui => 42], null, null, null, null, null];
        yield 'firmwareVersionWrongType' => [[$id => 'test-hub-id', $firmware => 42], null, null, null, null, null];
        yield 'nameWrongType' => [[$id => 'test-hub-id', $name => 42], null, null, null, null, null];
        yield 'ownerWrongType' => [[$id => 'test-hub-id', $owner => 42], null, null, null, null, null];
        yield 'serialNumberWrongType' => [[$id => 'test-hub-id', $serial => 42], null, null, null, null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[HubTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new HubTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(HubTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }
}
