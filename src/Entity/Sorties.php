<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sorties
 *
 * @ORM\Table(name="sorties", indexes={@ORM\Index(name="sorties_lieux_fk", columns={"lieux_no_lieu"}), @ORM\Index(name="sorties_etats_fk", columns={"etats_no_etat"}), @ORM\Index(name="sorties_participants_fk", columns={"organisateur"})})
 * @ORM\Entity
 */
class Sorties
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_sortie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $noSortie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="datetime", nullable=false)
     */
    private $datedebut;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecloture", type="datetime", nullable=false)
     */
    private $datecloture;

    /**
     * @var int
     *
     * @ORM\Column(name="nbinscriptionsmax", type="integer", nullable=false)
     */
    private $nbinscriptionsmax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptioninfos", type="string", length=500, nullable=true)
     */
    private $descriptioninfos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="urlPhoto", type="string", length=250, nullable=true)
     */
    private $urlphoto;

    /**
     * @var Etats
     *
     * @ORM\ManyToOne(targetEntity="Etats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etats_no_etat", referencedColumnName="no_etat")
     * })
     */
    private $etatsNoEtat;

    /**
     * @var Participants
     *
     * @ORM\ManyToOne(targetEntity="Participants")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organisateur", referencedColumnName="no_participant")
     * })
     */
    private $organisateur;

    /**
     * @var Lieux
     *
     * @ORM\ManyToOne(targetEntity="Lieux")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lieux_no_lieu", referencedColumnName="no_lieu")
     * })
     */
    private $lieuxNoLieu;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Participants", inversedBy="sortiesNoSortie")
     * @ORM\JoinTable(name="inscriptions",
     *   joinColumns={
     *     @ORM\JoinColumn(name="sorties_no_sortie", referencedColumnName="no_sortie")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="participants_no_participant", referencedColumnName="no_participant")
     *   }
     * )
     */
    private $participantsNoParticipant;

    /**
     * @ORM\OneToMany(targetEntity=Inscriptions::class, mappedBy="sortiesNoSortie")
     */
    private $inscriptions;
    
    
    public function __toString() {
        return $this->nom;
    }
    

   
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participantsNoParticipant = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }

    public function getNoSortie(): ?int
    {
        return $this->noSortie;
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

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDatecloture(): ?\DateTimeInterface
    {
        return $this->datecloture;
    }

    public function setDatecloture(\DateTimeInterface $datecloture): self
    {
        $this->datecloture = $datecloture;

        return $this;
    }

    public function getNbinscriptionsmax(): ?int
    {
        return $this->nbinscriptionsmax;
    }

    public function setNbinscriptionsmax(int $nbinscriptionsmax): self
    {
        $this->nbinscriptionsmax = $nbinscriptionsmax;

        return $this;
    }

    public function getDescriptioninfos(): ?string
    {
        return $this->descriptioninfos;
    }

    public function setDescriptioninfos(?string $descriptioninfos): self
    {
        $this->descriptioninfos = $descriptioninfos;

        return $this;
    }

    public function getUrlphoto(): ?string
    {
        return $this->urlphoto;
    }

    public function setUrlphoto(?string $urlphoto): self
    {
        $this->urlphoto = $urlphoto;

        return $this;
    }

    public function getEtatsNoEtat(): ?Etats
    {
        return $this->etatsNoEtat;
    }

    public function setEtatsNoEtat(?Etats $etatsNoEtat): self
    {
        $this->etatsNoEtat = $etatsNoEtat;

        return $this;
    }

    public function getOrganisateur(): ?Participants
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participants $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getLieuxNoLieu(): ?Lieux
    {
        return $this->lieuxNoLieu;
    }

    public function setLieuxNoLieu(?Lieux $lieuxNoLieu): self
    {
        $this->lieuxNoLieu = $lieuxNoLieu;

        return $this;
    }

    /**
     * @return Collection<int, Participants>
     */
    public function getParticipantsNoParticipant(): Collection
    {
        return $this->participantsNoParticipant;
    }

    public function addParticipantsNoParticipant(Participants $participantsNoParticipant): self
    {
        if (!$this->participantsNoParticipant->contains($participantsNoParticipant)) {
            $this->participantsNoParticipant[] = $participantsNoParticipant;
        }

        return $this;
    }

    public function removeParticipantsNoParticipant(Participants $participantsNoParticipant): self
    {
        $this->participantsNoParticipant->removeElement($participantsNoParticipant);

        return $this;
    }

    /**
     * @return Collection<int, Inscriptions>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscriptions $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setSortiesNoSortie($this);
        }

        return $this;
    }

    public function removeInscription(Inscriptions $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getSortiesNoSortie() === $this) {
                $inscription->setSortiesNoSortie(null);
            }
        }

        return $this;
    }

}
