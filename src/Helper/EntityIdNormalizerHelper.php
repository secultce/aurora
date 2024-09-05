<?php

declare(strict_types=1);

namespace App\Helper;

class EntityIdNormalizerHelper
{
    public static function normalizeEntityId(?object $entity): ?string
    {
        if (is_object($entity) && method_exists($entity, 'getId')) {
            return $entity->getId()->toRfc4122();
        }

        return null;
    }
}
