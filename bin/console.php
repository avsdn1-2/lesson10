#!/usr/bin/env php

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Documentor\Command\VersionCommand;
use Documentor\Command\FileInfoCommand;
use Documentor\Service\FileInfoService;


$application = new Application();
$application->setName('Hillel Documentor');

$fileInfoService = new FileInfoService();

$application->addCommands(
    [
        new FileInfoCommand($fileInfoService),
        new VersionCommand()
    ]
);

$application->run();