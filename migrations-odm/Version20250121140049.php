<?php

declare(strict_types=1);

namespace DoctrineMigrationsOdm;

use Doctrine\ODM\MongoDB\DocumentManager;

final class Version20250121140049
{
    public function up(DocumentManager $dm): void
    {
        // TODO: Implement the migration

        // Example:
        // $dm->getDocumentCollection(YourDocument::class)->updateMany(
        //     ['field' => 'value'],
        //     ['$set' => ['newField' => 'newValue']]
        // );
    }

    public function down(DocumentManager $dm): void
    {
        // TODO: Implement the rollback

        // Example:
        // $dm->getDocumentCollection(YourDocument::class)->updateMany(
        //     ['field' => 'value'],
        //     ['$unset' => ['newField' => '']]
        // );
    }
}
