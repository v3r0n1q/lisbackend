<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Teacher\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectController extends AbstractBaseController
{
    
    /**
     *
     * @var type 
     */
    protected $service = 'subject_service';

    /**
     * <h2>GET student/subject</h2>
     * <h3>URL Parameters</h3>
     * <code>limit(integer)
     * page(integer)</code>
     * 
     * @return JsonModel
     */
    public function getList()
    {
        return parent::getList();
    }

    /**
     * <h2>GET student/subject/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id)
    {
        return parent::get($id);
    }

    /**
     * <h2>POST student/subject</h2>
     * <h3>Body</h3>
     * <code> code(string)*
     * name(string)*
     * durationAllAK(integer)*
     * durationContactAK(integer)*
     * durationIndependentAK(intiger)*
     * module(int)*
     * gradingType(int)*</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::notAllowed();
    }

    /**
     * <h2>PUT student/subject/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code> code(string)*
     * name(string)*
     * durationAllAK(integer)*
     * durationContactAK(integer)*
     * durationIndependentAK(intiger)*
     * module(int)*
     * gradingType(int)*</code>
     * @param int $id
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::notAllowed();
    }

    /**
     * <h2>DELETE student/subject/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * 
     * @param int $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return parent::notAllowed();
    }

}