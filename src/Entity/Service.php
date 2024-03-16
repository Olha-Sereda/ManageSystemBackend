<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $service_name = null;

    #[ORM\ManyToOne(inversedBy: 'service_relation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Server $server_id = null;

    #[ORM\OneToMany(mappedBy: 'service_id', targetEntity: TestResultLog::class)]
    private Collection $Test_result_log;

    #[ORM\ManyToMany(targetEntity: Tests::class)]
    private Collection $Relation_Service_Tests;

    

    public function __construct()
    {
        $this->Test_result_log = new ArrayCollection();
        $this->Relation_Service_Tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->service_name;
    }

    public function setServiceName(?string $service_name): static
    {
        $this->service_name = $service_name;

        return $this;
    }

    public function getServerId(): ?Server
    {
        return $this->server_id;
    }

    public function setServerId(?Server $server_id): static
    {
        $this->server_id = $server_id;

        return $this;
    }

    /**
     * @return Collection<int, TestResultLog>
     */
    public function getTestResultLog(): Collection
    {
        return $this->Test_result_log;
    }

    public function addTestResultLog(TestResultLog $testResultLog): static
    {
        if (!$this->Test_result_log->contains($testResultLog)) {
            $this->Test_result_log->add($testResultLog);
            $testResultLog->setServiceId($this);
        }

        return $this;
    }

    public function removeTestResultLog(TestResultLog $testResultLog): static
    {
        if ($this->Test_result_log->removeElement($testResultLog)) {
            // set the owning side to null (unless already changed)
            if ($testResultLog->getServiceId() === $this) {
                $testResultLog->setServiceId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tests>
     */
    public function getRelationServiceTests(): Collection
    {
        return $this->Relation_Service_Tests;
    }

    public function addRelationServiceTest(Tests $relationServiceTest): static
    {
        if (!$this->Relation_Service_Tests->contains($relationServiceTest)) {
            $this->Relation_Service_Tests->add($relationServiceTest);
        }

        return $this;
    }

    public function removeRelationServiceTest(Tests $relationServiceTest): static
    {
        $this->Relation_Service_Tests->removeElement($relationServiceTest);

        return $this;
    }
}
