<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class LocaleReferencesTransformer implements LocaleReferencesTransformerInterface
{
    private LocaleReferenceTransformerInterface $localeReferenceTransformer;

    public function __construct(LocaleReferenceTransformerInterface $localeReferenceTransformer)
    {
        $this->localeReferenceTransformer = $localeReferenceTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LocaleReferenceInterface>
     */
    public function transform(array $data): array
    {
        $references = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $referenceData = $values[$i];
            if (!is_array($referenceData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $references[] = $this->localeReferenceTransformer->transform($referenceData);
        }

        return $references;
    }
}
