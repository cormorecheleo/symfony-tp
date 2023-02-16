<?php

namespace App\Entity;

use App\Repository\MembersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembersRepository::class)]
class Members
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'members')]
    private Collection $user_id;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'members')]
    private Collection $group_id;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->group_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        $this->user_id->removeElement($userId);

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
        }

        return $this;
    }

    public function removeGroupId(Group $groupId): self
    {
        $this->group_id->removeElement($groupId);

        return $this;
    }
}
