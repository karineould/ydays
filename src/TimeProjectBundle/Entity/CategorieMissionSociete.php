<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieMissionSociete
 *
 * @ORM\Table(name="categorie_mission_societe", indexes={@ORM\Index(name="idCategorie_mission_idx", columns={"idCategorie_mission"}), @ORM\Index(name="idSociete_mission_idx", columns={"idSociete"})})
 * @ORM\Entity
 */
class CategorieMissionSociete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCategorie_mission_societe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorieMissionSociete;

    /**
     * @var \CategorieMission
     *
     * @ORM\ManyToOne(targetEntity="CategorieMission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCategorie_mission", referencedColumnName="idCategorie_mission")
     * })
     */
    private $idcategorieMission;

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
     * Get idcategorieMissionSociete
     *
     * @return integer
     */
    public function getIdcategorieMissionSociete()
    {
        return $this->idcategorieMissionSociete;
    }

    /**
     * Set idcategorieMission
     *
     * @param \TimeProjectBundle\Entity\CategorieMission $idcategorieMission
     *
     * @return CategorieMissionSociete
     */
    public function setIdcategorieMission(\TimeProjectBundle\Entity\CategorieMission $idcategorieMission = null)
    {
        $this->idcategorieMission = $idcategorieMission;

        return $this;
    }

    /**
     * Get idcategorieMission
     *
     * @return \TimeProjectBundle\Entity\CategorieMission
     */
    public function getIdcategorieMission()
    {
        return $this->idcategorieMission;
    }

    /**
     * Set idsociete
     *
     * @param \TimeProjectBundle\Entity\Societe $idsociete
     *
     * @return CategorieMissionSociete
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
