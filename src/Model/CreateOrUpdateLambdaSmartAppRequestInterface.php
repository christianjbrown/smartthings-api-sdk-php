<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CreateOrUpdateLambdaSmartAppRequestInterface
{
    /**
     * @return array<int, string>
     */
    public function getFunctions(): array;
}
