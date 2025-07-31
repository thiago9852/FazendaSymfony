<?php

namespace App\Entity;

use App\Repository\GadoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GadoRepository::class)]
class Gado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $codigo = null;

    #[ORM\Column]
    private ?float $peso = null;

    #[ORM\Column]
    private ?float $racao = null;

    #[ORM\Column]
    private ?float $leite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $nascimento = null;

    #[ORM\Column(nullable: true)]
    private ?bool $abate = null;

    #[ORM\ManyToOne(inversedBy: 'gados')]
    private ?Fazenda $fazenda = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): static
    {
        $this->peso = $peso;

        return $this;
    }

    public function getRacao(): ?float
    {
        return $this->racao;
    }

    public function setRacao(float $racao): static
    {
        $this->racao = $racao;

        return $this;
    }

    public function getLeite(): ?float
    {
        return $this->leite;
    }

    public function setLeite(float $leite): static
    {
        $this->leite = $leite;

        return $this;
    }

    public function getNascimento(): ?\DateTime
    {
        return $this->nascimento;
    }

    public function setNascimento(\DateTime $nascimento): static
    {
        $this->nascimento = $nascimento;

        return $this;
    }

    public function isAbate(): ?bool
    {
        return $this->abate;
    }

    public function setAbate(?bool $abate): static
    {
        $this->abate = $abate;

        return $this;
    }

    public function getFazenda(): ?Fazenda
    {
        return $this->fazenda;
    }

    public function setFazenda(?Fazenda $fazenda): static
    {
        $this->fazenda = $fazenda;

        return $this;
    }

}
