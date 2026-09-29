<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteAcceptance;
use ChristianBrown\SmartThings\Model\SchemaAppInviteAcceptanceInterface;

use function is_string;

final class SchemaAppInviteAcceptanceTransformer implements SchemaAppInviteAcceptanceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInviteAcceptanceInterface
    {
        $model = new SchemaAppInviteAcceptance();

        self::applySchemaAppId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySchemaAppId(SchemaAppInviteAcceptance $model, array $data): void
    {
        if (empty($data[self::KEY_SCHEMA_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SCHEMA_APP_ID])) {
            return;
        }
        $model->setSchemaAppId($data[self::KEY_SCHEMA_APP_ID]);
    }
}
