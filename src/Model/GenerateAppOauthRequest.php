<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class GenerateAppOauthRequest implements GenerateAppOauthRequestInterface
{
    private ?string $clientName = null;

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
    public function getScope(): ?array
    {
        return $this->scope;
    }

    public function setClientName(?string $value): GenerateAppOauthRequestInterface
    {
        $this->clientName = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setScope(?array $value): GenerateAppOauthRequestInterface
    {
        $this->scope = $value;

        return $this;
    }
}
