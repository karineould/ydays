<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Societe
 *
 * @ORM\Table(name="societe", indexes={@ORM\Index(name="idSecteur_idx", columns={"idSecteur_societe"}), @ORM\Index(name="idAdmin_idx", columns={"idAdmin"}), @ORM\Index(name="idAdresse", columns={"idAdresse"})})
 * @ORM\Entity
 */
class Societe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idSociete", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsociete;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", length=20, nullable=true)
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=20, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="site_web", type="string", length=100, nullable=true)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_juridique", type="string", length=50, nullable=true)
     */
    private $statutJuridique;

    /**
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAdmin", referencedColumnName="idAdmin")
     * })
     */
    private $idadmin;

    /**
     * @var \SecteurSociete
     *
     * @ORM\ManyToOne(targetEntity="SecteurSociete")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSecteur_societe", referencedColumnName="idSecteur_societe")
     * })
     */
    private $idsecteurSociete;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAdresse", referencedColumnName="id")
     * })
     */
    private $idadresse;


}

