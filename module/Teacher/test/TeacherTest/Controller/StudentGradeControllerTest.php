<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace TeacherTest\Controller;

use Teacher\Controller\StudentGradeController;
use Zend\Json\Json;
use TeacherTest\UnitHelpers;

/**
 * Description of StudentGradeControllerTest
 *
 * @author Marten Kähr
 */
class StudentGradeControllerTest extends UnitHelpers
{
    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new StudentGradeController();
        parent::setUp();
    }
    
//    /**
//     * should be successful
//     */
//    public function testCreate()
//    {
//        //create and set correct teacheruser
//        $teacher = $this->CreateTeacher();
//        $lisUser = $this->CreateTeacherUser($teacher);
//
//        //set to current controller
//        $this->controller->setLisUser($lisUser);
//        $this->controller->setLisPerson($teacher);
//
//        //add data
//        $notes = 'Notes' . uniqid();
//        $this->request->setMethod('post');
//        $this->request->getPost()->set('notes', $notes);
//        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
//        $this->request->getPost()->set('gradechoice', $this->CreateContactLesson()->getId());
//        $this->request->getPost()->set('teacher', $teacher->getId());
//        $this->request->getPost()->set('independentwork', $this->CreateIndependentWork()->getId());
//        $this->request->getPost()->set('module', $this->CreateModule()->getId());
//        $this->request->getPost()->set('subjectround', $this->CreateSubjectRound()->getId());
//        $this->request->getPost()->set('contactlesson', $this->CreateContactLesson()->getId());
//
//        //fire request
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, false);
//
//        //make assertions
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(true, (bool) $result->success);
//    }
    
    /**
     * should be successful
     */
    public function testUpdateOwnRelated()
    {
        //create student user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);
        
        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create original data
        $notes = 'Notes' . uniqid();
        $student = $this->CreateStudent();
        $gradeChoice = $this->CreateGradeChoice();
        $independentWork = $this->CreateIndependentWork();
        $module = $this->CreateModule();
        $subjectRound = $this->CreateSubjectRound();
        $contactLesson = $this->CreateContactLesson();
        
        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'gradeChoice' => $gradeChoice->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $independentWork->getId(),
            'module' => $module->getId(),
            'subjectRound' => $subjectRound->getId(),
            'contactLesson' => $contactLesson->getId()
        ]);

        $studentIdOld = $studentGrade->getStudent()->getId();
        $gradeChoiceIdOld = $studentGrade->getGradeChoice()->getId();
        $teacherIdOld = $studentGrade->getTeacher()->getId();
        $independentWorkIdOld = $studentGrade->getIndependentWork()->getId();
        $moduleIdOld = $studentGrade->getModule()->getId();
        $subjectRoundIdOld = $studentGrade->getSubjectRound()->getId();
        $contactLessonIdOld = $studentGrade->getContactLesson()->getId();
        

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $studentGrade->getId());

        $this->request->setContent(http_build_query([
            'student' => $this->CreateStudent()->getId(),
            'gradeChoice' => $this->CreateGradeChoice()->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $this->CreateIndependentWork(),
            'module' => $this->CreateModule()->getId(),
            'subjectRound' => $this->CreateSubjectRound(),
            'contactLesson' => $this->CreateContactLesson()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //for student should be the same - self related restriction
        $this->assertEquals($teacherIdOld, $result->data['teacher']['id']);
        
        $this->assertNotEquals($studentIdOld, $result->data['student']['id']);
        $this->assertNotEquals($independentWorkIdOld, $result->data['independentWork']['id']);
        $this->assertNotEquals($gradeChoiceIdOld, $result->data['gradeChoice']['id']);
        $this->assertNotEquals($moduleIdOld, $result->data['module']['id']);
        $this->assertNotEquals($subjectRoundIdOld, $result->data['subjectRound']['id']);
        $this->assertNotEquals($contactLessonIdOld, $result->data['contactLesson']['id']);
    }
    
    
}
