<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={@ORM\Index(name="vocationname", columns={"name"}),@ORM\Index(name="vocationcode", columns={"code"})}
 * )
 */
class Vocation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=false)
     */
    protected $code;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $durationEKAP;

    /**
     * @ORM\OneToOne(targetEntity="Group", mappedBy="vocation")
     */
    protected $group;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="vocation")
     */
    protected $module;

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

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
