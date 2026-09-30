<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionExecutionResult;
use ChristianBrown\SmartThings\Model\ActionExecutionResultInterface;
use ChristianBrown\SmartThings\Model\CommandActionExecutionResultInterface;

use function array_keys;
use function array_map;

final class ActionExecutionResultTransformer implements ActionExecutionResultTransformerInterface
{
    private CommandActionExecutionResultTransformerInterface $commandActionExecutionResultTransformer;

    /**
     * @var array<string, callable(ActionExecutionResultInterface, mixed[]): ActionExecutionResultInterface>
     */
    private array $partAppliers;
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader, IfActionExecutionResultTransformerInterface $ifActionExecutionResultTransformer, LocationActionExecutionResultTransformerInterface $locationActionExecutionResultTransformer, CommandActionExecutionResultTransformerInterface $commandActionExecutionResultTransformer, SleepActionExecutionResultTransformerInterface $sleepActionExecutionResultTransformer, BehaviorAbnormalExecutionResultTransformerInterface $behaviorAbnormalExecutionResultTransformer)
    {
        $this->valueReader = $valueReader;
        $this->commandActionExecutionResultTransformer = $commandActionExecutionResultTransformer;
        // Each single-object part registers a `key => applier` here; a new kind of result is
        // one more line, and transform() never changes.
        $this->partAppliers = [
            self::KEY_IF => static fn (ActionExecutionResultInterface $result, array $part): ActionExecutionResultInterface => $result->setIf($ifActionExecutionResultTransformer->transform($part)),
            self::KEY_LOCATION => static fn (ActionExecutionResultInterface $result, array $part): ActionExecutionResultInterface => $result->setLocation($locationActionExecutionResultTransformer->transform($part)),
            self::KEY_SLEEP => static fn (ActionExecutionResultInterface $result, array $part): ActionExecutionResultInterface => $result->setSleep($sleepActionExecutionResultTransformer->transform($part)),
            self::KEY_BEHAVIOR => static fn (ActionExecutionResultInterface $result, array $part): ActionExecutionResultInterface => $result->setBehavior($behaviorAbnormalExecutionResultTransformer->transform($part)),
        ];
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionExecutionResultInterface
    {
        $result = (new ActionExecutionResult())
            ->setActionId($this->valueReader->string($data, self::KEY_ACTION_ID))
            ->setCommand(array_map(fn (array $item): CommandActionExecutionResultInterface => $this->commandActionExecutionResultTransformer->transform($item), $this->valueReader->records($data, self::KEY_COMMAND)));

        array_map(
            fn (string $key): ActionExecutionResultInterface => $this->applyPart($result, $data, $key),
            array_keys($this->partAppliers)
        );

        return $result;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPart(ActionExecutionResultInterface $result, array $data, string $key): ActionExecutionResultInterface
    {
        $part = $this->valueReader->record($data, $key);
        if (null === $part) {
            return $result;
        }

        return $this->partAppliers[$key]($result, $part);
    }
}
