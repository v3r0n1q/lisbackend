<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;
use Core\Utils\EntityValidation;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\VocationRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="vocationname", columns={"name"}),@ORM\Index(name="vocationcode", columns={"code"})}
 * )
 */
class Vocation extends EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $code;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Annotation\Required({"required":"true"})
     */
    protected $durationEKAP;

    /**
     * @ORM\OneToMany(targetEntity="StudentGroup", mappedBy="vocation")
     */
    protected $studentGroup;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="vocation")
     */
    protected $module;

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct($em);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getDurationEKAP()
    {
        return $this->durationEKAP;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setDurationEKAP($durationEKAP)
    {
        $this->durationEKAP = $durationEKAP;
        return $this;
    }

    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

}
