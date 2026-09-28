<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

/**
 * A single field in a location patch request: either a new numeric value, or a
 * request to clear the field (toNull). Setting both is rejected by the API with a
 * 422, so this SDK does not attempt to police that combination itself.
 */
interface LocationPatchFieldInterface
{
    public function getValue(): ?float;

    public function isToNull(): bool;
}
