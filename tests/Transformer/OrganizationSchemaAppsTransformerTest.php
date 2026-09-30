<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\OrganizationSchemaApps;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationSchemaAppsTransformer;
use ChristianBrown\SmartThings\Transformer\OrganizationSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrganizationSchemaAppsTransformer::class)]
#[CoversClass(OrganizationSchemaApps::class)]
#[CoversClass(ValueReader::class)]
final class OrganizationSchemaAppsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new OrganizationSchemaAppsTransformer(self::createStub(SchemaAppsTransformerInterface::class), new ValueReader()))->transform([]);

        self::assertSame([], $actual->getOrganizationIds());
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

        $actual = (new OrganizationSchemaAppsTransformer($schemaAppsTransformer, new ValueReader()))->transform([
            OrganizationSchemaAppsTransformerInterface::KEY_ORGANIZATION_IDS => ['org-1', 'org-2'],
            OrganizationSchemaAppsTransformerInterface::KEY_ENDPOINT_APPS => [['endpointAppId' => 'a'], 'skipped'],
        ]);

        self::assertSame(['org-1', 'org-2'], $actual->getOrganizationIds());
        self::assertSame([$app], $actual->getEndpointApps());
    }
}
