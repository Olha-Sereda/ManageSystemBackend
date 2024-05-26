<?php

namespace App\Entity;

use App\Repository\TestsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestsRepository::class)]
class Tests
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $test_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $test_code = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $expected_answer = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datetime_update = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enabled = null;

    #[ORM\ManyToOne(inversedBy: 'test_relation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\OneToMany(mappedBy: 'test_id', targetEntity: TestResultLog::class, orphanRemoval: true)]
    private Collection $Test_log_result_relation;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    public function __construct()
    {
        $this->Test_log_result_relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestName(): ?string
    {
        return $this->test_name;
    }

    public function setTestName(string $test_name): static
    {
        $this->test_name = $test_name;

        return $this;
    }

    public function getTestCode(): ?string
    {
        return $this->test_code;
    }

    public function setTestCode(?string $test_code): static
    {
        $this->test_code = $test_code;

        return $this;
    }

    public function getExpectedAnswer(): ?string
    {
        return $this->expected_answer;
    }

    public function setExpectedAnswer(?string $expected_answer): static
    {
        $this->expected_answer = $expected_answer;

        return $this;
    }

    public function getDatetimeUpdate(): ?\DateTimeInterface
    {
        return $this->datetime_update;
    }

    public function setDatetimeUpdate(?\DateTimeInterface $datetime_update): static
    {
        $this->datetime_update = $datetime_update;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection<int, TestResultLog>
     */
    public function getTestLogResultRelation(): Collection
    {
        return $this->Test_log_result_relation;
    }

    public function addTestLogResultRelation(TestResultLog $testLogResultRelation): static
    {
        if (!$this->Test_log_result_relation->contains($testLogResultRelation)) {
            $this->Test_log_result_relation->add($testLogResultRelation);
            $testLogResultRelation->setTestId($this);
        }

        return $this;
    }

    public function removeTestLogResultRelation(TestResultLog $testLogResultRelation): static
    {
        if ($this->Test_log_result_relation->removeElement($testLogResultRelation)) {
            // set the owning side to null (unless already changed)
            if ($testLogResultRelation->getTestId() === $this) {
                $testLogResultRelation->setTestId(null);
            }
        }

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

        return $this;
    }
}
