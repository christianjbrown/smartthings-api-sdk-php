<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PushButtonWithAvailableSizeInterface
{
    public function getArgument(): ?string;

    public function getArgumentType(): ?string;

    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array;

    public function getCommand(): string;

    public function getIconUrl(): ?string;

    public function setArgument(?string $value): self;

    public function setArgumentType(?string $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): self;

    public function setIconUrl(?string $value): self;
}
