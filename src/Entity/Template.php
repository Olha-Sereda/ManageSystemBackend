<?php

namespace App\Entity;

use App\Repository\TemplateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateRepository::class)]
class Template
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $template_name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $test_code = null;

    #[ORM\Column(length: 255)]
    private ?string $expected_answer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTemplateName(): ?string
    {
        return $this->template_name;
    }

    public function setTemplateName(string $template_name): static
    {
        $this->template_name = $template_name;

        return $this;
    }

    public function getTestCode(): ?string
    {
        return $this->test_code;
    }

    public function setTestCode(string $test_code): static
    {
        $this->test_code = $test_code;

        return $this;
    }

    public function getExpectedAnswer(): ?string
    {
        return $this->expected_answer;
    }

    public function setExpectedAnswer(string $expected_answer): static
    {
        $this->expected_answer = $expected_answer;

        return $this;
    }
}
