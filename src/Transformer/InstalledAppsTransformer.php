<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;

use function array_values;
use function count;
use function sprintf;

final class InstalledAppsTransformer implements InstalledAppsTransformerInterface
{
    private InstalledAppTransformerInterface $installedAppTransformer;

    public function __construct(InstalledAppTransformerInterface $installedAppTransformer)
    {
        $this->installedAppTransformer = $installedAppTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, InstalledAppInterface>
     */
    public function transform(array $data): array
    {
        $installedApps = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $installedAppData = $values[$i];
            if (!is_array($installedAppData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $installedApps[] = $this->installedAppTransformer->transform($installedAppData);
        }

        return $installedApps;
    }
}
