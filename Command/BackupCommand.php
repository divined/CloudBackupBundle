<?php
namespace Dizda\CloudBackupBundle\Command;

use Dizda\CloudBackupBundle\Manager\BackupManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Run backup command.
 *
 * @author Jonathan Dizdarevic <dizda@dizda.fr>
 * @author István Manzuk <istvan.manzuk@gmail.com>
 */
class BackupCommand extends Command
{
    /**
     * @var BackupManager
     */
    protected $backupManager;

    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     * @param ContainerInterface $container
     * @param Kernel $kernel
     */
    public function __construct(BackupManager $backupManager, Kernel $kernel)
    {
        $this->backupManager = $backupManager;
        $this->kernel = $kernel;

        parent::__construct();
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName('dizda:backup:start')
            ->setDescription('Upload a backup of your database to your cloud services.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->backupManager->execute()) {
            $output->writeln('<error>Something went terribly wrong. We could not create a backup. Read your log files to see what caused this error.</error>');

            return 1; //error
        }

        $output->writeln('<info>Backup complete.</info>');
    }

}
