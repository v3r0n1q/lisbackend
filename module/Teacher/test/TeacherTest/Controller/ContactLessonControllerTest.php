<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace TeacherTest\Controller;

use Teacher\Controller\ContactLessonController;
use Zend\Json\Json;
use TeacherTest\UnitHelpers;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class ContactLessonTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new ContactLessonController();
        parent::setUp();
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoData()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created teacher set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, (bool) $result->success);
    }

    /**
     * Imitate POST request
     * Should be successful
     */
    public function testCreate()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created teacheruser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $this->request->setMethod('post');

        $lessonDate = new \DateTime;
        $description = ' Description for contactlesson' . uniqid();
        $sequenceNr = 4;
        $teacher_id = $this->CreateTeacher()->getId();
        $durationAK = 120;
        $subjectRound = $this->CreateSubjectRound()->getId();
        $studentGroup = $this->CreateStudentGroup()->getId();
        $module = $this->CreateModule();
        $vocation = $this->CreateVocation();
        $rooms = $this->CreateRoom();



        $this->request->getPost()->set("lessonDate", $lessonDate);
        $this->request->getPost()->set("description", $description);
        $this->request->getPost()->set("sequenceNr", $sequenceNr);
        $this->request->getPost()->set("teacher", $teacher_id);
        $this->request->getPost()->set('subjectRound', $subjectRound);
        $this->request->getPost()->set('studentGroup', $studentGroup);
        $this->request->getPost()->set('module', $module);
        $this->request->getPost()->set('vocation', $vocation);
        $this->request->getPost()->set('rooms', $rooms);
        $this->request->getPost()->set('durationAK', $durationAK);


        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false); //true

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $repository = $this->em->getRepository('Core\Entity\ContactLesson');
        $newContactLesson = $repository->find($result->data['id']);
        $this->assertNotNull($newContactLesson->getCreatedAt());
    }

    /**
     * Should be NOT successful
     */
    public function testDeleteNotTrashed()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created teacheruser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $entity = $this->CreateContactLesson();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\ContactLesson')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    /**
     * Should be successful
     */
    public function testDelete()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created teacheruser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $entity = $this->CreateContactLesson();
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\ContactLesson')
                ->find($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }

    /**
     * Should be successful
     */
    public function testUpdate()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created teacheruser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create one to  update later on
        $contactLesson = $this->CreateContactLesson();
        $id = $contactLesson->getId();

        $lessonDateO = $contactLesson->getLessonDate()->format('Y-m-d H:i:s');
        $descriptionO = $contactLesson->getDescription();
        $sequenceNrO = $contactLesson->getSequenceNr();
        $subjectRoundIdO = $contactLesson->getSubjectRound();
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $id);

        //start new data creation
        $lessonDate = (new \DateTime)
                ->add(new \DateInterval('P10D'))
                ->format('Y-m-d H:i:s');

        $description = ' Updated Description for contactlesson';
        $sequenceNr = 44;
        $subjectRound = $this->CreateSubjectRound();

        $insertData = [
            "lessonDate" => $lessonDate,
            "description" => $description,
            "sequenceNr" => $sequenceNr,
            "subjectRound" => $subjectRound->getId(),
            "teacher" => $contactLesson->getTeacher()->getId(),
        ];

        //set new data
        $this->request->setContent(http_build_query($insertData));

//        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //start checking for changed data
        $this->assertNotEquals($lessonDateO, $result->data['lessonDate']);
        $this->assertNotEquals($descriptionO, $result->data['description']);
        $this->assertNotEquals($sequenceNrO, $result->data['sequenceNr']);
        $this->assertNotEquals($subjectRoundIdO->getId(), $result->data['subjectRound']);
        $this->assertNotEquals($teacher->getId(), $result->data['teacher']);
    }

    /**
     * TEST rows get read
     */
    public function testGetList()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create one to get first
        $contactLesson = $this->CreateContactLesson();
        $id = $contactLesson->getId();
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * TEST row gets read by id
     */
    public function testGet()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateContactLesson()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * TEST rows get read by limit and page params
     */
    public function testGetListWithPaginaton()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $this->request->setMethod('get');

        //set record limit to 1
        $q = 'page=1&limit=1'; //imitate real param format
        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
        $this->PrintOut($result, false);
    }

    public function testGetTrashedListSelfRelated()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $contactLesson = $this->CreateContactLesson([
            'name' => 'contact lesson',
            'lessonDate' => new \DateTime,
            'description' => uniqid() . ' Description for contactlesson',
            'sequenceNr' => 5,
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => $teacher->getId(),
            "rooms" => $this->CreateRoom()->getId(),
            "module" => $this->CreateModule()->getId(),
            "subjectRound" => $this->CreateSubjectRound()->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        $contactLesson->setTrashed(1);
        $this->em->persist($contactLesson);
        $this->em->flush($contactLesson); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $contactLesson->getId()
        ];
        $whereJSON = Json::encode($where);
        $whereURL = urlencode($whereJSON);
        $whereURLPart = "where=$whereURL";
        $q = "page=1&limit=1&$whereURLPart"; //imitate real param format

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //limit is set to 1
        $this->assertEquals(1, count($result->data));

        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }
    
     public function testGetTrashedListNotSelfRelated()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $contactLesson = $this->CreateContactLesson([
            'name' => 'contact lesson',
            'lessonDate' => new \DateTime,
            'description' => uniqid() . ' Description for contactlesson',
            'sequenceNr' => 5,
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => $teacher->getId(),
            "rooms" => $this->CreateRoom()->getId(),
            "module" => $this->CreateModule()->getId(),
            "subjectRound" => $this->CreateSubjectRound()->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        $contactLesson->setTrashed(1);
        $this->em->persist($contactLesson);
        $this->em->flush($contactLesson); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $contactLesson->getId()
        ];
        $whereJSON = Json::encode($where);
        $whereURL = urlencode($whereJSON);
        $whereURLPart = "where=$whereURL";
        $q = "page=1&limit=1&$whereURLPart"; //imitate real param format

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        //create another user set it to controller

        $anotherTeacher = $this->CreateTeacher();
        $anotherLisUser = $this->CreateTeacherUser($anotherTeacher);

        //now we have created another studentuser set to current controller
        $this->controller->setLisUser($anotherLisUser);
        $this->controller->setLisPerson($anotherTeacher);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);


        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }

}
