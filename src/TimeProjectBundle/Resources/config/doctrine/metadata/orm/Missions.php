<?php



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


}

