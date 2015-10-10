<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 */
class Absence extends \Core\Utils\EntityValidation
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Annotation\Required({"required":"true"})
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="AbsenceReason", inversedBy="absence")
     * @ORM\JoinColumn(name="absence_reason_id", referencedColumnName="id")
     */
    protected $absenceReason;

    /**
     * @Annotation\Required({"required":"true"})
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="absence")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     */
    protected $student;

    /**
     * @Annotation\Required({"required":"true"})
     * @ORM\ManyToOne(targetEntity="ContactLesson", inversedBy="absence")
     * @ORM\JoinColumn(name="contact_lesson_id", referencedColumnName="id", nullable=false)
     */
    protected $contactLesson;

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAbsenceReason()
    {
        return $this->absenceReason;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function getContactLesson()
    {
        return $this->contactLesson;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setAbsenceReason($absenceReason)
    {
        $this->absenceReason = $absenceReason;
        return $this;
    }

    public function setStudent($student)
    {
        $this->student = $student;
        return $this;
    }

    public function setContactLesson($contactLesson)
    {
        $this->contactLesson = $contactLesson;
        return $this;
    }

}
