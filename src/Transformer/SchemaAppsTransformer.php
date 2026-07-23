<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class SchemaAppsTransformer implements SchemaAppsTransformerInterface
{
    private SchemaAppTransformerInterface $schemaAppTransformer;

    public function __construct(SchemaAppTransformerInterface $schemaAppTransformer)
    {
        $this->schemaAppTransformer = $schemaAppTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SchemaAppInterface>
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
            $apps[] = $this->schemaAppTransformer->transform($appData);
        }

        return $apps;
    }
}
