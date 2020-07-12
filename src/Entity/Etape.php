<?php

namespace App\Entity;

use App\Repository\EtapeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtapeRepository::class)
 */
class Etape
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="etapes")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\joinColumn(onDelete="SET NULL")
     */
    private $ville_etape;

    /**
     * @ORM\ManyToOne(targetEntity=Circuit::class, inversedBy="etapes")
     * @ORM\JoinColumn(nullable=false)
     
     */
    private $circuit_etape;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_etape;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre_etape;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleEtape(): ?Ville
    {
        return $this->ville_etape;
    }

    public function setVilleEtape(?Ville $ville_etape): self
    {
        $this->ville_etape = $ville_etape;

        return $this;
    }

    public function getCircuitEtape(): ?Circuit
    {
        return $this->circuit_etape;
    }

    public function setCircuitEtape(?Circuit $circuit_etape): self
    {
        $this->circuit_etape = $circuit_etape;

        return $this;
    }

    public function getDureeEtape(): ?int
    {
        return $this->duree_etape;
    }

    public function setDureeEtape(int $duree_etape): self
    {
        $this->duree_etape = $duree_etape;

        return $this;
    }

    public function getOrdreEtape(): ?int
    {
        return $this->ordre_etape;
    }

    public function setOrdreEtape(int $ordre_etape): self
    {
        $this->ordre_etape = $ordre_etape;

        return $this;
    }
}
