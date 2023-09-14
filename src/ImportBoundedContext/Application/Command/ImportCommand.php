<?php

declare(strict_types=1);

namespace App\ImportBoundedContext\Application\Command;

use App\ImportBoundedContext\Domain\Model\Connexion\Connexion;
use App\ImportBoundedContext\Domain\Model\Connexion\ConnexionArrayObject;
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

#[AsCommand(
    name: 'ImportCommand',
    description: 'Import metro mapping',
)]
class ImportCommand extends Command
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param Serializer $serializer
     */
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly Serializer $serializer)
    {
        parent::__construct();
    }
    protected function loadEntitiesFromCsv(string $fileName, string $entityName): ArrayObject
    {
        $data = file_get_contents($fileName, true);
        return $this->serializer->deserialize($data, $entityName, 'csv', ['csv_delimiter' => ';']);
    }

    protected function loadCsvConnexion(string $fileName, GareArrayObject $gares, LigneArrayObject $lignes): array
    {
        $connexions = [];
        if (($fp = fopen($fileName, "r")) !== FALSE) {
            $keys = [];
            $index = 0;
            while (($row = fgetcsv($fp, 5000, ";")) !== FALSE) {
                //$keys
                if (0 === $index) {
                    $keys = $row;
                } else {
                    $data = array_combine($keys, $row);
                    $ligneFound = null;
                    $gareDepartFound = null;
                    $gareArriveFound = null;

                    /** @var Ligne $ligne */
                    foreach ($lignes as $ligne) {
                        if ($data['code_ligne'] === $ligne->getNom()) {
                            $ligneFound = $ligne;
                            break;
                        }
                    }
                    /** @var Gare $gare */
                    foreach ($gares as $gare) {
                        if ($data['station_depart'] === $gare->getNom()) {
                            $gareDepartFound = $gare;
                        }
                        if ($data['station_arrive'] === $gare->getNom()) {
                            $gareArriveFound = $gare;
                        }
                        if ((null !== $gareDepartFound) && (null !== $gareArriveFound)) {
                            break;
                        }
                    }
                    if (null === $ligneFound) {
                        throw new RuntimeException('Ligne non trouvé dans la liste ' . $data['code_ligne']);
                    }
                    if (null === $gareDepartFound) {
                        throw new RuntimeException('Gare non trouvé dans la liste ' . $data['station_depart']);
                    }
                    if (null === $gareArriveFound) {
                        throw new RuntimeException('Gare non trouvé dans la liste ' . $data['station_arrive']);
                    }
                    $connexions[] = new Connexion(null, $ligne, $gareDepartFound, $gareArriveFound);
                }
                $index ++;
            }
            fclose($fp);
        }
        return $connexions;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var GareArrayObject $gares */
        $gares = $this->loadEntitiesFromCsv('Resources/gares.csv', GareArrayObject::class);

        /** @var LigneArrayObject $lignes */
        $lignes = $this->loadEntitiesFromCsv('Resources/lignes.csv', LigneArrayObject::class);

        $connexions = $this->loadCsvConnexion('Resources/connexions.csv', $gares, $lignes);

        dd($connexions);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
