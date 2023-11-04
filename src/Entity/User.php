<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
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

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $user_name = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $user_surname = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Tests::class)]
    private Collection $test_relation;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: TestResultLog::class)]
    private Collection $test_log_result_relation;

    public function __construct()
    {
        $this->Test_relation = new ArrayCollection();
        $this->test_relation = new ArrayCollection();
        $this->test_log_result_relation = new ArrayCollection();
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

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(?string $user_name): static
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserSurname(): ?string
    {
        return $this->user_surname;
    }

    public function setUserSurname(?string $user_surname): static
    {
        $this->user_surname = $user_surname;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->user_password;
    }

    public function setUserPassword(?string $user_password): static
    {
        $this->user_password = $user_password;

        return $this;
    }

    /**
     * @return Collection<int, Tests>
     */
    public function getTestRelation(): Collection
    {
        return $this->Test_relation;
    }

    public function addTestRelation(Tests $testRelation): static
    {
        if (!$this->Test_relation->contains($testRelation)) {
            $this->Test_relation->add($testRelation);
            $testRelation->setUserId($this);
        }

        return $this;
    }

    public function removeTestRelation(Tests $testRelation): static
    {
        if ($this->Test_relation->removeElement($testRelation)) {
            // set the owning side to null (unless already changed)
            if ($testRelation->getUserId() === $this) {
                $testRelation->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TestResultLog>
     */
    public function getTestLogResultRelation(): Collection
    {
        return $this->test_log_result_relation;
    }

    public function addTestLogResultRelation(TestResultLog $testLogResultRelation): static
    {
        if (!$this->test_log_result_relation->contains($testLogResultRelation)) {
            $this->test_log_result_relation->add($testLogResultRelation);
            $testLogResultRelation->setUserId($this);
        }

        return $this;
    }

    public function removeTestLogResultRelation(TestResultLog $testLogResultRelation): static
    {
        if ($this->test_log_result_relation->removeElement($testLogResultRelation)) {
            // set the owning side to null (unless already changed)
            if ($testLogResultRelation->getUserId() === $this) {
                $testLogResultRelation->setUserId(null);
            }
        }

        return $this;
    }
}
