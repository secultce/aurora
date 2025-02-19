<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\ArchitecturalAccessibility;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class ArchitecturalAccessibilityTest extends TestCase
{
    public function testCreateAccessibility(): void
    {
        $accessibility = new ArchitecturalAccessibility();

        $id = Uuid::v4();
        $name = 'Rampas';
        $description = 'Rampas de acesso para cadeirantes';

        $accessibility->setId($id);
        $accessibility->setName($name);
        $accessibility->setDescription($description);

        $this->assertEquals($id, $accessibility->getId());
        $this->assertEquals($name, $accessibility->getName());
        $this->assertEquals($description, $accessibility->getDescription());
    }

    public function testToArray(): void
    {
        $accessibility = new ArchitecturalAccessibility();

        $id = Uuid::v4();
        $name = 'Rampas';
        $description = 'Rampas de acesso para cadeirantes';

        $accessibility->setId($id);
        $accessibility->setName($name);
        $accessibility->setDescription($description);

        $this->assertEquals(
            [
                'id' => $id->toRfc4122(),
                'name' => $name,
                'description' => $description,
            ],
            $accessibility->toArray()
        );
    }
}
