<?php

namespace App\Controller;

use App\Entity\Issue;
use App\Repository\IssueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/issue', format: 'json')]
class IssueController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly IssueRepository $issueRepository
    ) {
    }

    #[Route(path: '/', methods: ['GET'])]
    public final function issueList(): Response
    {
        return $this->json([
            'status' => Response::HTTP_OK,
            'data' => $this->issueRepository->findAll(),
        ]);
    }

    #[Route(path: '/{id}', methods: ['GET'])]
    public final function issueSingle(Issue $issue): Response
    {
        return $this->json([
            'status' => Response::HTTP_OK,
            'data' => $issue,
        ]);
    }

    #[route('/', methods: ['POST'])]
    public final function issueCreate(#[MapRequestPayload] Issue $issue): Response
    {
        $this->entityManager->persist($issue);
        $this->entityManager->flush();

        return $this->json([
            'status' => Response::HTTP_OK,
            'message' => 'Created successfully',
        ]);
    }

    #[route('/{id}', methods: ['PATCH'])]
    public final function issueUpdate(Issue $issue, #[MapRequestPayload] Issue $newIssue): Response
    {
        $issue->setTitle($newIssue->getTitle());
        $issue->setDescription($newIssue->getDescription());
        $issue->setType($newIssue->getType());
        $issue->setStatus($newIssue->getStatus());
        $issue->setSeverity($newIssue->getSeverity());

        $this->entityManager->flush();

        return $this->json([
            'status' => Response::HTTP_OK,
            'message' => 'Updated successfully',
        ]);
    }

    #[Route(path: '/{id}', methods: ['DELETE'])]
    public final function issueDelete(Issue $issue): Response
    {
        $this->entityManager->remove($issue);
        $this->entityManager->flush();

        return $this->json([
            'status' => Response::HTTP_OK,
            'message' => 'Delete successfully',
        ]);
    }
}