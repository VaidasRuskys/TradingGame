<?php

namespace App\Controller;

use App\Entity\Chalange;
use App\Entity\User;
use App\Service\Challenge\DayChallengeProvider;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
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
     * @return Response
     */
    public function choice(
        Request $request,
        DayChallengeProvider $challengeProvider,
        EntityManager $entityManager
    ) {
        $user = $this->getUser();
        $action = $request->get('action');
        $dayChallengeId = $request->get('day_challenge_id');

        if (!$dayChallengeId) {
            throw new BadRequestException('challenge not found');
        }

        if (!$action) {
            throw new BadRequestException('action not found');
        }

        if ($user instanceof User) {
            try {
                $dayChallenge = $challengeProvider->getDayChallenge();

                if ($dayChallengeId !== $dayChallenge['id']) {
                   throw new \Exception('Challenge not active');
                }

                $challenge = new Chalange();
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
            } catch (\Exception $exception) {

            }


        } else {
            throw new NotFoundHttpException('User not found');
        }

        return new RedirectResponse("/challenge");
    }
}
