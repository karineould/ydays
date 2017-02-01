<?php

namespace TimeProjectBundle\Entity;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Societe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Societe
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set portable
     *
     * @param string $portable
     *
     * @return Societe
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return string
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Societe
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     *
     * @return Societe
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set statutJuridique
     *
     * @param string $statutJuridique
     *
     * @return Societe
     */
    public function setStatutJuridique($statutJuridique)
    {
        $this->statutJuridique = $statutJuridique;

        return $this;
    }

    /**
     * Get statutJuridique
     *
     * @return string
     */
    public function getStatutJuridique()
    {
        return $this->statutJuridique;
    }

    /**
     * Set idadmin
     *
     * @param \TimeProjectBundle\Entity\Admin $idadmin
     *
     * @return Societe
     */
    public function setIdadmin(\TimeProjectBundle\Entity\Admin $idadmin = null)
    {
        $this->idadmin = $idadmin;

        return $this;
    }

    /**
     * Get idadmin
     *
     * @return \TimeProjectBundle\Entity\Admin
     */
    public function getIdadmin()
    {
        return $this->idadmin;
    }

    /**
     * Set idsecteurSociete
     *
     * @param \TimeProjectBundle\Entity\SecteurSociete $idsecteurSociete
     *
     * @return Societe
     */
    public function setIdsecteurSociete(\TimeProjectBundle\Entity\SecteurSociete $idsecteurSociete = null)
    {
        $this->idsecteurSociete = $idsecteurSociete;

        return $this;
    }

    /**
     * Get idsecteurSociete
     *
     * @return \TimeProjectBundle\Entity\SecteurSociete
     */
    public function getIdsecteurSociete()
    {
        return $this->idsecteurSociete;
    }

    /**
     * Set idadresse
     *
     * @param \TimeProjectBundle\Entity\Adresse $idadresse
     *
     * @return Societe
     */
    public function setIdadresse(\TimeProjectBundle\Entity\Adresse $idadresse = null)
    {
        $this->idadresse = $idadresse;

        return $this;
    }

    /**
     * Get idadresse
     *
     * @return \TimeProjectBundle\Entity\Adresse
     */
    public function getIdadresse()
    {
        return $this->idadresse;
    }
}
