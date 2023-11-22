<?php

namespace App\Entity;

use App\Repository\ParticipanteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParticipanteRepository::class)]
class Participante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El nombre es obligatorio')]
    private ?string $nombre = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message: 'El JID es obligatorio')]
    private ?string $jid = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El score es obligatorio')]
    private ?string $score = null;

    #[ORM\ManyToOne(inversedBy: 'participantes')]
    #[Assert\NotBlank(message: 'El lider es obligatorio')]
    private ?Leader $leader = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getJid(): ?string
    {
        return $this->jid;
    }

    public function setJid(string $jid): self
    {
        $this->jid = $jid;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getLeader(): ?Leader
    {
        return $this->leader;
    }

    public function setLeader(?Leader $leader): self
    {
        $this->leader = $leader;

        return $this;
    }
}
