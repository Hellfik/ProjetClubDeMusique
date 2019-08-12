<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstrumentsRepository")
 */
class Instruments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FamilleInstruments", inversedBy="instrument")
     * @ORM\JoinColumn(nullable=false)
     */
    private $familleInstruments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFamilleInstruments(): ?FamilleInstruments
    {
        return $this->familleInstruments;
    }

    public function setFamilleInstruments(?FamilleInstruments $familleInstruments): self
    {
        $this->familleInstruments = $familleInstruments;

        return $this;
    }
}
