<?php

namespace App\Entity;

use App\Enum\IssueSeverity;
use App\Enum\IssueStatus;
use App\Enum\IssueType;
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

    #[ORM\Column(type: Types::INTEGER, enumType: IssueType::class)]
    #[Assert\NotBlank]
    #[Assert\Choice([IssueType::FEATURE, IssueType::BUG])]
    private ?IssueType $type = null;

    #[ORM\Column(type: Types::INTEGER, enumType: IssueStatus::class)]
    #[Assert\NotBlank]
    #[Assert\Choice([IssueStatus::OPEN, IssueStatus::CLOSED, IssueStatus::IN_PROGRESS, IssueStatus::RESOLVED])]
    private ?IssueStatus $status = null;

    #[ORM\Column(type: Types::INTEGER, enumType: IssueSeverity::class)]
    #[Assert\NotBlank]
    #[Assert\Choice([IssueSeverity::LOW, IssueSeverity::MEDIUM, IssueSeverity::HIGH])]
    private ?IssueSeverity $severity = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\PrePersist]
    public final function prePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public final function preUpdate(): void
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

    public function getType(): ?IssueType
    {
        return $this->type;
    }

    public function setType(?IssueType $type): void
    {
        $this->type = $type;
    }

    public function getStatus(): ?IssueStatus
    {
        return $this->status;
    }

    public function setStatus(?IssueStatus $status): void
    {
        $this->status = $status;
    }

    public function getSeverity(): ?IssueSeverity
    {
        return $this->severity;
    }

    public function setSeverity(?IssueSeverity $severity): void
    {
        $this->severity = $severity;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
