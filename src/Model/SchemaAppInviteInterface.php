<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppInviteInterface
{
    public function getAcceptUrl(): ?string;

    public function getDeclineUrl(): ?string;

    public function getDescription(): ?string;

    public function getExpiration(): ?float;

    public function getId(): ?string;

    public function getSchemaAppId(): ?string;

    public function getShortCode(): ?string;

    public function setAcceptUrl(?string $value): self;

    public function setDeclineUrl(?string $value): self;

    public function setDescription(?string $value): self;

    public function setExpiration(?float $value): self;

    public function setId(?string $value): self;

    public function setSchemaAppId(?string $value): self;

    public function setShortCode(?string $value): self;
}
