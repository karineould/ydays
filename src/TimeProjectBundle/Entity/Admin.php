<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin", indexes={@ORM\Index(name="idUser_idx", columns={"idUser"}), @ORM\Index(name="idSociete_idx", columns={"idSociete"})})
 * @ORM\Entity
 */
class Admin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idAdmin", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idadmin;

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



    /**
     * Get idadmin
     *
     * @return integer
     */
    public function getIdadmin()
    {
        return $this->idadmin;
    }

    /**
     * Set idsociete
     *
     * @param \TimeProjectBundle\Entity\Societe $idsociete
     *
     * @return Admin
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

    /**
     * Set iduser
     *
     * @param \TimeProjectBundle\Entity\Users $iduser
     *
     * @return Admin
     */
    public function setIduser(\TimeProjectBundle\Entity\Users $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \TimeProjectBundle\Entity\Users
     */
    public function getIduser()
    {
        return $this->iduser;
    }
}
