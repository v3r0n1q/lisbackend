<?php

namespace Core\Utils;

use Zend\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * @author sander and Inspired by http://luci.criosweb.ro/simplify-handling-of-tables-entities-forms-and-validations-in-zf2-by-using-annotations/
 */
abstract class EntityValidation implements ArraySerializableInterface
{

    /**
     * @var array $VF
     */
    protected $VF = array();

    /**
     * @var Form
     */
    protected $form;

    /**
     *
     * @var DoctrineHydrator 
     */
    protected $doctrineHydrator;

    /**
     *
     * @var EntityManager 
     */
    public $entityManager;

    /**
     *
     * @var string
     */
    public $algoKey = "123456";

    /**
     * 
     * @return DoctrineObject
     */
    public function getDoctrineHydrator()
    {
        if ($this->doctrineHydrator === null) {
            $this->doctrineHydrator = new DoctrineHydrator(
                    $this->getEntityManager(), $this
            );
        }
        return $this->doctrineHydrator;
    }

    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * 
     * @param EntityManager $em
     * @return \Core\Utils\EntityValidation
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
        return $this;
    }

    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em = null)
    {
        if ($em != null) {
            $this->setEntityManager($em);
        }
    }

    /**
     * Returns a form for the current entity with an input filter set
     * built using the provided annotations in model
     *
     * @return Form
     */
    public function getForm()
    {
        if (empty($this->form)) {
            $builder = new AnnotationBuilder();
            $this->form = $builder->createForm($this);
            $this->form->bind($this);
        }
        return $this->form;
    }

    /**
     * Exchange internal values from provided array
     *
     * @param  array $array
     * @return void
     */
    public function exchangeArray(array $array)
    {
        $this->hydrate($array);
    }

    /**
     * Return an array representation of the object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return $this->extract();
    }

    /**
     * 
     * @param array $data
     * @return type
     */
    public function hydrate(array $data)
    {
        return $this->getDoctrineHydrator()->hydrate($data, $this);
    }

    /**
     * Extract objet to array
     * @return array
     */
    public function extract()
    {
        return $this->getDoctrineHydrator()->extract($this);
    }

    /**
     * Hydrates & validates the object
     *
     * @return bool true for no validation errors, false otherwise
     */
    public function validate($data = null)
    {
        $this->setFormData($data);
        return $this->getForm()->getInputFilter()->isValid();
    }

    /**
     * Get validation messages, if any
     * Must be called after validate
     *
     * @return array|\Traversable
     */
    public function getMessages()
    {
        return $this->getForm()->getInputFilter()->getMessages();
    }

    /**
     * Returns all of the entity's virtual field, a certain virtual field value, or null if the required virtual
     * field cannot be found
     * @param $name
     * @return mixed
     */
    public function getVF($name = null)
    {
        if ($name === null) {
            return $this->VF;
        } else if (isset($this->VF[$name])) {
            return $this->VF[$name];
        }
        return null;
    }

    /**
     * Sets a virtual field's value or adds it if it doesn't exist
     * @param $name
     * @param $value
     */
    public function setVF($name, $value)
    {
        $this->VF[$name] = $value;
    }

    /**
     * Hydrate object with $data
     *
     * @param array|Object $data
     *
     */
    protected function setFormData($data)
    {
        if (empty($data)) {
            $data = $this->extract();
        }
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        $this->getForm()->getInputFilter()->setData($data);
    }

}
