<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace StudentTest\Controller;

use Student\Controller\StudentInGroupsController;
use StudentTest\UnitHelpers;

/**
 * @author Kristen Sepp <seppkristen@gmail>
 */

class StudentInGroupsControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new StudentInGroupsController();
        parent::setUp();
    }

    /**
     * NOT ALLOWED
     */
    public function testCreate()
    {
        
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * NOT ALLOWED
     */
    public function testUpdate()
    {
        $this->routeMatch->setParam('id', 1); //fake id no need for real id
        $this->request->setMethod('put');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * NOT ALLOWED
     */
    public function testDelete()
    {
        $this->routeMatch->setParam('id', 1); //fake id no need for real id
        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * TEST rows get read
     */
    public function testGetListSelfRelated()
    {
        //create studentuser
        $studentGroup = $this->CreateStudentGroup();
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);
        
        
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);
        
        //create student in groups with this specific student
        $this->CreateStudentInGroups([
                    'status' => rand(0, 1),
                    'studentGroup' => $studentGroup->getId(),
                    'student' => $student->getId(),
        ]);
        
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //can be exactly one
        $this->assertEquals(1, count($result->data));
        $this->assertEquals($student->getId(), $result->data[0]['student']['id']);
    }
    
    public function testGetListNotSelfRelated()
    {
        $studentGroup = $this->CreateStudentGroup();
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);
        
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);
        
        $studentInGroups = $this->CreateStudentInGroups([
                    'status' => rand(0, 1),
                    'studentGroup' => $studentGroup->getId(),
                    'student' => $student->getId(),
        ]);
        $this->em->persist($studentInGroups);
        $this->em->flush($studentInGroups);
        
        $anotherStudent = $this->CreateStudent();
        $anotherLisUser = $this->CreateStudentUser($anotherStudent);

        $this->controller->setLisUser($anotherLisUser);
        $this->controller->setLisPerson($anotherStudent);
        
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertEquals(0, count($result->data));
    }

    /**
     * TEST row gets read by id
     */
    public function testGetSelfRelated()
    {
        //create studentuser
        $studentGroup = $this->CreateStudentGroup();
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);
        
        
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);
        
        //create student in groups with this specific student
        $studentInGroups = $this->CreateStudentInGroups([
                    'status' => rand(0, 1),
                    'studentGroup' => $studentGroup->getId(),
                    'student' => $student->getId(),
        ]);
        
        $this->em->persist($studentInGroups);
        $this->em->flush($studentInGroups);
        
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $studentInGroups->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertEquals($student->getId(), $result->data['student']['id']);
    }
    
    public function testGetNotSelfRelated()
    {
        //create studentuser
        $studentGroup = $this->CreateStudentGroup();
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);
        
        
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);
        
        //create student in groups with this specific student
        $anotherStudent = $this->CreateStudent();
        $studentInGroups = $this->CreateStudentInGroups([
                    'status' => rand(0, 1),
                    'studentGroup' => $studentGroup->getId(),
                    'student' => $anotherStudent->getId(),
                    'createdBy'=> $lisUser->getId()
        ]);
        $this->em->persist($studentInGroups);
        $this->em->flush($studentInGroups);
        
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $studentInGroups->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_RELATED_RESTRICTION', $result->message);
    }

}