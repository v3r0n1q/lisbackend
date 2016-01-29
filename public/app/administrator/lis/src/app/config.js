
(function (define) {
    'use strict';
    
    /**
     * 
     * @returns {config_L12.config_L18.config}
     */
    define([], function () {
        
        /**
         * 
         * @param {Object} $routeProvider
         * @param {Object} $locationProvider
         * @returns {undefined}
         */
        function config($routeProvider, $locationProvider) {

            $routeProvider
                .when('/vocation', {
                    templateUrl: 'lis/dist/templates/vocation.html', 
                    controller: 'vocationController'
                })
                .when('/teacher', {
                    templateUrl: 'lis/dist/templates/teacher.html', 
                    controller: 'teacherController'
                })
                .when('/gradingtype',{
                    templateUrl: 'lis/dist/templates/gradingType.html',
                    controller: 'gradingTypeController'
                })
                .otherwise({redirectTo: '/'});

            $locationProvider.html5Mode({
                enabled: false,
                requireBase: false
            });

            $locationProvider.hashPrefix('!');
        }

        config.$inject = ['$routeProvider', '$locationProvider'];

        return config;
    });

}(define));


