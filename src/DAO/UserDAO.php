<?php

namespace TimeProject\DAO;

use Doctrine\DBAL\Connection;
use TimeProject\Domain\User;

class UserDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Return a list of all articles, sorted by date (most recent first).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "select * from user";
        $result = $this->db->fetchAll($sql);

        // Convert query result to an array of domain objects
        $users = array();
        foreach ($result as $row) {
            $userId = $row['idUser'];
            $users[$userId] = $this->buildUser($row);
        }
        return $users;
    }

    /**
     * Creates an Article object based on a DB row.
     *
     * @param array $row The DB row containing Article data.
     * @return \TimeProject\Domain\User
     */
    private function buildUser(array $row) {
        $user = new User();
        $user->setId($row['idUser']);
        $user->setNom($row['nom']);
        $user->setPrenom($row['prenom']);
        return $user;
    }
}