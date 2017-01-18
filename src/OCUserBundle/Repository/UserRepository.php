<?php

namespace OCUserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    
    public function findExempleJan()
    {
        $result = $this->getEntityManager()->getRepository('OCUserBundle:User')->findBy(['username' => ['janany', 'karine']]);
        
        return $result;
    }
    
}
