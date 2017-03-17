<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification", indexes={@ORM\Index(name="idSociete_idx", columns={"idAdmin"})})
 * @ORM\Entity
 */
class Notification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idNotification", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idnotification;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule_titre", type="string", length=45, nullable=true)
     */
    private $intituleTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=45, nullable=true)
     */
    private $contenu;

    /**
     * @var integer
     *
     * @ORM\Column(name="isValidation", type="integer", nullable=false)
     */
    private $isvalidation;

    /**
     * @var string
     *
     * @ORM\Column(name="idDate", type="string", length=45, nullable=true)
     */
    private $iddate;

    /**
     * @var string
     *
     * @ORM\Column(name="idMission", type="string", length=45, nullable=true)
     */
    private $idmission;

    /**
     * @var string
     *
     * @ORM\Column(name="idCategorie_mission", type="string", length=45, nullable=true)
     */
    private $idcategorieMission;

    /**
     * @var string
     *
     * @ORM\Column(name="idEmploye", type="string", length=45, nullable=true)
     */
    private $idemploye;

    /**
     * @var integer
     *
     * @ORM\Column(name="idSociete", type="integer", nullable=true)
     */
    private $idsociete;

    /**
     * @var integer
     *
     * @ORM\Column(name="idAdmin", type="integer", nullable=true)
     */
    private $idadmin;



    /**
     * Get idnotification
     *
     * @return integer
     */
    public function getIdnotification()
    {
        return $this->idnotification;
    }

    /**
     * Set intituleTitre
     *
     * @param string $intituleTitre
     *
     * @return Notification
     */
    public function setIntituleTitre($intituleTitre)
    {
        $this->intituleTitre = $intituleTitre;

        return $this;
    }

    /**
     * Get intituleTitre
     *
     * @return string
     */
    public function getIntituleTitre()
    {
        return $this->intituleTitre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Notification
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set isvalidation
     *
     * @param integer $isvalidation
     *
     * @return Notification
     */
    public function setIsvalidation($isvalidation)
    {
        $this->isvalidation = $isvalidation;

        return $this;
    }

    /**
     * Get isvalidation
     *
     * @return integer
     */
    public function getIsvalidation()
    {
        return $this->isvalidation;
    }

    /**
     * Set iddate
     *
     * @param string $iddate
     *
     * @return Notification
     */
    public function setIddate($iddate)
    {
        $this->iddate = $iddate;

        return $this;
    }

    /**
     * Get iddate
     *
     * @return string
     */
    public function getIddate()
    {
        return $this->iddate;
    }

    /**
     * Set idmission
     *
     * @param string $idmission
     *
     * @return Notification
     */
    public function setIdmission($idmission)
    {
        $this->idmission = $idmission;

        return $this;
    }

    /**
     * Get idmission
     *
     * @return string
     */
    public function getIdmission()
    {
        return $this->idmission;
    }

    /**
     * Set idcategorieMission
     *
     * @param string $idcategorieMission
     *
     * @return Notification
     */
    public function setIdcategorieMission($idcategorieMission)
    {
        $this->idcategorieMission = $idcategorieMission;

        return $this;
    }

    /**
     * Get idcategorieMission
     *
     * @return string
     */
    public function getIdcategorieMission()
    {
        return $this->idcategorieMission;
    }

    /**
     * Set idemploye
     *
     * @param string $idemploye
     *
     * @return Notification
     */
    public function setIdemploye($idemploye)
    {
        $this->idemploye = $idemploye;

        return $this;
    }

    /**
     * Get idemploye
     *
     * @return string
     */
    public function getIdemploye()
    {
        return $this->idemploye;
    }

    /**
     * Set idsociete
     *
     * @param integer $idsociete
     *
     * @return Notification
     */
    public function setIdsociete($idsociete)
    {
        $this->idsociete = $idsociete;

        return $this;
    }

    /**
     * Get idsociete
     *
     * @return integer
     */
    public function getIdsociete()
    {
        return $this->idsociete;
    }

    /**
     * Set idadmin
     *
     * @param integer $idadmin
     *
     * @return Notification
     */
    public function setIdadmin($idadmin)
    {
        $this->idadmin = $idadmin;

        return $this;
    }

    /**
     * Get idadmin
     *
     * @return integer
     */
    public function getIdadmin()
    {
        return $this->idadmin;
    }
}
