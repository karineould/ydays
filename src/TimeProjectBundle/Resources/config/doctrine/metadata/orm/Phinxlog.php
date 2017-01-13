<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Phinxlog
 *
 * @ORM\Table(name="phinxlog")
 * @ORM\Entity
 */
class Phinxlog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="migration_name", type="string", length=100, nullable=true)
     */
    private $migrationName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=false)
     */
    private $startTime = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=false)
     */
    private $endTime = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="breakpoint", type="boolean", nullable=false)
     */
    private $breakpoint = '0';


}

