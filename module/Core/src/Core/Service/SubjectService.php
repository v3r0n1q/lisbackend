<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Service;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectService extends AbstractBaseService
{

    /**
     *
     * @var type 
     */
    protected $baseEntity = 'Core\Entity\Subject';

    /**
     * 
     * @param type $id
     * @param type $data
     * @param type $extra
     * @return type
     */
    public function Update($id, $data, $extra = null)
    {
        return parent::Update($id, $data, $extra);
    }

}
