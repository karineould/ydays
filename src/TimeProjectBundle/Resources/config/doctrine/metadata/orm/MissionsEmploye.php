<?php



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
     * @var \Employe
     *
     * @ORM\ManyToOne(targetEntity="Employe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmploye", referencedColumnName="idEmploye")
     * })
     */
    private $idemploye;

    /**
     * @var \Missions
     *
     * @ORM\ManyToOne(targetEntity="Missions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMission", referencedColumnName="idMissions")
     * })
     */
    private $idmission;


}

