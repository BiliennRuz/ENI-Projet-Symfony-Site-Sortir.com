<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="inscriptions", indexes={@ORM\Index(name="inscriptions_sorties_fk", columns={"sorties_no_sortie"}), @ORM\Index(name="inscriptions_participants_fk", columns={"participants_no_participant"})})
 * @ORM\Entity(repositoryClass=InscriptionsRepository::class)
 */
class Inscriptions
{

    /**
     * @ORM\Column(type="datetime")
     *  
     */
    private $dateInscription;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Sorties::class, inversedBy="inscriptions")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="sorties_no_sortie", referencedColumnName="no_sortie")
     * })
     */
    private $sortiesNoSortie;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Participants::class, inversedBy="inscriptions")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="participants_no_participant", referencedColumnName="no_participant")
     * })
     */
    private $participantsNoParticipant;

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getSortiesNoSortie(): ?Sorties
    {
        return $this->sortiesNoSortie;
    }

    public function setSortiesNoSortie(?Sorties $sortiesNoSortie): self
    {
        $this->sortiesNoSortie = $sortiesNoSortie;

        return $this;
    }

    public function getParticipantsNoParticipant(): ?Participants
    {
        return $this->participantsNoParticipant;
    }

    public function setParticipantsNoParticipant(?Participants $participantsNoParticipant): self
    {
        $this->participantsNoParticipant = $participantsNoParticipant;

        return $this;
    }
}
