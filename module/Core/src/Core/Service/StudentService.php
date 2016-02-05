<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * 
 */

namespace Core\Service;

use Exception;

/*
 * Description of StudentService
 * @author Marten Kähr <marten@kahr.ee>
 */

class StudentService extends AbstractBaseService
{
    protected $baseEntity = 'Core\Entity\Student';
    /**
     * 
     * @param stdClass $params
     * @return array
     */
    public function GetList($params, $extra = null)
    {
        return parent::GetList($params, $extra);
    }
    
    /**
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return type
     */
    public function Get($params, $extra = null)
    {
        return parent::Get($params, $extra);
    }
    /**
     * 
     * @param array $data
     * @return array
     */
    public function Create($data, $extra = null)
    {
        return parent::Create($data, $extra);
    }
    /**
     * 
     * @param int|string $id
     * @param array $data
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Update($id, $data, $extra = null)
    {
        return parent::Update($id, $data, $extra);
    }
    /**
     * 
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Delete($id, $extra = null)
    {
        return parent::Delete($id, $extra);
    }
}