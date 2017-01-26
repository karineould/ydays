<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MissionsEmploye
 *
 * @ORM\Table(name="missions_employe", indexes={@ORM\Index(name="idEmploye_idx", columns={"idEmploye"}), @ORM\Index(name="idMission_idx", columns={"idMission"})})
 * @ORM\Entity
 */
class MissionsEmploye
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idMissions_employe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmissionsEmploye;

    /**
     * @var \Missions
     *
     * @ORM\ManyToOne(targetEntity="Missions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMission", referencedColumnName="idMissions")
     * })
     */
    private $idmission;

    /**
     * @var \Employe
     *
     * @ORM\ManyToOne(targetEntity="Employe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmploye", referencedColumnName="idEmploye")
     * })
     */
    private $idemploye;



    /**
     * Get idmissionsEmploye
     *
     * @return integer
     */
    public function getIdmissionsEmploye()
    {
        return $this->idmissionsEmploye;
    }

    /**
     * Set idmission
     *
     * @param \TimeProjectBundle\Entity\Missions $idmission
     *
     * @return MissionsEmploye
     */
    public function setIdmission(\TimeProjectBundle\Entity\Missions $idmission = null)
    {
        $this->idmission = $idmission;

        return $this;
    }

    /**
     * Get idmission
     *
     * @return \TimeProjectBundle\Entity\Missions
     */
    public function getIdmission()
    {
        return $this->idmission;
    }

    /**
     * Set idemploye
     *
     * @param \TimeProjectBundle\Entity\Employe $idemploye
     *
     * @return MissionsEmploye
     */
    public function setIdemploye(\TimeProjectBundle\Entity\Employe $idemploye = null)
    {
        $this->idemploye = $idemploye;

        return $this;
    }

    /**
     * Get idemploye
     *
     * @return \TimeProjectBundle\Entity\Employe
     */
    public function getIdemploye()
    {
        return $this->idemploye;
    }
}
