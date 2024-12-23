<?php

declare(strict_types=1);

namespace App\Environment;

use Symfony\Component\Yaml\Yaml;

class ConfigEnvironment
{
    public function aurora(): array
    {
        $dirname = dirname(__DIR__, 2).'/config/environment';
        $filename = "{$dirname}/aurora.yaml";

        if (true === file_exists("{$dirname}/aurora.local.yaml")) {
            $filename = "{$dirname}/aurora.local.yaml";
        }

        if (true === file_exists("{$dirname}/aurora.prod.yaml")) {
            $filename = "{$dirname}/aurora.prod.yaml";
        }

        return Yaml::parseFile($filename);
    }
}
