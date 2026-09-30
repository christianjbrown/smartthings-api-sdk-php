<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface RuleListQueryInterface extends QueryParametersInterface
{
    public const string KEY_INCLUDE_ALL_PARENTS = 'includeAllParents';
    public const string KEY_MAX = 'max';
    public const string KEY_OFFSET = 'offset';

    public function getIncludeAllParents(): ?bool;

    public function getMax(): ?int;

    public function getOffset(): ?int;

    public function setIncludeAllParents(?bool $value): self;

    public function setMax(?int $value): self;

    public function setOffset(?int $value): self;
}
