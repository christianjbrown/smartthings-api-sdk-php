<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LambdaSmartApp implements LambdaSmartAppInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $functions = null;

    /**
     * @return null|array<int, string>
     */
    public function getFunctions(): ?array
    {
        return $this->functions;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setFunctions(?array $value): LambdaSmartAppInterface
    {
        $this->functions = $value;

        return $this;
    }
}
