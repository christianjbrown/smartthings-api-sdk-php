<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ModeInterface;

use function array_values;
use function count;
use function sprintf;

final class ModesTransformer implements ModesTransformerInterface
{
    private ModeTransformerInterface $modeTransformer;

    public function __construct(ModeTransformerInterface $modeTransformer)
    {
        $this->modeTransformer = $modeTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ModeInterface>
     */
    public function transform(array $data): array
    {
        $modes = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $modeData = $values[$i];
            if (!is_array($modeData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $modes[] = $this->modeTransformer->transform($modeData);
        }

        return $modes;
    }
}
