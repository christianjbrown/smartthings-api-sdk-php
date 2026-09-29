<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationDetails;
use ChristianBrown\SmartThings\Model\LocationDetailsInterface;

use function is_array;

final class LocationDetailsTransformer implements LocationDetailsTransformerInterface
{
    private LocationParentTransformerInterface $locationParentTransformer;

    public function __construct(LocationParentTransformerInterface $locationParentTransformer)
    {
        $this->locationParentTransformer = $locationParentTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationDetailsInterface
    {
        $model = new LocationDetails();

        $this->applyParent($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyParent(LocationDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_PARENT])) {
            return;
        }
        if (!is_array($data[self::KEY_PARENT])) {
            return;
        }
        $model->setParent($this->locationParentTransformer->transform($data[self::KEY_PARENT]));
    }
}
