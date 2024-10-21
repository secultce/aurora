<?php

declare(strict_types=1);

namespace App\Command\Mongo;

use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ExecuteMongoMigrationCommand extends Command
{
    private const string MIGRATIONS_COLLECTION = 'migrations';

    public function __construct(private DocumentManager $documentManager, private readonly ParameterBagInterface $bag)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:mongo:migrations:execute')
            ->setDescription('Running odm migrations')
            ->addArgument('direction', InputArgument::OPTIONAL, 'Migration direction (up or down)', 'up')
            ->addArgument('version', InputArgument::OPTIONAL, 'Version of the migration to execute');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $direction = $input->getArgument('direction');
        $version = $input->getOption('version');

        $migrationDir = $this->bag->get('app.migrations.odm');

        if (false === is_dir($migrationDir)) {
            $io->error('Migration directory not found.');

            return Command::FAILURE;
        }

        $migrationFiles = $version ? [sprintf('%s/Version%s.php', $migrationDir, $version)] : glob("$migrationDir/Version*.php");

        if (true === empty($migrationFiles)) {
            $io->warning('No migration file found.');

            return Command::SUCCESS;
        }

        $databaseName = $this->documentManager->getConfiguration()->getDefaultDB();
        $collection = $this->documentManager->getClient()->selectCollection($databaseName, self::MIGRATIONS_COLLECTION);
        $appliedMigrations = $collection->find()->toArray();
        $appliedVersions = array_column($appliedMigrations, 'version');

        foreach ($migrationFiles as $file) {
            require_once $file;

            $className = sprintf('DoctrineMigrationsOdm\\%s', basename($file, '.php'));

            if (false === class_exists($className)) {
                $io->error("The class $className was not found in the file $file.");
                continue;
            }

            if (in_array(basename($file, '.php'), $appliedVersions)) {
                $io->info("Migration $className has already been applied.");
                continue;
            }

            $migration = new $className();

            if (false === method_exists($migration, $direction)) {
                $io->error("The method $direction() does not exist in the $className.");
                continue;
            }

            $io->section("Running the migration: $className ($direction)");

            try {
                $migration->{$direction}($this->documentManager);
                $collection->insertOne(['version' => basename($file, '.php'), 'applied_at' => new DateTime()]);
                $io->success("Migration $className ($direction) successfully executed.");
            } catch (Exception $e) {
                $io->error("Error when performing migration  $className: ".$e->getMessage());

                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
