<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppDetails;
use ChristianBrown\SmartThings\Model\SchemaAppDetailsInterface;

use function is_array;

final class SchemaAppDetailsTransformer implements SchemaAppDetailsTransformerInterface
{
    private ViperAppLinksTransformerInterface $viperAppLinksTransformer;

    public function __construct(ViperAppLinksTransformerInterface $viperAppLinksTransformer)
    {
        $this->viperAppLinksTransformer = $viperAppLinksTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppDetailsInterface
    {
        $model = new SchemaAppDetails();

        $this->applyViperAppLinks($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyViperAppLinks(SchemaAppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_VIPER_APP_LINKS])) {
            return;
        }
        if (!is_array($data[self::KEY_VIPER_APP_LINKS])) {
            return;
        }
        $model->setViperAppLinks($this->viperAppLinksTransformer->transform($data[self::KEY_VIPER_APP_LINKS]));
    }
}
