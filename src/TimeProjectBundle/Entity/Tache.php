<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table(name="tache", indexes={@ORM\Index(name="fk_projet", columns={"fk_projet"}), @ORM\Index(name="redacteur", columns={"redacteur"})})
 * @ORM\Entity
 */
class Tache
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var integer
     *
     * @ORM\Column(name="priorite", type="integer", nullable=true)
     */
    private $priorite;

    /**
     * @var \Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_projet", referencedColumnName="id")
     * })
     */
    private $fkProjet;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="redacteur", referencedColumnName="id")
     * })
     */
    private $redacteur;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Tache
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Tache
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Tache
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set priorite
     *
     * @param integer $priorite
     *
     * @return Tache
     */
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;

        return $this;
    }

    /**
     * Get priorite
     *
     * @return integer
     */
    public function getPriorite()
    {
        return $this->priorite;
    }

    /**
     * Set fkProjet
     *
     * @param \TimeProjectBundle\Entity\Projet $fkProjet
     *
     * @return Tache
     */
    public function setFkProjet(\TimeProjectBundle\Entity\Projet $fkProjet = null)
    {
        $this->fkProjet = $fkProjet;

        return $this;
    }

    /**
     * Get fkProjet
     *
     * @return \TimeProjectBundle\Entity\Projet
     */
    public function getFkProjet()
    {
        return $this->fkProjet;
    }

    /**
     * Set redacteur
     *
     * @param \TimeProjectBundle\Entity\User $redacteur
     *
     * @return Tache
     */
    public function setRedacteur(\TimeProjectBundle\Entity\User $redacteur = null)
    {
        $this->redacteur = $redacteur;

        return $this;
    }

    /**
     * Get redacteur
     *
     * @return \TimeProjectBundle\Entity\User
     */
    public function getRedacteur()
    {
        return $this->redacteur;
    }
}
