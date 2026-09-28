<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateAppOauthRequest implements UpdateAppOauthRequestInterface
{
    private string $clientName;

    /**
     * @var array<int, string>
     */
    private array $redirectUris;

    /**
     * @var array<int, string>
     */
    private array $scope;

    /**
     * @phpstan-param array<int, string> $scope
     * @phpstan-param array<int, string> $redirectUris
     */
    public function __construct(string $clientName, array $scope, array $redirectUris)
    {
        $this->clientName = $clientName;
        $this->scope = $scope;
        $this->redirectUris = $redirectUris;
    }

    public function getClientName(): string
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
}
