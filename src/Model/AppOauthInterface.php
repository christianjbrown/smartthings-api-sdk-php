<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppOauthInterface
{
    public function getClientName(): ?string;

    /**
     * @return array<int, string>
     */
    public function getRedirectUris(): array;

    /**
     * @return array<int, string>
     */
    public function getScope(): array;

    public function setClientName(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setRedirectUris(array $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setScope(array $value): self;
}
