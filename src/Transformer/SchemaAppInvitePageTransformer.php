<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInvitePage;
use ChristianBrown\SmartThings\Model\SchemaAppInvitePageInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class SchemaAppInvitePageTransformer implements SchemaAppInvitePageTransformerInterface
{
    private PageLinksTransformerInterface $pageLinksTransformer;
    private SchemaAppInviteTransformerInterface $schemaAppInviteTransformer;

    public function __construct(SchemaAppInviteTransformerInterface $schemaAppInviteTransformer, PageLinksTransformerInterface $pageLinksTransformer)
    {
        $this->schemaAppInviteTransformer = $schemaAppInviteTransformer;
        $this->pageLinksTransformer = $pageLinksTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInvitePageInterface
    {
        $model = new SchemaAppInvitePage();

        $this->applyItems($model, $data);
        $this->applyLinks($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItems(SchemaAppInvitePage $model, array $data): void
    {
        if (!isset($data[self::KEY_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            return;
        }
        $model->setItems($this->transformListSchemaAppInvite($data[self::KEY_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLinks(SchemaAppInvitePage $model, array $data): void
    {
        if (!isset($data[self::KEY_LINKS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINKS])) {
            return;
        }
        $model->setLinks($this->pageLinksTransformer->transform($data[self::KEY_LINKS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SchemaAppInviteInterface>
     */
    private function transformListSchemaAppInvite(array $data): array
    {
        return array_values(array_map(fn (array $item): SchemaAppInviteInterface => $this->schemaAppInviteTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
