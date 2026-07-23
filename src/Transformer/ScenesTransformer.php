<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SceneInterface;

use function array_values;
use function count;
use function sprintf;

final class ScenesTransformer implements ScenesTransformerInterface
{
    private SceneTransformerInterface $sceneTransformer;

    public function __construct(SceneTransformerInterface $sceneTransformer)
    {
        $this->sceneTransformer = $sceneTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SceneInterface>
     */
    public function transform(array $data): array
    {
        $scenes = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $sceneData = $values[$i];
            if (!is_array($sceneData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $scenes[] = $this->sceneTransformer->transform($sceneData);
        }

        return $scenes;
    }
}
