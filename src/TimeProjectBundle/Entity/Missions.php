<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Missions
 *
 * @ORM\Table(name="missions", indexes={@ORM\Index(name="idSociete_idx", columns={"idSociete"})})
 * @ORM\Entity
 */
class Missions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idMissions", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmissions;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=45, nullable=true)
     */
    private $intitule;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_employe", type="integer", nullable=true)
     */
    private $totalEmploye;

    /**
     * @var \Societe
     *
     * @ORM\ManyToOne(targetEntity="Societe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSociete", referencedColumnName="idSociete")
     * })
     */
    private $idsociete;



    /**
     * Get idmissions
     *
     * @return integer
     */
    public function getIdmissions()
    {
        return $this->idmissions;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Missions
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Missions
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Missions
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set totalEmploye
     *
     * @param integer $totalEmploye
     *
     * @return Missions
     */
    public function setTotalEmploye($totalEmploye)
    {
        $this->totalEmploye = $totalEmploye;

        return $this;
    }

    /**
     * Get totalEmploye
     *
     * @return integer
     */
    public function getTotalEmploye()
    {
        return $this->totalEmploye;
    }

    /**
     * Set idsociete
     *
     * @param \TimeProjectBundle\Entity\Societe $idsociete
     *
     * @return Missions
     */
    public function setIdsociete(\TimeProjectBundle\Entity\Societe $idsociete = null)
    {
        $this->idsociete = $idsociete;

        return $this;
    }

    /**
     * Get idsociete
     *
     * @return \TimeProjectBundle\Entity\Societe
     */
    public function getIdsociete()
    {
        return $this->idsociete;
    }
}
