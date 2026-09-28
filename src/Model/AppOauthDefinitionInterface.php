<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppOauthDefinitionInterface
{
    public function getClientName(): ?string;

    /**
     * @return null|array<int, string>
     */
    public function getRedirectUris(): ?array;

    /**
     * @return null|array<int, string>
     */
    public function getScope(): ?array;

    public function setClientName(?string $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setRedirectUris(?array $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setScope(?array $value): self;
}
