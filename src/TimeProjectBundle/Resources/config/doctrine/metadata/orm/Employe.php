<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Employe
 *
 * @ORM\Table(name="employe", indexes={@ORM\Index(name="idUser_idx", columns={"idUser"}), @ORM\Index(name="idSociete_idx", columns={"idSociete"})})
 * @ORM\Entity
 */
class Employe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEmploye", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idemploye;

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
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
    private $iduser;


}

