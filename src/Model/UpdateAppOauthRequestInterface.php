<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UpdateAppOauthRequestInterface
{
    public function getClientName(): string;

    /**
     * @return array<int, string>
     */
    public function getRedirectUris(): array;

    /**
     * @return array<int, string>
     */
    public function getScope(): array;
}
