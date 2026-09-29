<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppInvitePageInterface
{
    /**
     * @return null|array<int, SchemaAppInviteInterface>
     */
    public function getItems(): ?array;

    public function getLinks(): ?PageLinksInterface;

    /**
     * @param null|array<int, SchemaAppInviteInterface> $value
     */
    public function setItems(?array $value): self;

    public function setLinks(?PageLinksInterface $value): self;
}
