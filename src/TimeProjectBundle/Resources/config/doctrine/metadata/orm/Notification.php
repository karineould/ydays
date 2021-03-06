<?php



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


}

