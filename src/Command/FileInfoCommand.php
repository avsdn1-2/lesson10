<?php


namespace Documentor\Command;


use Documentor\Service\InfoServiceInterface;
use Documentor\Service\RenderInterface;
use Documentor\Service\RenderFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileInfoCommand extends Command
{
    /** @var bool */
    private $dryRun = false;

    /** @var InfoServiceInterface */
    private $infoService;

    private $render;

    //public function __construct(InfoServiceInterface $infoService, RenderInterface $render)
    public function __construct(InfoServiceInterface $infoService)
    {
        $this->infoService = $infoService;
        //$this->render = $render;
        parent::__construct('doc:report');
    }

    public function configure()
    {
        $this->setDescription('Read source file and prepare report')
            ->addArgument('filename', InputArgument::REQUIRED, 'Source file name')
            ->addOption('outputFormat','f',InputArgument::OPTIONAL)->addOption('dry-run');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');

        if ($input->getOption('dry-run')) {
            $output->writeln('Dry run checked');
            $this->dryRun = true;
        }

        if (!$input->getOption('outputFormat'))
        {
            $outputFormat = 'html';
        }
        elseif (!in_array($input->getOption('outputFormat'),['html','csv','xml','json']))
        {
            $output->writeln('<error>Format does not exist!</error>');
        }
        else
        {
            $outputFormat = $input->getOption('outputFormat');
        }

        $this->render = RenderFactory::defineRenderer($outputFormat);

        $this->infoService->setFilename($filename);
        $this->infoService->isDryRun($this->dryRun);

        $info = $this->infoService->getInfo();
        $this->render->render($info);
        exit(0);
    }
}