<?php

declare(strict_types=1);

namespace App\SimulationBoundedContext\Application\Command;

use PHPUnit\Event\Runtime\PHP;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'SimulationCommand',
    description: 'Simulation metro mapping',
)]
class SimulationCommand extends Command
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        MessageBusInterface         $messageBus
    )
    {
        $this->messageBus = $messageBus;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Simulation metro mapping')
            ->addOption('show-time', null, InputOption::VALUE_NONE, 'If set, show time');
    }

    private function setupSimulation()
    {

    }

    private function simulation()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $showTime = $input->getOption('show-time');
        $tick = 0.5;

        $this->setupSimulation();
        $time = microtime(true);
        while (true) {
            if (true === $showTime) {
                echo (microtime(true) - $time) .  PHP_EOL;
            }
            $this->simulation();
            usleep((int)(1000000*$tick));
        }
        return Command::SUCCESS;
    }
}
