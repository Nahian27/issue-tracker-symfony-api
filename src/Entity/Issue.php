<?php

namespace App\Entity;

use App\Enum\Severity;
use App\Enum\Status;
use App\Repository\IssueRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IssueRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Issue
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(min: 3)]
    #[Assert\NotIdenticalTo(propertyPath: "title", message: "Description can't match the title")]
    private ?string $description = null;

    #[ORM\Column(type: Types::INTEGER, enumType: Status::class)]
    #[Assert\NotBlank]
    #[Assert\Choice([Status::OPEN, Status::CLOSED, Status::IN_PROGRESS, Status::RESOLVED])]
    private ?Status $status = null;

    #[ORM\Column(type: Types::INTEGER, enumType: Severity::class)]
    #[Assert\NotBlank]
    #[Assert\Choice([Severity::LOW, Severity::MEDIUM, Severity::HIGH])]
    private ?Severity $severity = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): void
    {
        $this->status = $status;
    }

    public function getSeverity(): ?Severity
    {
        return $this->severity;
    }

    public function setSeverity(?Severity $severity): void
    {
        $this->severity = $severity;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
