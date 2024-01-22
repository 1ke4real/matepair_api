<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Stringable
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $details = null;

    #[ORM\Column(nullable: true)]
    private ?array $favorite_games = null;

    #[ORM\Column(nullable: true)]
    private ?array $play_schedule = null;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Message::class)]
    private Collection $send;

    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: Message::class)]
    private Collection $receive;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Notification::class)]
    private Collection $notifications;

    #[ORM\OneToMany(mappedBy: 'user_first', targetEntity: Matche::class)]
    private Collection $first;

    #[ORM\OneToMany(mappedBy: 'user_second', targetEntity: Matche::class)]
    private Collection $second;

    #[ORM\ManyToMany(targetEntity: WeekDay::class, inversedBy: 'users')]
    private Collection $weekDays;

    #[ORM\ManyToMany(targetEntity: TimeDay::class, inversedBy: 'users')]
    private Collection $timeDays;

    public function __construct()
    {
        $this->send = new ArrayCollection();
        $this->receive = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->first = new ArrayCollection();
        $this->second = new ArrayCollection();
        $this->weekDays = new ArrayCollection();
        $this->timeDays = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUsername() ?? 'N/A';
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getFavoriteGames(): ?array
    {
        return $this->favorite_games;
    }

    public function setFavoriteGames(?array $favorite_games): static
    {
        $this->favorite_games = $favorite_games;

        return $this;
    }

    public function getPlaySchedule(): ?array
    {
        return $this->play_schedule;
    }

    public function setPlaySchedule(?array $play_schedule): static
    {
        $this->play_schedule = $play_schedule;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getSend(): Collection
    {
        return $this->send;
    }

    public function addSend(Message $send): static
    {
        if (!$this->send->contains($send)) {
            $this->send->add($send);
            $send->setSender($this);
        }

        return $this;
    }

    public function removeSend(Message $send): static
    {
        if ($this->send->removeElement($send)) {
            // set the owning side to null (unless already changed)
            if ($send->getSender() === $this) {
                $send->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getReceive(): Collection
    {
        return $this->receive;
    }

    public function addReceive(Message $receive): static
    {
        if (!$this->receive->contains($receive)) {
            $this->receive->add($receive);
            $receive->setReceiver($this);
        }

        return $this;
    }

    public function removeReceive(Message $receive): static
    {
        if ($this->receive->removeElement($receive)) {
            // set the owning side to null (unless already changed)
            if ($receive->getReceiver() === $this) {
                $receive->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setUserId($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getUserId() === $this) {
                $notification->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matche>
     */
    public function getFirst(): Collection
    {
        return $this->first;
    }

    public function addFirst(Matche $first): static
    {
        if (!$this->first->contains($first)) {
            $this->first->add($first);
            $first->setUserFirst($this);
        }

        return $this;
    }

    public function removeFirst(Matche $first): static
    {
        if ($this->first->removeElement($first)) {
            // set the owning side to null (unless already changed)
            if ($first->getUserFirst() === $this) {
                $first->setUserFirst(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matche>
     */
    public function getSecond(): Collection
    {
        return $this->second;
    }

    public function addSecond(Matche $second): static
    {
        if (!$this->second->contains($second)) {
            $this->second->add($second);
            $second->setUserSecond($this);
        }

        return $this;
    }

    public function removeSecond(Matche $second): static
    {
        if ($this->second->removeElement($second)) {
            // set the owning side to null (unless already changed)
            if ($second->getUserSecond() === $this) {
                $second->setUserSecond(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WeekDay>
     */
    public function getWeekDays(): Collection
    {
        return $this->weekDays;
    }

    public function addWeekDay(WeekDay $weekDay): static
    {
        if (!$this->weekDays->contains($weekDay)) {
            $this->weekDays->add($weekDay);
        }

        return $this;
    }

    public function removeWeekDay(WeekDay $weekDay): static
    {
        $this->weekDays->removeElement($weekDay);

        return $this;
    }

    /**
     * @return Collection<int, TimeDay>
     */
    public function getTimeDays(): Collection
    {
        return $this->timeDays;
    }

    public function addTimeDay(TimeDay $timeDay): static
    {
        if (!$this->timeDays->contains($timeDay)) {
            $this->timeDays->add($timeDay);
        }

        return $this;
    }

    public function removeTimeDay(TimeDay $timeDay): static
    {
        $this->timeDays->removeElement($timeDay);

        return $this;
    }
}
