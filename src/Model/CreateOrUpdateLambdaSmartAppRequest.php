<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateOrUpdateLambdaSmartAppRequest implements CreateOrUpdateLambdaSmartAppRequestInterface
{
    /**
     * @var array<int, string>
     */
    private array $functions;

    /**
     * @phpstan-param array<int, string> $functions
     */
    public function __construct(array $functions)
    {
        $this->functions = $functions;
    }

    /**
     * @return array<int, string>
     */
    public function getFunctions(): array
    {
        return $this->functions;
    }
}
