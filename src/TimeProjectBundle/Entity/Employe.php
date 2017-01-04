<?php

namespace TimeProjectBundle\Entity;

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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
    private $iduser;

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
     * Get idemploye
     *
     * @return integer
     */
    public function getIdemploye()
    {
        return $this->idemploye;
    }

    /**
     * Set iduser
     *
     * @param \TimeProjectBundle\Entity\User $iduser
     *
     * @return Employe
     */
    public function setIduser(\TimeProjectBundle\Entity\User $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \TimeProjectBundle\Entity\User
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set idsociete
     *
     * @param \TimeProjectBundle\Entity\Societe $idsociete
     *
     * @return Employe
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
