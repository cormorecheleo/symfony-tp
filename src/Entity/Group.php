<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
#[ApiResource]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ownedGroups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'group_id')]
    private ?Thread $ownedThread = null;

    #[ORM\ManyToMany(targetEntity: Members::class, mappedBy: 'group_id')]
    private Collection $members;

    #[ORM\OneToOne(mappedBy: 'group_id', cascade: ['persist', 'remove'])]
    private ?GroupRequest $groupGroupRequest = null;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

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

    public function getOwnedThread(): ?Thread
    {
        return $this->ownedThread;
    }

    public function setOwnedThread(?Thread $ownedThread): self
    {
        $this->ownedThread = $ownedThread;

        return $this;
    }

    /**
     * @return Collection<int, Members>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Members $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addGroupId($this);
        }

        return $this;
    }

    public function removeMember(Members $member): self
    {
        if ($this->members->removeElement($member)) {
            $member->removeGroupId($this);
        }

        return $this;
    }

    public function getGroupGroupRequest(): ?GroupRequest
    {
        return $this->groupGroupRequest;
    }

    public function setGroupGroupRequest(GroupRequest $groupGroupRequest): self
    {
        // set the owning side of the relation if necessary
        if ($groupGroupRequest->getGroupId() !== $this) {
            $groupGroupRequest->setGroupId($this);
        }

        $this->groupGroupRequest = $groupGroupRequest;

        return $this;
    }
}
