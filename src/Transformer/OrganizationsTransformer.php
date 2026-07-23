<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\OrganizationInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class OrganizationsTransformer implements OrganizationsTransformerInterface
{
    private OrganizationTransformerInterface $organizationTransformer;

    public function __construct(OrganizationTransformerInterface $organizationTransformer)
    {
        $this->organizationTransformer = $organizationTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OrganizationInterface>
     */
    public function transform(array $data): array
    {
        $organizations = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $organizationData = $values[$i];
            if (!is_array($organizationData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $organizations[] = $this->organizationTransformer->transform($organizationData);
        }

        return $organizations;
    }
}
