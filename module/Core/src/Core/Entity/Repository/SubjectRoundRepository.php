<?php

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Core\Entity\SubjectRound;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * SubjectRoundRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubjectRoundRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return SubjectRound
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = new SubjectRound($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        //manytomany validate manually
        if (!count($entity->getTeacher())) {
            throw new Exception(Json::encode('Missing teachers', true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = " 
                    SELECT 
                        partial subjectRound.{
                            id
                        },
                        partial subject.{
                            id
                        },
                        partial studentGroup.{
                            id
                        }
                    FROM Core\Entity\SubjectRound subjectRound
                    JOIN subjectRound.subject subject
                    JOIN subjectRound.studentGroup studentGroup
                    WHERE subjectRound.id = " . $entity->getId() . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);

            return $r;
        }

        return $entity;
    }

    /**
     * 
     * @param type $id
     * @param type $extra
     */
    public function Delete($id, $extra = null)
    {
        $entity = $this->find($id);
        $entity->setTrashed(1);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $id;
    }

    /**
     * 
     * @param type $id
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {

        if ($returnPartial) {
            $dql = " 
                    SELECT 
                        partial subjectRound.{
                            id
                        },
                        partial subject.{
                            id
                        },
                        partial studentGroup.{
                            id
                        }
                    FROM Core\Entity\SubjectRound subjectRound
                    JOIN subjectRound.subject subject
                    JOIN subjectRound.studentGroup studentGroup
                    WHERE subjectRound.id = :id"
            ;

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $q->setParameter('id', $id);

            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);

            return $r;
        }
        return $this->find($id);
    }

    /**
     * 
     * @param type $params
     * @param type $extra
     */
    public function GetList($params = null, $extra = null)
    {
        
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        $entity = $this->find($id);
        $entity->setEntityManager($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }
        //manytomany validate manually
        if (!count($entity->getTeacher())) {
            throw new Exception(Json::encode('Missing teachers for subject round', true));
        }
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {
            $dql = " 
                    SELECT 
                        partial subjectRound.{
                            id
                        },
                        partial subject.{
                            id
                        },
                        partial studentGroup.{
                            id
                        },
                        partial teacher.{
                            id
                        }
                    FROM Core\Entity\SubjectRound subjectRound
                    JOIN subjectRound.subject subject
                    JOIN subjectRound.studentGroup studentGroup
                    JOIN subjectRound.teacher teacher
                    WHERE subjectRound.id = :id"
            ;

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
     
            $q->setParameter('id', $id);

            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);

            return $r;
        }
        return $entity;
    }

}