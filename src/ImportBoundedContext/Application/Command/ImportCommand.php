<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Command;

use App\ImportBoundedContext\Application\CQRS\Queries\FindConnexionByFileNameQuery;
use App\ImportBoundedContext\Application\CQRS\Queries\FindGareByFileNameQuery;
use App\ImportBoundedContext\Application\CQRS\Queries\FindLigneByFileNameQuery;
use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use App\ImportBoundedContext\Domain\Model\Gare\Gare;
use App\ImportBoundedContext\Domain\Model\Gare\GareArrayObject;
use App\ImportBoundedContext\Domain\Model\Ligne\Ligne;
use App\ImportBoundedContext\Domain\Model\Ligne\LigneArrayObject;
use App\Shared\Domain\Model\ArrayObject;
use App\Shared\Symfony\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'ImportCommand',
    description: 'Import metro mapping',
)]
class ImportCommand extends Command
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $messageBus
     * @param Serializer $serializer
     */
    public function __construct(
        MessageBusInterface $messageBus,
        private readonly Serializer $serializer
    )
    {
        $this->messageBus = $messageBus;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $gareQuery       = new FindGareByFileNameQuery(new FileNameValueObject('Resources/gares.csv'));
        $ligneQuery      = new FindLigneByFileNameQuery(new FileNameValueObject('Resources/lignes.csv'));
        $connexionQuery  = new FindConnexionByFileNameQuery(new FileNameValueObject('Resources/connexions.csv'));


        $this->handle($gareQuery);
        $this->handle($ligneQuery);
        $this->handle($connexionQuery);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
