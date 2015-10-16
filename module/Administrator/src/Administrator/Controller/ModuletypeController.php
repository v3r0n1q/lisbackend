<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * @author sander
 */
class ModuletypeController extends AbstractBaseController
{

    /**
     * POST
     * 
     * @param type $data
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('moduletype_service')
                        ->Create($data)
        );
    }

    /**
     * GET
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('moduletype_service')
                        ->Get($id)
        );
    }

    /**
     * GET
     * 
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('moduletype_service')
                        ->GetList()
        );
    }

    /**
     * PUT
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('moduletype_service')
                        ->Update($id, $data)
        );
    }

    /**
     * DELETE
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function delete($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('moduletype_service')
                        ->Delete($id)
        );
    }

}