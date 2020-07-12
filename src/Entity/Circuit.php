<?php

namespace App\Entity;

use App\Repository\CircuitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CircuitRepository::class)
 */
class Circuit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * * @ORM\JoinColumn(name="iid", referencedColumnName="id",onDelete="CASCADE")
     */
    private $code_circuit;

    /**
     * @ORM\Column(type="string", length=255)
     * * @ORM\JoinColumn(name="code", referencedColumnName="id",onDelete="CASCADE")
     */
    private $des_circuit;

    /**
     * @ORM\Column(type="integer")
     * * @ORM\JoinColumn(name="des_cir", referencedColumnName="id",onDelete="CASCADE")
     */
    private $duree_circuit;

    /**
     * @ORM\OneToMany(targetEntity=Etape::class, mappedBy="circuit_etape", orphanRemoval=true )
     * @ORM\JoinColumn(name="etapes", referencedColumnName="id",onDelete="CASCADE")
     */
    private $etapes;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeCircuit(): ?string
    {
        return $this->code_circuit;
    }

    public function setCodeCircuit(string $code_circuit): self
    {
        $this->code_circuit = $code_circuit;

        return $this;
    }

    public function getDesCircuit(): ?string
    {
        return $this->des_circuit;
    }

    public function setDesCircuit(string $des_circuit): self
    {
        $this->des_circuit = $des_circuit;

        return $this;
    }

    public function getDureeCircuit(): ?int
    {
        return $this->duree_circuit;
    }

    public function setDureeCircuit(int $duree_circuit): self
    {
        $this->duree_circuit = $duree_circuit;

        return $this;
    }

    /**
     * @return Collection|Etape[]
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): self
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes[] = $etape;
            $etape->setCircuitEtape($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): self
    {
        if ($this->etapes->contains($etape)) {
            $this->etapes->removeElement($etape);
            // set the owning side to null (unless already changed)
            if ($etape->getCircuitEtape() === $this) {
                $etape->setCircuitEtape(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->des_circuit;
    }
}
