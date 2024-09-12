<?php

declare(strict_types=1);

namespace App\Command\Mongo;

use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GenerateMongoMigrationCommand extends Command
{
    public function __construct(private readonly ParameterBagInterface $bag)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:mongo:migrations:generate')
            ->setDescription('Generate a migration for the mongo');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $timestamp = (new DateTime())->format('YmdHis');
        $migrationName = "Version{$timestamp}.php";
        $migrationDir = $this->bag->get('app.migrations.odm');

        if (!is_dir($migrationDir)) {
            mkdir($migrationDir, 0o777, true);
        }

        $migrationPath = "{$migrationDir}/{$migrationName}";

        $template = <<<EOT
            <?php

            declare(strict_types=1);

            namespace DoctrineMigrationsOdm;

            use Doctrine\ODM\MongoDB\DocumentManager;

            final class Version{$timestamp}
            {
                public function up(DocumentManager \$dm): void
                {
                    // TODO: Implement the migration

                    // Example:
                    // \$dm->getDocumentCollection(YourDocument::class)->updateMany(
                    //     ['field' => 'value'],
                    //     ['\$set' => ['newField' => 'newValue']]
                    // );
                }

                public function down(DocumentManager \$dm): void
                {
                    // TODO: Implement the rollback

                    // Example:
                    // \$dm->getDocumentCollection(YourDocument::class)->updateMany(
                    //     ['field' => 'value'],
                    //     ['\$unset' => ['newField' => '']]
                    // );
                }
            }
            
            EOT;

        file_put_contents($migrationPath, $template);

        $io->success("Migration file successfully generated: {$migrationPath}");

        return Command::SUCCESS;
    }
}
