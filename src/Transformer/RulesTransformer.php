<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\RuleInterface;

use function array_values;
use function count;
use function sprintf;

final class RulesTransformer implements RulesTransformerInterface
{
    private RuleTransformerInterface $ruleTransformer;

    public function __construct(RuleTransformerInterface $ruleTransformer)
    {
        $this->ruleTransformer = $ruleTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, RuleInterface>
     */
    public function transform(array $data): array
    {
        $rules = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $ruleData = $values[$i];
            if (!is_array($ruleData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $rules[] = $this->ruleTransformer->transform($ruleData);
        }

        return $rules;
    }
}
