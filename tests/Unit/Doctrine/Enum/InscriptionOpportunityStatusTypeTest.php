<?php

declare(strict_types=1);

namespace App\Tests\Unit\Doctrine\Enum;

use App\Doctrine\Enum\InscriptionOpportunityStatusType;
use App\Enum\InscriptionOpportunityStatus;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use PHPUnit\Framework\TestCase;
use ValueError;

class InscriptionOpportunityStatusTypeTest extends TestCase
{
    private InscriptionOpportunityStatusType $type;

    protected function setUp(): void
    {
        $this->type = new InscriptionOpportunityStatusType();
    }

    public function testGetSQLDeclaration(): void
    {
        $sql = $this->type->getSQLDeclaration([], new PostgreSQLPlatform());

        $expectedSql = "ENUM('active', 'inactive', 'suspended')";
        $this->assertStringContainsString($expectedSql, $sql);
    }

    public function testConvertToPHPValue(): void
    {
        $value = 'active';

        $convertedValue = $this->type->convertToPHPValue($value, new PostgreSQLPlatform());

        $this->assertInstanceOf(InscriptionOpportunityStatus::class, $convertedValue);
        $this->assertSame(InscriptionOpportunityStatus::ACTIVE, $convertedValue);
    }

    public function testConvertToDatabaseValue(): void
    {
        $value = InscriptionOpportunityStatus::INACTIVE;

        $dbValue = $this->type->convertToDatabaseValue($value, new PostgreSQLPlatform());

        $this->assertSame('inactive', $dbValue);
    }

    public function testInvalidEnumConversion(): void
    {
        $this->expectException(ValueError::class);

        $invalidValue = 'non-existent';

        $this->type->convertToPHPValue($invalidValue, new PostgreSQLPlatform());
    }

    public function testGetName(): void
    {
        $name = $this->type->getName();

        $this->assertEquals('enumInscriptionOpportunityStatusType', $name);
    }
}
