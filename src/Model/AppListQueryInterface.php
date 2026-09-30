<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppListQueryInterface extends QueryParametersInterface
{
    public const string KEY_ACCOUNT_ID = 'accountId';
    public const string KEY_APP_TYPE = 'appType';
    public const string KEY_CLASSIFICATION = 'classification';
    public const string KEY_TAG = 'tag';

    public function getAccountId(): ?string;

    public function getAppType(): ?string;

    public function getClassification(): ?string;

    public function getTag(): ?string;

    public function setAccountId(?string $value): self;

    public function setAppType(?string $value): self;

    public function setClassification(?string $value): self;

    public function setTag(?string $value): self;
}
