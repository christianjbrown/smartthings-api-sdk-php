<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ScheduleInterface
{
    public function getCron(): ?CronScheduleInterface;

    public function getInstalledAppId(): ?string;

    public function getLocationId(): ?string;

    public function getName(): string;

    /**
     * @return array<int, int>
     */
    public function getScheduledExecutions(): array;

    public function getUserUuid(): ?string;

    public function setCron(?CronScheduleInterface $value): self;

    public function setInstalledAppId(?string $value): self;

    public function setLocationId(?string $value): self;

    public function setName(string $value): self;

    /**
     * @param array<int, int> $value
     */
    public function setScheduledExecutions(array $value): self;

    public function setUserUuid(?string $value): self;
}
