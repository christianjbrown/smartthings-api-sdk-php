<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPad;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommandInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadInterface;

use function is_array;
use function is_int;
use function is_string;
use function sprintf;

final class BasicPlusTvDirectionalPadTransformer implements BasicPlusTvDirectionalPadTransformerInterface
{
    private BasicPlusTvDirectionalPadCommandTransformerInterface $basicPlusTvDirectionalPadCommandTransformer;

    public function __construct(BasicPlusTvDirectionalPadCommandTransformerInterface $basicPlusTvDirectionalPadCommandTransformer)
    {
        $this->basicPlusTvDirectionalPadCommandTransformer = $basicPlusTvDirectionalPadCommandTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvDirectionalPadInterface
    {
        $model = new BasicPlusTvDirectionalPad(self::requireCapability($data), self::requireComponent($data), $this->requireCommand($data));

        self::applyVersion($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(BasicPlusTvDirectionalPad $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): BasicPlusTvDirectionalPadCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }

        return $this->basicPlusTvDirectionalPadCommandTransformer->transform($data[self::KEY_COMMAND]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireComponent(array $data): string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }

        return $data[self::KEY_COMPONENT];
    }
}
