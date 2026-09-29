<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Schedule implements ScheduleInterface
{
    private ?CronScheduleInterface $cron = null;
    private ?string $installedAppId = null;
    private ?string $locationId = null;
    private string $name;

    /**
     * @var array<int, int>
     */
    private array $scheduledExecutions = [];
    private ?string $userUuid = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getCron(): ?CronScheduleInterface
    {
        return $this->cron;
    }

    public function getInstalledAppId(): ?string
    {
        return $this->installedAppId;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<int, int>
     */
    public function getScheduledExecutions(): array
    {
        return $this->scheduledExecutions;
    }

    public function getUserUuid(): ?string
    {
        return $this->userUuid;
    }

    public function setCron(?CronScheduleInterface $value): ScheduleInterface
    {
        $this->cron = $value;

        return $this;
    }

    public function setInstalledAppId(?string $value): ScheduleInterface
    {
        $this->installedAppId = $value;

        return $this;
    }

    public function setLocationId(?string $value): ScheduleInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setName(string $value): ScheduleInterface
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @param array<int, int> $value
     */
    public function setScheduledExecutions(array $value): ScheduleInterface
    {
        $this->scheduledExecutions = $value;

        return $this;
    }

    public function setUserUuid(?string $value): ScheduleInterface
    {
        $this->userUuid = $value;

        return $this;
    }
}
