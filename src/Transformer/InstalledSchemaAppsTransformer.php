<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class InstalledSchemaAppsTransformer implements InstalledSchemaAppsTransformerInterface
{
    private InstalledSchemaAppTransformerInterface $installedSchemaAppTransformer;

    public function __construct(InstalledSchemaAppTransformerInterface $installedSchemaAppTransformer)
    {
        $this->installedSchemaAppTransformer = $installedSchemaAppTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, InstalledSchemaAppInterface>
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
            $apps[] = $this->installedSchemaAppTransformer->transform($appData);
        }

        return $apps;
    }
}
