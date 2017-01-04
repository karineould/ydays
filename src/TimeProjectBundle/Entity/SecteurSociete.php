<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SecteurSociete
 *
 * @ORM\Table(name="secteur_societe")
 * @ORM\Entity
 */
class SecteurSociete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idSecteur_societe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsecteurSociete;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_secteur", type="string", length=45, nullable=true)
     */
    private $nomSecteur;



    /**
     * Get idsecteurSociete
     *
     * @return integer
     */
    public function getIdsecteurSociete()
    {
        return $this->idsecteurSociete;
    }

    /**
     * Set nomSecteur
     *
     * @param string $nomSecteur
     *
     * @return SecteurSociete
     */
    public function setNomSecteur($nomSecteur)
    {
        $this->nomSecteur = $nomSecteur;

        return $this;
    }

    /**
     * Get nomSecteur
     *
     * @return string
     */
    public function getNomSecteur()
    {
        return $this->nomSecteur;
    }
}
