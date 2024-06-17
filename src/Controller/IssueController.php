<?php

namespace App\Controller;

use App\Entity\Issue;
use App\Repository\IssueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route(path: '/issue', format: 'json')]
class IssueController extends AbstractController
{
    private IssueRepository $issueRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        IssueRepository $issueRepository
    ) {
        $this->entityManager = $entityManager;
        $this->issueRepository = $issueRepository;
    }

    #[Route(path: '/', methods: ['GET'])]
    public final function issueList(): Response
    {
        return $this->json([
            'status' => 'success',
            'data' => $this->issueRepository->findAll(),
        ]);
    }

    #[Route(path: '/{id}', methods: ['GET'])]
    public final function issueSingle(Issue $issue): Response
    {
        return $this->json([
            'status' => 'success',
            'data' => $issue,
        ]);
    }

    #[route('/', methods: ['POST'])]
    public final function issueCreate(#[MapRequestPayload] Issue $issue): Response
    {
        $this->entityManager->persist($issue);
        $this->entityManager->flush();

        return $this->json([
            'status' => 'success',
            'message' => 'Created successfully',
        ]);
    }

    #[route('/{id}', methods: ['PUT'])]
    public final function issueUpdate(Uuid $id, #[MapRequestPayload] Issue $newIssue): Response
    {
        $issue = $this->issueRepository->find($id);

        $issue->setTitle($newIssue->getTitle());
        $issue->setDescription($newIssue->getDescription());
        $this->entityManager->flush();

        return $this->json([
            'status' => 'success',
            'message' => 'Updated successfully',
        ]);
    }

    #[Route(path: '/{id}', methods: ['DELETE'])]
    public final function issueDelete(Issue $issue): Response
    {
        $this->entityManager->remove($issue);
        $this->entityManager->flush();

        return $this->json([
            'status' => 'success',
            'message' => 'Delete successfully',
        ]);
    }
}