<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceLocationInfoSubscriptionInterface
{
    public function getPredicate(): ?string;

    /**
     * @return array<int, string>
     */
    public function getSubscribedCapabilities(): array;

    public function getSubscriptionId(): string;

    public function getType(): ?string;

    public function setPredicate(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setSubscribedCapabilities(array $value): self;

    public function setSubscriptionId(string $value): self;

    public function setType(?string $value): self;
}
