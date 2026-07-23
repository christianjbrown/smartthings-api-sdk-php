<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AppOauth implements AppOauthInterface
{
    private ?string $clientName = null;

    /**
     * @var array<int, string>
     */
    private array $redirectUris = [];

    /**
     * @var array<int, string>
     */
    private array $scope = [];

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    /**
     * @return array<int, string>
     */
    public function getRedirectUris(): array
    {
        return $this->redirectUris;
    }

    /**
     * @return array<int, string>
     */
    public function getScope(): array
    {
        return $this->scope;
    }

    public function setClientName(?string $value): AppOauthInterface
    {
        $this->clientName = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setRedirectUris(array $value): AppOauthInterface
    {
        $this->redirectUris = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setScope(array $value): AppOauthInterface
    {
        $this->scope = $value;

        return $this;
    }
}
