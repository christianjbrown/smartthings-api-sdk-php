<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\LocationActionExecutionResult;
use ChristianBrown\SmartThings\Model\SecurityStateInterface;
use ChristianBrown\SmartThings\Transformer\LocationActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\SecurityStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationActionExecutionResultTransformer::class)]
#[CoversClass(LocationActionExecutionResult::class)]
#[CoversClass(ValueReader::class)]
final class LocationActionExecutionResultTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new LocationActionExecutionResultTransformer(new ValueReader(), self::createStub(SecurityStateTransformerInterface::class)))->transform([]);

        self::assertNull($actual->getResult());
        self::assertNull($actual->getSecurity());
    }

    /**
     * @throws Exception
     */
    public function testTransformReadsEveryField(): void
    {
        $security = self::createStub(SecurityStateInterface::class);
        $securityTransformer = self::createMock(SecurityStateTransformerInterface::class);
        $securityTransformer->expects(self::once())->method('transform')->with(['armState' => 'ARMED_AWAY'])->willReturn($security);

        $actual = (new LocationActionExecutionResultTransformer(new ValueReader(), $securityTransformer))->transform([
            'result' => 'SUCCESS',
            'locationId' => 'test-location',
            'mode' => 'Away',
            'security' => ['armState' => 'ARMED_AWAY'],
        ]);

        self::assertSame('SUCCESS', $actual->getResult());
        self::assertSame('test-location', $actual->getLocationId());
        self::assertSame('Away', $actual->getMode());
        self::assertSame($security, $actual->getSecurity());
    }
}
