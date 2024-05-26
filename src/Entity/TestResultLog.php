<?php

namespace App\Entity;

use App\Repository\TestResultLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestResultLogRepository::class)]
class TestResultLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datetime_execution = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $execution_answer = null;

    #[ORM\ManyToOne(inversedBy: 'Test_result_log')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service_id = null;

    #[ORM\ManyToOne(inversedBy: 'Test_log_result_relation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tests $test_id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetimeExecution(): ?\DateTimeInterface
    {
        return $this->datetime_execution;
    }

    public function setDatetimeExecution(?\DateTimeInterface $datetime_execution): static
    {
        $this->datetime_execution = $datetime_execution;

        return $this;
    }

    public function getExecutionAnswer(): ?string
    {
        return $this->execution_answer;
    }

    public function setExecutionAnswer(?string $execution_answer): static
    {
        $this->execution_answer = $execution_answer;

        return $this;
    }

    public function getServiceId(): ?Service
    {
        return $this->service_id;
    }

    public function setServiceId(?Service $service_id): static
    {
        $this->service_id = $service_id;

        return $this;
    }

    public function getTestId(): ?Tests
    {
        return $this->test_id;
    }

    public function setTestId(?Tests $test_id): static
    {
        $this->test_id = $test_id;

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
