<?php

namespace TimeProject\Domain;

class User
{
    /**
     * User id.
     *
     * @var integer
     */
    private $idUser;

    /**
     * User nom.
     *
     * @var string
     */
    private $nom;

    /**
     * User prenom.
     *
     * @var string
     */
    private $prenom;

    public function getId() {
        return $this->idUser;
    }

    public function setId($id) {
        $this->idUser = $id;
        return $this;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }
}