<?php

declare(strict_types=1);

namespace Symplify\Skipper\SkipCriteriaResolver;

use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\Skipper\ValueObject\Option;
use Symplify\SmartFileSystem\Normalizer\PathNormalizer;

/**
 * @see \Symplify\Skipper\Tests\SkipCriteriaResolver\SkippedPathsResolver\SkippedPathsResolverTest
 */
final class SkippedPathsResolver
{
    /**
     * @var string[]
     */
    private array $skippedPaths = [];

    public function __construct(
        private ParameterProvider $parameterProvider,
        private PathNormalizer $pathNormalizer
    ) {
    }

    /**
     * @return string[]
     */
    public function resolve(): array
    {
        if ($this->skippedPaths !== []) {
            return $this->skippedPaths;
        }

        $skip = $this->parameterProvider->provideArrayParameter(Option::SKIP);

        foreach ($skip as $key => $value) {
            if (! is_int($key)) {
                continue;
            }

            if (file_exists($value)) {
                $this->skippedPaths[] = $this->pathNormalizer->normalizePath($value);
                continue;
            }

            if (\str_contains($value, '*')) {
                $this->skippedPaths[] = $this->pathNormalizer->normalizePath($value);
                continue;
            }
        }

        return $this->skippedPaths;
    }
}
