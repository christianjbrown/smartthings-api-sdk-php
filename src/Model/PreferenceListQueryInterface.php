<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PreferenceListQueryInterface extends QueryParametersInterface
{
    public const string KEY_NAMESPACE = 'namespace';
    public const string KEY_PAGE_SIZE = 'pageSize';
    public const string KEY_START_KEY = 'startKey';

    public function getNamespace(): ?string;

    public function getPageSize(): ?int;

    public function getStartKey(): ?string;

    public function setNamespace(?string $value): self;

    public function setPageSize(?int $value): self;

    public function setStartKey(?string $value): self;
}
