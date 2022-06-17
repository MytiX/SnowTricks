<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('instanceOf', [$this, 'instanceOf']),
        ];
    }

    public function instanceOf(mixed $object, string $className): bool
    {
        return $object instanceof $className;
    }
}