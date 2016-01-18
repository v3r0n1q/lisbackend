<?php

namespace Administrator;

return [

    'controllers' => [

        'invokables' => [
            'Administrator\Controller\Vocation' => 'Administrator\Controller\VocationController',
            'Administrator\Controller\Module' => 'Administrator\Controller\ModuleController',
            'Administrator\Controller\Moduletype' => 'Administrator\Controller\ModuletypeController',
            'Administrator\Controller\Gradingtype' => 'Administrator\Controller\GradingtypeController',
            'Administrator\Controller\Subject' => 'Administrator\Controller\SubjectController',
            'Administrator\Controller\AbsenceReason' => 'Administrator\Controller\AbsenceReasonController',
            'Administrator\Controller\Absence' => 'Administrator\Controller\AbsenceController',
            'Administrator\Controller\StudentGroup' => 'Administrator\Controller\StudentGroupController',
            'Administrator\Controller\Room' => 'Administrator\Controller\RoomController',
            'Administrator\Controller\Teacher' => 'Administrator\Controller\TeacherController',
            'Administrator\Controller\IndependentWork' => 'Administrator\Controller\IndependentWorkController',
            'Administrator\Controller\GradeIndependentWork' => 'Administrator\Controller\GradeIndependentWorkController',
        ],
    ],
    'router' => [
        'routes' => [
            'RestAdministrator' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin[/:controller][/:id]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Administrator\Controller',
                        'controller' => 'Administrator\Controller\Vocation',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
