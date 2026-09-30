<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInterface;
use ChristianBrown\SmartThings\Model\UserSchemaApps;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\UserSchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\UserSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(UserSchemaAppsTransformer::class)]
#[CoversClass(UserSchemaApps::class)]
#[CoversClass(ValueReader::class)]
final class UserSchemaAppsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new UserSchemaAppsTransformer(self::createStub(SchemaAppsTransformerInterface::class), new ValueReader()))->transform([]);

        self::assertNull($actual->getUserId());
        self::assertSame([], $actual->getEndpointApps());
    }

    /**
     * @throws Exception
     */
    public function testTransformReadsTheWrapperFieldsAndTheApps(): void
    {
        $app = self::createStub(SchemaAppInterface::class);
        $schemaAppsTransformer = self::createMock(SchemaAppsTransformerInterface::class);
        $schemaAppsTransformer->expects(self::once())->method('transform')->with([['endpointAppId' => 'a']])->willReturn([$app]);

        $actual = (new UserSchemaAppsTransformer($schemaAppsTransformer, new ValueReader()))->transform([
            UserSchemaAppsTransformerInterface::KEY_USER_ID => 'test-user',
            UserSchemaAppsTransformerInterface::KEY_ENDPOINT_APPS => [['endpointAppId' => 'a'], 'skipped'],
        ]);

        self::assertSame('test-user', $actual->getUserId());
        self::assertSame([$app], $actual->getEndpointApps());
    }
}
