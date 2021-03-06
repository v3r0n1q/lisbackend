/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */

/* global define */

/**
 * READ - http://brianhann.com/create-a-modal-row-editor-for-ui-grid-in-minutes/
 * http://brianhann.com/ui-grid-and-multi-select/#more-732
 * http://www.codelord.net/2015/09/24/$q-dot-defer-youre-doing-it-wrong/
 * http://stackoverflow.com/questions/25983035/angularjs-function-available-to-multiple-controllers
 * adding content later https://github.com/angular-ui/ui-grid/issues/2050
 * dropdown menu http://brianhann.com/ui-grid-and-dropdowns/
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {studentGradeController_L29.studentGradeController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {

                studentGradeController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'studentGradeModel',
                    'studentModel',
                    'teacherModel',
                    'gradeChoiceModel',
                    'independentWorkModel',
                    'moduleModel',
                    'subjectRoundModel',
                    'contactLessonModel'
                ];

                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} $routeParams
                 * @param {type} rowSorter
                 * @param {type} uiGridConstants
                 * @param {type} studentGradeModel
                 * @param {type} studentModel
                 * @param {type} teacherModel
                 * @param {type} gradeChoiceModel
                 * @param {type} independentWorkModel
                 * @returns {studentGradeController_L32.studentGradeController}
                 */
                function studentGradeController(
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        studentGradeModel,
                        studentModel,
                        teacherModel,
                        gradeChoiceModel,
                        independentWorkModel,
                        moduleModel,
                        subjectRoundModel,
                        contactLessonModel) {

                    $scope.T = globalFunctions.T;

                    /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100000 //unreal right :D think of remote pagination, see angular ui grid docs
                    };


                    /**
                     * records sceleton
                     */
                    $scope.model = {
                        id: null,
                        student: null,
                        gradeChoice: null,
                        teacher: null,
                        independentWork: null,
                        module: null,
                        subjectRound: null,
                        contactLesson: null,
                        notes: null
                    };

                    /**
                     * will hold students
                     * for grid select
                     */
                    $scope.students = [];

                    /**
                     * will hold gradeChoices
                     * for grid select
                     */
                    $scope.gradeChoices = [];

                    /**
                     * will hold teachers
                     * for grid select
                     */
                    $scope.teachers = [];

                    /**
                     * will hold independentWorks
                     * for grid select
                     */
                    $scope.independentWorks = [];//4

                    /**
                     * will hold modules
                     * for grid select
                     */
                    $scope.modules = [];

                    /**
                     * will hold subjectRounds
                     * for grid select
                     */
                    $scope.subjectRounds = [];

                    /**
                     * will hold contactLessons.
                     * for grid select
                     */
                    $scope.contactLessons = [];

                    $scope.studentGrade = {};

                    $scope.filterStudentGrade = {};//for form filters, object

                    /**
                     * Grid set up
                     */
                    $scope.gridOptions = {
                        rowHeight: 38,
                        enableCellEditOnFocus: true,
                        columnDefs: [
                            {
                                field: 'id',
                                visible: false,
                                type: 'number',
                                enableCellEdit: false,
                                sort: {
                                    direction: uiGridConstants.DESC,
                                    priority: 1
                                }
                            },
                            {
                                field: "student",
                                name: "student",
                                displayName: $scope.T('LIS_STUDENT'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered,
                                enableCellEdit: false
                            },
                            {
                                field: "gradeChoice",
                                name: "gradeChoice",
                                displayName: $scope.T('LIS_GRADECHOICE'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered,
                                enableCellEdit: false
                            },
                            {
                                field: "teacher",
                                name: "teacher",
                                displayName: $scope.T('LIS_TEACHER'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered,
                                enableCellEdit: false
                            },
                            {
                                field: "independentWork",
                                name: "independentWork",
                                displayName: $scope.T('LIS_INDEPENDENTWORK'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered,
                                enableCellEdit: false
                            },
                            {
                                field: "module",
                                name: "module",
                                displayName: $scope.T('LIS_MODULE'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered,
                                enableCellEdit: false
                            },
                            {
                                field: "subjectRound",
                                name: "subjectRound",
                                displayName: $scope.T('LIS_SUBJECTROUND'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered,
                                enableCellEdit: false
                            },
                            {
                                field: "contactLesson",
                                name: "contactLesson",
                                displayName: $scope.T('LIS_CONTACTLESSON'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered,
                                enableCellEdit: false
                            },
                            {
                                field: 'notes',
                                displayName: $scope.T('LIS_NOTES'),
                                enableCellEdit: false
                            }
                        ],
                        enableGridMenu: true,
                        enableSelectAll: true,
                        exporterCsvFilename: 'studentGrades.csv',
                        exporterPdfDefaultStyle: {fontSize: 9},
                        exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
                        exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
                        exporterPdfHeader: {text: "My Header", style: 'headerStyle'},
                        exporterPdfFooter: function (currentPage, pageCount) {
                            return {text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle'};
                        },
                        exporterPdfCustomFormatter: function (docDefinition) {
                            docDefinition.styles.headerStyle = {fontSize: 22, bold: true};
                            docDefinition.styles.footerStyle = {fontSize: 10, bold: true};
                            return docDefinition;
                        },
                        exporterPdfOrientation: 'portrait',
                        exporterPdfPageSize: 'LETTER',
                        exporterPdfMaxGridWidth: 500,
                        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location"))
                    };

                    /**
                     * Adding event handlers
                     * 
                     * @param {type} gridApi
                     * @returns {undefined}
                     */
                    $scope.gridOptions.onRegisterApi = function (gridApi) {
                        //set gridApi on scope
                        $scope.gridApi = gridApi;
                        gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
                    };

                    /**
                     * 
                     * @param {type} rowEntity
                     * @returns {undefined}
                     */
                    $scope.saveRow = function (rowEntity) {
                        var deferred = $q.defer();
                        studentGradeModel.Update(rowEntity.id, rowEntity).then(
                                function (result) {
                                    if (result.success) {
                                        deferred.resolve();
                                    } else {
                                        deferred.reject();
                                    }
                                }
                        );
                        $scope.gridApi.rowEdit.setSavePromise(rowEntity, deferred.promise);
                    };

                    /**
                     * Create new from form if succeeds push to grid
                     * 
                     * @param {type} valid
                     * @returns {undefined}
                     */
                    $scope.Create = function (valid) {
                        if (valid) {
                            studentGradeModel.Create($scope.studentGrade).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    console.log(result);
                                    //$scope.gridOptions.data.push(result.data);
                                    LoadGrid();
                                }
                            });
                        } else {
                            globalFunctions.alertMsg('Check form fields');
                        }
                    };

                    /**
                     * Set remote criteria for DB
                     * 
                     * @returns {undefined}
                     */
                    $scope.Filter = function () {
                        if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
                            urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterStudentGrade));
                            LoadGrid();
                        }
                    };

                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        $scope.filterStudentGrade = {};
                        delete urlParams.where;
                        LoadGrid();
                    };

                    /**
                     * Before loading absence data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadGrid() {

                        studentModel.GetList({}).then(function (result) {
                            $scope.gridOptions.data = [];
                            if (globalFunctions.resultHandler(result)) {

                                $scope.students = result.data;
                                $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.students;

                                gradeChoiceModel.GetList({}).then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {

                                        $scope.gradeChoices = result.data;
                                        $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.gradeChoices;

                                        teacherModel.GetList({}).then(function (result) {
                                            if (globalFunctions.resultHandler(result)) {

                                                $scope.teachers = result.data;
                                                $scope.gridOptions.columnDefs[3].editDropdownOptionsArray = $scope.teachers;

                                                independentWorkModel.GetList({}).then(function (result) {
                                                    if (globalFunctions.resultHandler(result)) {

                                                        $scope.independentWorks = result.data;
                                                        $scope.gridOptions.columnDefs[4].editDropdownOptionsArray = $scope.independentWorks;

                                                        moduleModel.GetList({}).then(function (result) {
                                                            if (globalFunctions.resultHandler(result)) {

                                                                $scope.modules = result.data;
                                                                $scope.gridOptions.columnDefs[5].editDropdownOptionsArray = $scope.modules;

                                                                subjectRoundModel.GetList({}).then(function (result) {
                                                                    if (globalFunctions.resultHandler(result)) {

                                                                        $scope.subjectRounds = result.data;
                                                                        $scope.gridOptions.columnDefs[6].editDropdownOptionsArray = $scope.subjectRounds;

                                                                        contactLessonModel.GetList({}).then(function (result) {
                                                                            if (globalFunctions.resultHandler(result)) {

                                                                                $scope.contactLessons = result.data;
                                                                                $scope.gridOptions.columnDefs[7].editDropdownOptionsArray = $scope.contactLessons;

                                                                                studentGradeModel.GetList(urlParams).then(function (result) {
                                                                                    if (globalFunctions.resultHandler(result)) {
                                                                                        $scope.gridOptions.data = result.data;
                                                                                    }
                                                                                });
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }

                    LoadGrid();//let's start loading data
                }

                return studentGradeController;
            });

}(define, document));
