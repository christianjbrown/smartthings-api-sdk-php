<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ServiceSubscriptionRequest implements ServiceSubscriptionRequestInterface
{
    /**
     * @var array<int, string>
     */
    private array $capabilities;
    private string $isaId;
    private ?string $postalCode = null;
    private ?string $predicate = null;
    private ?string $type = null;

    /**
     * @phpstan-param array<int, string> $capabilities
     */
    public function __construct(array $capabilities, string $isaId)
    {
        $this->capabilities = $capabilities;
        $this->isaId = $isaId;
    }

    /**
     * @return array<int, string>
     */
    public function getCapabilities(): array
    {
        return $this->capabilities;
    }

    public function getIsaId(): string
    {
        return $this->isaId;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getPredicate(): ?string
    {
        return $this->predicate;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setPostalCode(?string $value): ServiceSubscriptionRequestInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setPredicate(?string $value): ServiceSubscriptionRequestInterface
    {
        $this->predicate = $value;

        return $this;
    }

    public function setType(?string $value): ServiceSubscriptionRequestInterface
    {
        $this->type = $value;

        return $this;
    }
}
