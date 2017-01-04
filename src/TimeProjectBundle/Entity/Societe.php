<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Societe
 *
 * @ORM\Table(name="societe", indexes={@ORM\Index(name="idSecteur_idx", columns={"idSecteur_societe"}), @ORM\Index(name="idAdmin_idx", columns={"idAdmin"})})
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
     * @ORM\Column(name="adresse", type="string", length=45, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="Societecol", type="string", length=45, nullable=true)
     */
    private $societecol;

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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Societe
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set societecol
     *
     * @param string $societecol
     *
     * @return Societe
     */
    public function setSocietecol($societecol)
    {
        $this->societecol = $societecol;

        return $this;
    }

    /**
     * Get societecol
     *
     * @return string
     */
    public function getSocietecol()
    {
        return $this->societecol;
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
}
