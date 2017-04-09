<?php



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


}

