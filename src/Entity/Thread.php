<?php

namespace App\Entity;

use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
class Thread
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'ownedThread', targetEntity: Group::class)]
    private Collection $group_id;

    #[ORM\ManyToOne(inversedBy: 'ownedThreads')]
    private ?User $owner_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(mappedBy: 'thread_id', cascade: ['persist', 'remove'])]
    private ?Message $message = null;

    public function __construct()
    {
        $this->group_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroupId(): Collection
    {
        return $this->group_id;
    }

    public function addGroupId(Group $groupId): self
    {
        if (!$this->group_id->contains($groupId)) {
            $this->group_id->add($groupId);
            $groupId->setOwnedThread($this);
        }

        return $this;
    }

    public function removeGroupId(Group $groupId): self
    {
        if ($this->group_id->removeElement($groupId)) {
            // set the owning side to null (unless already changed)
            if ($groupId->getOwnedThread() === $this) {
                $groupId->setOwnedThread(null);
            }
        }

        return $this;
    }

    public function getOwnerId(): ?User
    {
        return $this->owner_id;
    }

    public function setOwnerId(?User $owner_id): self
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): self
    {
        // set the owning side of the relation if necessary
        if ($message->getThreadId() !== $this) {
            $message->setThreadId($this);
        }

        $this->message = $message;

        return $this;
    }
}
