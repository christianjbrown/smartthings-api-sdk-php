<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AppOauthDefinition implements AppOauthDefinitionInterface
{
    private ?string $clientName = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $redirectUris = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $scope = null;

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    /**
     * @return null|array<int, string>
     */
    public function getRedirectUris(): ?array
    {
        return $this->redirectUris;
    }

    /**
     * @return null|array<int, string>
     */
    public function getScope(): ?array
    {
        return $this->scope;
    }

    public function setClientName(?string $value): AppOauthDefinitionInterface
    {
        $this->clientName = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setRedirectUris(?array $value): AppOauthDefinitionInterface
    {
        $this->redirectUris = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setScope(?array $value): AppOauthDefinitionInterface
    {
        $this->scope = $value;

        return $this;
    }
}
