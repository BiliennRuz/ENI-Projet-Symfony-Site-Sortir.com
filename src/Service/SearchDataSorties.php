<?php
namespace App\Service;

use App\Entity\Sites;

class SearchDataSorties
{

    /**
     * @var Sites
     */
    public $sites;

    /**
     * @var string
     */
    public $nom = '';

    /**
     * @var \DateTime
     */
    public $dateDebut;

    /**
     * @var \DateTime
     */
    public $dateFin;

    /**
     * @var boolean
     */
    public $isOrganisateur = false;

    /**
     * @var boolean
     */
    public $isInscrit = false;

    /**
     * @var boolean
     */
    public $isnotInscrit = false;

    /**
     * @var boolean
     */
    public $isSortiePassee = false;

}