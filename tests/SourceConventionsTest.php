<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests;

use FilesystemIterator;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function basename;
use function dirname;
use function file_get_contents;
use function str_contains;

/**
 * Collaborators are injected through constructors and wired by the container registrars. A
 * `?? new` fallback anywhere but the SmartThings facade (the composition root) is a hidden
 * dependency, so this fails the build if one comes back.
 */
#[CoversNothing]
final class SourceConventionsTest extends TestCase
{
    public function testNoFallbackConstructionOutsideTheFacade(): void
    {
        $offenders = [];
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__).'/src', FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if (!$file instanceof SplFileInfo) {
                continue;
            }
            if ('SmartThings.php' === basename($file->getPathname())) {
                continue;
            }
            if (str_contains((string) file_get_contents($file->getPathname()), '?? new ')) {
                $offenders[] = $file->getPathname();
            }
        }

        self::assertSame([], $offenders);
    }
}
