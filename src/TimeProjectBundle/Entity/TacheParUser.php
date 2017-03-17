<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TacheParUser
 *
 * @ORM\Table(name="tache_par_user", indexes={@ORM\Index(name="fk_user_id", columns={"fk_user"}), @ORM\Index(name="fk_tache_id", columns={"fk_tache"})})
 * @ORM\Entity
 */
class TacheParUser
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
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var \Tache
     *
     * @ORM\ManyToOne(targetEntity="Tache")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_tache", referencedColumnName="id")
     * })
     */
    private $fkTache;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_user", referencedColumnName="id")
     * })
     */
    private $fkUser;



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
     * Set duree
     *
     * @param integer $duree
     *
     * @return TacheParUser
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set fkTache
     *
     * @param \TimeProjectBundle\Entity\Tache $fkTache
     *
     * @return TacheParUser
     */
    public function setFkTache(\TimeProjectBundle\Entity\Tache $fkTache = null)
    {
        $this->fkTache = $fkTache;

        return $this;
    }

    /**
     * Get fkTache
     *
     * @return \TimeProjectBundle\Entity\Tache
     */
    public function getFkTache()
    {
        return $this->fkTache;
    }

    /**
     * Set fkUser
     *
     * @param \TimeProjectBundle\Entity\User $fkUser
     *
     * @return TacheParUser
     */
    public function setFkUser(\TimeProjectBundle\Entity\User $fkUser = null)
    {
        $this->fkUser = $fkUser;

        return $this;
    }

    /**
     * Get fkUser
     *
     * @return \TimeProjectBundle\Entity\User
     */
    public function getFkUser()
    {
        return $this->fkUser;
    }
}
