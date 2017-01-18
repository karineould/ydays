<?php
/**
 * Created by PhpStorm.
 * User: Karine
 * Date: 18/01/2017
 * Time: 15:22
 */

namespace TimeProjectBundle\Repository;

use TimeProjectBundle\Entity\Admin;
use Doctrine\ORM\EntityRepository;



class AdminRepository extends EntityRepository {
    
    
    public function getByName($name)
    {
        $admin = new Admin();
        

        $admin = $this->_em->getRepository('TimeProjectBundle:Admin')->findBy(['idAdmin' => 1, "idUser" => 1]);
        
        return $admin; 
    }


}