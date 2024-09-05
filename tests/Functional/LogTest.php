<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class LogTest extends KernelTestCase
{
    private string $logsDir;

    private const array FILES = [
        'critical' => 'errors_5xx.log',
        'error' => 'errors_4xx.log',
        'debug' => 'debug.log',
        'info' => 'info.log',
    ];

    protected function setUp(): void
    {
        self::bootKernel();

        $this->logsDir = sprintf('%s/%s', self::$kernel->getLogDir(), 'tests');

        $filesystem = new Filesystem();

        if ($filesystem->exists($this->logsDir)) {
            $filesystem->remove(glob($this->logsDir.'/*'));
        }
    }

    public function testLog(): void
    {
        $logger = self::getContainer()->get('monolog.logger');

        $logger->critical('critical message', ['foo' => 'bar']);
        $logger->error('error message', ['foo' => 'bar']);
        $logger->debug('debug message', ['foo' => 'bar']);
        $logger->info('info message', ['foo' => 'bar']);

        foreach (self::FILES as $file) {
            $this->assertFileExists($this->logsDir.'/'.$file);
        }

        foreach (self::FILES as $key => $file) {
            $log = file_get_contents($this->logsDir.'/'.$file);
            $this->assertStringContainsString($key, $log);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $filesystem = new Filesystem();

        if ($filesystem->exists($this->logsDir)) {
            $filesystem->remove(glob($this->logsDir.'/*'));
        }
    }
}
