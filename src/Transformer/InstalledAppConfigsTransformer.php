<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;

use function array_values;
use function count;
use function sprintf;

final class InstalledAppConfigsTransformer implements InstalledAppConfigsTransformerInterface
{
    private InstalledAppConfigTransformerInterface $installedAppConfigTransformer;

    public function __construct(InstalledAppConfigTransformerInterface $installedAppConfigTransformer)
    {
        $this->installedAppConfigTransformer = $installedAppConfigTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, InstalledAppConfigInterface>
     */
    public function transform(array $data): array
    {
        $configs = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $configData = $values[$i];
            if (!is_array($configData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $configs[] = $this->installedAppConfigTransformer->transform($configData);
        }

        return $configs;
    }
}
