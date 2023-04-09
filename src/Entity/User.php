<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'creatorId', targetEntity: Session::class, orphanRemoval: true)]
    private Collection $ownedSessions;

    public function __construct()
    {
        $this->ownedSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Session>
     */
    public function getOwnedSessions(): Collection
    {
        return $this->ownedSessions;
    }

    public function addOwnedSession(Session $ownedSession): self
    {
        if (!$this->ownedSessions->contains($ownedSession)) {
            $this->ownedSessions->add($ownedSession);
            $ownedSession->setCreatorId($this);
        }

        return $this;
    }

    public function removeOwnedSession(Session $ownedSession): self
    {
        if ($this->ownedSessions->removeElement($ownedSession)) {
            // set the owning side to null (unless already changed)
            if ($ownedSession->getCreatorId() === $this) {
                $ownedSession->setCreatorId(null);
            }
        }

        return $this;
    }
}
