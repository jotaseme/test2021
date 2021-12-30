<?php

namespace App\Command;

use App\Repository\ProjectRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProjectsInfoCommand extends Command
{
    protected static $defaultName = 'projects:info';

    protected ProjectRepository $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Projects info');
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->success(
            sprintf(
                '            - Total projects found: %s. 
            - Added total of their amounts: $%s',
                $this->repository->count([]),
                $this->repository->getProjectsTotalAmount()
            ),
        );

        return 0;
    }
}
