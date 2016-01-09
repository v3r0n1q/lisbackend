<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Entity\Repository;

use Core\Entity\Administrator;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * AdministratorRepository
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class AdministratorRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param array|null $params
     * @param stdClass|null $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null)
    {
        
    }

    /**
     * 
     * @param int $id
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {
        
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return Vocation|array
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = new Administrator($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "SELECT 
                        partial administrator.{
                            id,
                            firstName,
                            code,
                            durationEKAP
                        }
                    FROM Core\Entity\Administrator administrator
                    WHERE vocation.id = " . $entity->getId();

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
    }

    /**
     * 
     * @param int|string $id
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     * @throws Exception
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        
    }

    /**
     * 
     * @param int $id
     * @param type $extra
     * @return int
     */
    public function Delete($id, $extra = null)
    {
        
    }

}
