<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceProfilesTransformer::class)]
final class DeviceProfilesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-profile-1'], ['test-profile-2']];

        $profile1 = self::createStub(DeviceProfileInterface::class);
        $profile2 = self::createStub(DeviceProfileInterface::class);
        $profiles = [$profile1, $profile2];

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);
        $profileTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-profile-1'], $profile1],
                    [['test-profile-2'], $profile2],
                ]
            );

        $transformer = new DeviceProfilesTransformer($profileTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($profiles, $actual);
    }

    public function testTransformEmpty(): void
    {
        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);

        $transformer = new DeviceProfilesTransformer($profileTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $profile1 = self::createStub(DeviceProfileInterface::class);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::once())->method('transform')
            ->with(['test-profile-1'])
            ->willReturn($profile1);

        $transformer = new DeviceProfilesTransformer($profileTransformer);

        self::assertSame([$profile1], $transformer->transform([['test-profile-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);

        $transformer = new DeviceProfilesTransformer($profileTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceProfilesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceProfilesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-profile-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-profile-1-array'], 'test-profile-2-not-array', ['test-profile-3-array'], 'test-profile-4-not-array'];

        $profile1 = self::createStub(DeviceProfileInterface::class);
        $profile3 = self::createStub(DeviceProfileInterface::class);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);
        $profileTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-profile-1-array'], $profile1],
                    [['test-profile-3-array'], $profile3],
                ]
            );

        $transformer = new DeviceProfilesTransformer($profileTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceProfilesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceProfilesTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
