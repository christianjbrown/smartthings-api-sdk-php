<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppInviteRequestInterface
{
    public function getAcceptLimit(): ?int;

    public function getDescription(): ?string;

    public function getSchemaAppId(): ?string;

    public function setAcceptLimit(?int $value): self;

    public function setDescription(?string $value): self;

    public function setSchemaAppId(?string $value): self;
}
