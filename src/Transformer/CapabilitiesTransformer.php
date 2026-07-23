<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityInterface;

use function array_values;
use function count;
use function sprintf;

final class CapabilitiesTransformer implements CapabilitiesTransformerInterface
{
    private CapabilityTransformerInterface $capabilityTransformer;

    public function __construct(CapabilityTransformerInterface $capabilityTransformer)
    {
        $this->capabilityTransformer = $capabilityTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityInterface>
     */
    public function transform(array $data): array
    {
        $capabilities = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $capabilityData = $values[$i];
            if (!is_array($capabilityData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $capabilities[] = $this->capabilityTransformer->transform($capabilityData);
        }

        return $capabilities;
    }
}
