<?php

namespace Laravolt\Crud;

use Spatie\RouteDiscovery\Attributes\Where;

enum PrimaryKeyFormat
{
    case NUMERIC;
    case UUID;

    public static function getRouteConstraint(self $format): string
    {
        return match ($format) {
            self::NUMERIC => Where::numeric,
            self::UUID => Where::uuid,
        };
    }
}
