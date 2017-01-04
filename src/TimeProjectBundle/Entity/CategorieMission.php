<?php

namespace TimeProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieMission
 *
 * @ORM\Table(name="categorie_mission")
 * @ORM\Entity
 */
class CategorieMission
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCategorie_mission", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorieMission;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=45, nullable=true)
     */
    private $couleur;



    /**
     * Get idcategorieMission
     *
     * @return integer
     */
    public function getIdcategorieMission()
    {
        return $this->idcategorieMission;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return CategorieMission
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     *
     * @return CategorieMission
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }
}
