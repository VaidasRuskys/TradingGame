<?php

namespace App\Command;

use App\Entity\Challenge;
use App\Service\Challenge\ChallengeResultResolver;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateChallengeResultsCommand extends Command
{
    protected static $defaultName = 'app:calculate-challenge-results';

    private $entityManager;

    private $challengeRepo;

    private $challengeResolver;

    public function __construct(EntityManager $entityManager, ChallengeResultResolver $challengeResultResolver)
    {
        $this->entityManager = $entityManager;
        $this->challengeRepo = $this->entityManager->getRepository(Challenge::class);
        $this->challengeResolver = $challengeResultResolver;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Calculates results for challenges');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $challenges = $this->challengeRepo->getUnresolvedChallenges(10);
        /** @var Challenge $challenge */
        foreach ($challenges as $challenge) {
            $isResolved = $this->challengeResolver->resolve($challenge);
            if ($isResolved) {
                $output->writeln(sprintf('<info>%s %s resolved</info>', $challenge->getId(), $challenge->getStock()));
            } else {
                $output->writeln(sprintf('<error>%s %s failed</error>', $challenge->getId(), $challenge->getStock()));
            }
        }

        $output->writeln('<info>Finished</info>');

        return Command::SUCCESS;
    }
}
