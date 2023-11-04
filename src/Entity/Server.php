<?php

namespace App\Entity;

use App\Repository\ServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
class Server
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $server_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fqdn = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $ip_address = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $login = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password_key = null;

    #[ORM\OneToMany(mappedBy: 'server_id', targetEntity: Service::class, orphanRemoval: true)]
    private Collection $service_relation;

    public function __construct()
    {
        $this->service_relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServerName(): ?string
    {
        return $this->server_name;
    }

    public function setServerName(?string $server_name): static
    {
        $this->server_name = $server_name;

        return $this;
    }

    public function getFqdn(): ?string
    {
        return $this->fqdn;
    }

    public function setFqdn(?string $fqdn): static
    {
        $this->fqdn = $fqdn;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    public function setIpAddress(?string $ip_address): static
    {
        $this->ip_address = $ip_address;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPasswordKey(): ?string
    {
        return $this->password_key;
    }

    public function setPasswordKey(?string $password_key): static
    {
        $this->password_key = $password_key;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServiceRelation(): Collection
    {
        return $this->service_relation;
    }

    public function addServiceRelation(Service $serviceRelation): static
    {
        if (!$this->service_relation->contains($serviceRelation)) {
            $this->service_relation->add($serviceRelation);
            $serviceRelation->setServerId($this);
        }

        return $this;
    }

    public function removeServiceRelation(Service $serviceRelation): static
    {
        if ($this->service_relation->removeElement($serviceRelation)) {
            // set the owning side to null (unless already changed)
            if ($serviceRelation->getServerId() === $this) {
                $serviceRelation->setServerId(null);
            }
        }

        return $this;
    }
}
