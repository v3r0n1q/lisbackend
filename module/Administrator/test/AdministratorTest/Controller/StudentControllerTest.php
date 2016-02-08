<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * 
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\StudentController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Description of StudentControllerTest
 * 
 * @author Marten Kähr <marten@kahr.ee>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class StudentControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new StudentController();
        parent::setUp();
    }

    public function testCreate()
    {
        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');

        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('personalCode', $code);
        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(1, $result->success);
        $repository = $this->em->getRepository('Core\Entity\Student');
        $newStudent = $repository->find($result->data['id']);
        $this->assertNotNull($newStudent->getCreatedAt());
    }

    public function testCreateNoFirstName()
    {
//        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');


//        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('personalCode', $code);
        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertNotEquals(1, $result->success);
    }

    public function testCreateNoLastName()
    {
        $firstName = 'studentFirstName' . uniqid();
//        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');

        $this->request->getPost()->set('firstName', $firstName);
//        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('personalCode', $code);
        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertNotEquals(1, $result->success);
    }

    public function testCreateNoCode()
    {
        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
//        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');


        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
//        $this->request->getPost()->set('personalCode', $code);
        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertNotEquals(1, $result->success);
    }

    public function testCreateNoEmail()
    {

        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
//        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');


        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('personalCode', $code);
//        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertNotEquals(1, $result->success);
    }

    /**
     * TEST row gets read by id
     */
    public function testGet()
    {

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateStudent()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * TEST rows get read
     */
    public function testGetList()
    {
        $this->CreateStudent();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * TEST row gets updated by id
     */
    public function testUpdate()
    {
        //create student
        $entity = $this->CreateStudent();
        $id = $entity->getId();

        $firstNameOld = $entity->getFirstName();
        $lastNameOld = $entity->getLastName();
        $codeOld = $entity->getPersonalCode();
        $emailOld = $entity->getEmail();


        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            'firstName' => 'Updated',
            'lastName' => 'Updated',
            'personalCode' => uniqid(),
            'email' => 'Updated',
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\Student')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $firstNameOld, $r->getFirstName()
        );
        $this->assertNotEquals(
                $lastNameOld, $r->getLastName()
        );
        $this->assertNotEquals(
                $codeOld, $r->getPersonalCode()
        );
        $this->assertNotEquals(
                $emailOld, $r->getEmail()
        );
    }

    /**
     * TEST row gets deleted by id
     */
    public function testDelete()
    {
        $entity = $this->CreateStudent();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Student')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);
    }

    /**
     * TEST rows get read by limit and page params
     */
    public function testGetListWithPaginaton()
    {
        $this->request->setMethod('get');

        //create 2 entities
        $this->CreateStudent();
        $this->CreateStudent();

        //set record limit to 1
        $q = 'page=1&limit=1'; //imitate real param format
        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
    }

}
