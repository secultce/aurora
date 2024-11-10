<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Enum\InscriptionOpportunityStatus;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use ValueError;

final class EnumDenormalizer implements DenormalizerInterface
{
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return enum_exists($type);
    }

    public function denormalize($data, $type, $format = null, array $context = []): mixed
    {
        if ($data instanceof $type) {
            return $data;
        }

        try {
            return $type::from($data);
        } catch (ValueError $e) {
            throw new NotNormalizableValueException(sprintf('The data "%s" is not a valid enumeration case of type "%s".', $data, $type), 0, $e);
        }
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            InscriptionOpportunityStatus::class => true,
        ];
    }
}
