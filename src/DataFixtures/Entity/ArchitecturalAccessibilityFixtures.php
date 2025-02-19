<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\ArchitecturalAccessibility;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ArchitecturalAccessibilityFixtures extends AbstractFixture
{
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_PREFIX = 'architectural_accessibility';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_1 = 'b8844d8f-1edd-43a6-98ef-008b5980aa48';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_2 = 'a15f2534-425e-433e-b62e-bc17f8a00cb5';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_3 = '5c1d63c8-b41d-4d82-894c-b594ff7f75f4';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_4 = 'c6acee35-9dbe-478d-8be9-23bc3387e4c4';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_5 = '55555555-5555-5555-5555-555555555555';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_6 = 'be565350-c6dc-4d72-93a6-42a0a1860bdd';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_7 = '637db28b-5183-4e5d-8d5a-829e8ab5472a';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_8 = '84b3082a-8497-484b-b648-bf19deadfce7';
    public const string ARCHITECTURAL_ACCESSIBILITY_ID_9 = 'b1a9d00c-f330-4d2a-b5fa-dfbf9e23dee3';

    public const array ARCHITECTURAL_ACCESSIBILITIES = [
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_1,
            'name' => 'Rampas',
            'description' => 'Rampas de acesso para cadeirantes',
        ],
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_2,
            'name' => 'Elevadores',
            'description' => 'Elevadores adaptados para acessibilidade',
        ],
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_3,
            'name' => 'Plataformas de elevação',
            'description' => 'Plataformas que auxiliam na elevação de cadeirantes',
        ],
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_4,
            'name' => 'Banheiros adaptados',
            'description' => 'Banheiros com adaptações para pessoas com deficiência',
        ],
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_5,
            'name' => 'Calçadas com piso tátil',
            'description' => 'Calçadas com piso tátil para orientação',
        ],
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_6,
            'name' => 'Portas amplas e sem degraus',
            'description' => 'Portas amplas sem barreiras para acesso',
        ],
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_7,
            'name' => 'Sinalização de piso em relevo',
            'description' => 'Piso com sinalização em relevo para deficientes visuais',
        ],
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_8,
            'name' => 'Sinais de trânsito com avisos sonoros',
            'description' => 'Sinais de trânsito que emitem avisos sonoros para alertar pedestres e motoristas',
        ],
        [
            'id' => self::ARCHITECTURAL_ACCESSIBILITY_ID_9,
            'name' => 'Sinalização tátil',
            'description' => 'Sinalização tátil para orientação de pessoas com deficiência visual',
        ],
    ];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TokenStorageInterface $tokenStorage,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct($entityManager, $tokenStorage);
    }

    public function load(ObjectManager $manager): void
    {
        $this->truncateTable(ArchitecturalAccessibility::class);
        $this->createArchitecturalAccessibilities($manager);
    }

    private function createArchitecturalAccessibilities(ObjectManager $manager): void
    {
        foreach (self::ARCHITECTURAL_ACCESSIBILITIES as $accessibilityData) {
            $accessibility = $this->serializer->denormalize($accessibilityData, ArchitecturalAccessibility::class);

            $this->setReference(
                sprintf('%s-%s', self::ARCHITECTURAL_ACCESSIBILITY_ID_PREFIX, $accessibilityData['id']),
                $accessibility
            );

            $manager->persist($accessibility);
        }
        $manager->flush();
    }
}
