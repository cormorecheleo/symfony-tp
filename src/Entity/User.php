<?php

namespace App\Entity;

use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    private ?string $nickname = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'owner_id', targetEntity: Group::class, orphanRemoval: true)]
    private Collection $ownedGroups;

    #[ORM\OneToMany(mappedBy: 'owner_id', targetEntity: Thread::class)]
    private Collection $ownedThreads;

    #[ORM\ManyToMany(targetEntity: Members::class, mappedBy: 'user_id')]
    private Collection $members;

    #[ORM\OneToOne(mappedBy: 'owner_id', cascade: ['persist', 'remove'])]
    private ?Message $message = null;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?GroupRequest $userGroupRequest = null;

    public function __construct()
    {
        $this->ownedGroups = new ArrayCollection();
        $this->ownedThreads = new ArrayCollection();
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

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

    /**
     * @return Collection<int, Group>
     */
    public function getOwnedGroups(): Collection
    {
        return $this->ownedGroups;
    }

    public function addOwnedGroup(Group $ownedGroup): self
    {
        if (!$this->ownedGroups->contains($ownedGroup)) {
            $this->ownedGroups->add($ownedGroup);
            $ownedGroup->setOwnerId($this);
        }

        return $this;
    }

    public function removeOwnedGroup(Group $ownedGroup): self
    {
        if ($this->ownedGroups->removeElement($ownedGroup)) {
            // set the owning side to null (unless already changed)
            if ($ownedGroup->getOwnerId() === $this) {
                $ownedGroup->setOwnerId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Thread>
     */
    public function getOwnedThreads(): Collection
    {
        return $this->ownedThreads;
    }

    public function addOwnedThread(Thread $ownedThread): self
    {
        if (!$this->ownedThreads->contains($ownedThread)) {
            $this->ownedThreads->add($ownedThread);
            $ownedThread->setOwnerId($this);
        }

        return $this;
    }

    public function removeOwnedThread(Thread $ownedThread): self
    {
        if ($this->ownedThreads->removeElement($ownedThread)) {
            // set the owning side to null (unless already changed)
            if ($ownedThread->getOwnerId() === $this) {
                $ownedThread->setOwnerId(null);
            }
        }

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
            $member->addUserId($this);
        }

        return $this;
    }

    public function removeMember(Members $member): self
    {
        if ($this->members->removeElement($member)) {
            $member->removeUserId($this);
        }

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): self
    {
        // set the owning side of the relation if necessary
        if ($message->getOwnerId() !== $this) {
            $message->setOwnerId($this);
        }

        $this->message = $message;

        return $this;
    }

    public function getUserGroupRequest(): ?GroupRequest
    {
        return $this->userGroupRequest;
    }

    public function setUserGroupRequest(GroupRequest $userGroupRequest): self
    {
        // set the owning side of the relation if necessary
        if ($userGroupRequest->getUserId() !== $this) {
            $userGroupRequest->setUserId($this);
        }

        $this->userGroupRequest = $userGroupRequest;

        return $this;
    }
}
