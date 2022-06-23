<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Participants
 *
 * @ORM\Table(name="participants", uniqueConstraints={@ORM\UniqueConstraint(name="participants_pseudo_uk", columns={"pseudo"})}, indexes={@ORM\Index(name="participants_sites_fk", columns={"sites_no_site"})})
 * @ORM\Entity(repositoryClass=ParticipantsRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Participants implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="no_participant", type="integer", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="pseudo", type="string", length=30, nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=15, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(name="mail", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(name="roles", type="json", nullable=false)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(name="mot_de_passe", type="string", length=250, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoFilename;

    /**
     * @var Sites
     *
     * @ORM\ManyToOne(targetEntity="Sites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sites_no_site", referencedColumnName="no_site")
     * })
     */
    private $sitesNoSite;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Sorties", mappedBy="participantsNoParticipant")
     */
    private $sortiesNoSortie;

    /**
     * @ORM\OneToMany(targetEntity=Inscriptions::class, mappedBy="participantsNoParticipant")
     */
    private $inscriptions;

    public function __toString() {

        return $this->pseudo;

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sortiesNoSortie = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotoFilename(): ?string
    {
        return $this->photoFilename;
    }

    /**
     * @param mixed $photoFilename
     */
    public function setPhotoFilename($photoFilename): void
    {
        $this->photoFilename = $photoFilename;
    }
    
    public function getSitesNoSite(): ?Sites
    {
        return $this->sitesNoSite;
    }

    public function setSitesNoSite(?Sites $sitesNoSite): self
    {
        $this->sitesNoSite = $sitesNoSite;

        return $this;
    }

    /**
     * @return Collection<int, Sorties>
     */
    public function getSortiesNoSortie(): Collection
    {
        return $this->sortiesNoSortie;
    }

    public function addSortiesNoSortie(Sorties $sortiesNoSortie): self
    {
        if (!$this->sortiesNoSortie->contains($sortiesNoSortie)) {
            $this->sortiesNoSortie[] = $sortiesNoSortie;
            $sortiesNoSortie->addParticipantsNoParticipant($this);
        }

        return $this;
    }

    public function removeSortiesNoSortie(Sorties $sortiesNoSortie): self
    {
        if ($this->sortiesNoSortie->removeElement($sortiesNoSortie)) {
            $sortiesNoSortie->removeParticipantsNoParticipant($this);
        }

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $inscription->setParticipantsNoParticipant($this);
        }

        return $this;
    }

    public function removeInscription(Inscriptions $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getParticipantsNoParticipant() === $this) {
                $inscription->setParticipantsNoParticipant(null);
            }
        }

        return $this;
    }

}
