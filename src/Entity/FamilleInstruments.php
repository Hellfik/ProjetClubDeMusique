<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilleInstrumentsRepository")
 */
class FamilleInstruments
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Instruments", mappedBy="familleInstruments")
     */
    private $instrument;

    public function __construct()
    {
        $this->instrument = new ArrayCollection();
    }

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Instruments[]
     */
    public function getInstrument(): Collection
    {
        return $this->instrument;
    }

    public function addInstrument(Instruments $instrument): self
    {
        if (!$this->instrument->contains($instrument)) {
            $this->instrument[] = $instrument;
            $instrument->setFamilleInstruments($this);
        }

        return $this;
    }

    public function removeInstrument(Instruments $instrument): self
    {
        if ($this->instrument->contains($instrument)) {
            $this->instrument->removeElement($instrument);
            // set the owning side to null (unless already changed)
            if ($instrument->getFamilleInstruments() === $this) {
                $instrument->setFamilleInstruments(null);
            }
        }

        return $this;
    }
}
