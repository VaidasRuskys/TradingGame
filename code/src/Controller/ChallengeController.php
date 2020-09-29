<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\User;
use App\Service\Challenge\DayChallengeProvider;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ChallengeController extends AbstractController
{
    /**
     *
     * @Route("/challenge", name="challenge")
     * @IsGranted("ROLE_PLAYER")
     *
     * @param DayChallengeProvider $challengeProvider
     * @return Response
     */
    public function index(DayChallengeProvider $challengeProvider)
    {
        $data = $challengeProvider->getDayChallenge();

        return $this->render('challenge/index.html.twig', [
            'dayChallengeId' =>  $data['id'],
            'stock' => $data['stock'],
            'price' => $data['price'],
        ]);
    }

    /**
     *
     * @Route("/challenge/choice", name="challenge_choice", methods={"POST"})
     * @IsGranted("ROLE_PLAYER")
     *
     * @param Request $request
     * @param DayChallengeProvider $challengeProvider
     * @param EntityManager $entityManager
     * @param LoggerInterface $logger
     * @return Response
     */
    public function choice(
        Request $request,
        DayChallengeProvider $challengeProvider,
        EntityManager $entityManager,
        LoggerInterface $logger
    ) {
        $user = $this->getUser();
        $action = $request->get('action');
        $dayChallengeId = $request->get('day_challenge_id');

        if (!$dayChallengeId) {
            $logger->error('challenge not found');
            throw new BadRequestException('challenge not found');
        }

        if (!$action) {
            $logger->error('action not found');
            throw new BadRequestException('action not found');
        }

        if ($user instanceof User) {
            try {
                $dayChallenge = $challengeProvider->getDayChallenge();

                if ($dayChallengeId != $dayChallenge['id']) {
                    $logger->error('Challenge not active');
                    throw new \Exception('Challenge not active');
                }

                $challenge = new Challenge();
                $challenge
                    ->setDayChallengeId($dayChallenge['id'])
                    ->setUser($user->getId())
                    ->setAtPrice($dayChallenge['price'])
                    ->setAtTime(new \DateTime())
                    ->setStock($dayChallenge['stock'])
                    ->setAction($action)
                ;

                $entityManager->persist($challenge);
                $entityManager->flush($challenge);
            } catch (UniqueConstraintViolationException $exception) {
                $logger->error($exception->getMessage());
            } catch (\Exception $exception) {
                $logger->error($exception->getMessage());
            }
        } else {
            $logger->error('User not found');
            throw new NotFoundHttpException('User not found');
        }

        return new RedirectResponse("/challenge");
    }
}
