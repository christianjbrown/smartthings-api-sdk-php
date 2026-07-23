<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AppInterface;

use function array_values;
use function count;
use function sprintf;

final class AppsTransformer implements AppsTransformerInterface
{
    private AppTransformerInterface $appTransformer;

    public function __construct(AppTransformerInterface $appTransformer)
    {
        $this->appTransformer = $appTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AppInterface>
     */
    public function transform(array $data): array
    {
        $apps = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $appData = $values[$i];
            if (!is_array($appData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $apps[] = $this->appTransformer->transform($appData);
        }

        return $apps;
    }
}
