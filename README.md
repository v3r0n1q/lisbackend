# Learning Information System 

## Developers and responsibilities

    Eleri Apsolon - UX, front-end key developer, student app, analytics, developer, eleri.apsolon@gmail.com
    Marten Kähr - backup module architecture, analytics and development, developer
    Juhan Kõks - release manager (Jenkins), Server administrator (LAMP), developer, juhankoks@gmail.com
    Kristen Sepp - UI/UX, front-end key developer, analytics, developer seppkristen@gmail.com
    Arnold Tšerepov - QA, developer, tserepov@gmail.com
    Alar Aasa - UX, front-end key developer, developer, alar@alaraasa.ee
    Sander Mets - team lead, software architect, lead developer, sandermets0@gmail.com

## What
Purpose of the current project is to provide web based e-diary for http://www.saksatk.ee/en/. Deadline is 1st June of 2016.   
Project will be taken into account as internship and final practical work to graduate school for all developers involved with the project.  

## Front-end apps
AnularJS based web-apps:  

**Student** [https://github.com/parnustk/lisbackend/tree/master/public/app/student](https://github.com/parnustk/lisbackend/tree/master/public/app/student)  
**Teacher** [https://github.com/parnustk/lisbackend/tree/master/public/app/teacher](https://github.com/parnustk/lisbackend/tree/master/public/app/teacher)  
**Administrator** [https://github.com/parnustk/lisbackend/tree/master/public/app/administrator](https://github.com/parnustk/lisbackend/tree/master/public/app/administrator)  

## Technologies used
List of used technologies:

    Zend2, 
    Doctrine2, 
    PHPUnit, 
    AngularJS, 
    RequireJS, 
    NodeJS, 
    Gulp, 
    Bootstrap3

## Technical requirements
Server side logic (back end) has to be covered by automated acceptance, functional and unit tests.

## Material

    "PHP Data Persistence with Doctrine 2 ORM Concepts, Techniques and Practical Solutions" by Michael Romer
    http://framework.zend.com/manual/current/en/index.html  
    bootstrap - https://getbootstrap.com/components/
    angular ui select http://angular-ui.github.io/ui-select/#examples
    grid itself http://ui-grid.info/  
    
## Demo link
[http://alpha.lis.ee/](http://alpha.lis.ee/)  

## Installation

    Instructions can be found - https://github.com/parnustk/lisbackend/wiki/Install  

## Quick helper

### Linux/MAC:

    php vendor/bin/doctrine-module orm:validate-schema
    php vendor/bin/doctrine-module orm:schema-tool:create
   
### Windows:

    vendor\bin\doctrine-module.bat orm:validate-schema
    vendor\bin\doctrine-module.bat orm:schema-tool:create

### API Documentation

#### Install apigen;

    See http://www.apigen.org/

### Generate api docs:

    apigen generate -s "module/Administrator/src/Administrator/Controller/","module/Teacher/src/Teacher/Controller/","module/Student/src/Student/Controller/" -d public/apidocs --template-theme "bootstrap" --title "LIS eDiary API documentation" --no-source-code

### Doctrine 2 Custom types:

    https://github.com/doctrine/DoctrineORMModule/blob/master/docs/EXTRAS_ORM.md
    http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/cookbook/custom-mapping-types.html
    http://stackoverflow.com/questions/8374908/where-to-encrypt-decrypt-my-data
    https://github.com/doctrine/DoctrineORMModule/blob/master/docs/configuration.md

### Doctrine2 Native SQL

    http://www.wjgilmore.com/blog/2011/04/09/the-power-of-doctrine-2-s-custom-repositories-and-native-queries/

### Github token

https://github.com/composer/composer/issues/3542

## Random

 READ - http://brianhann.com/create-a-modal-row-editor-for-ui-grid-in-minutes/
 http://brianhann.com/ui-grid-and-multi-select/#more-732
 http://www.codelord.net/2015/09/24/$q-dot-defer-youre-doing-it-wrong/
 http://stackoverflow.com/questions/25983035/angularjs-function-available-to-multiple-controllers
 adding content later https://github.com/angular-ui/ui-grid/issues/2050
 dropdown menu http://brianhann.com/ui-grid-and-dropdowns/
	
In production you should not update your dependencies, you should run  
  
>$ composer install   
  
which will read from the lock file and not change anything. From StackOverlfow

>  CREATE SCHEMA `lis` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

use built in php server for server. execute following task in lis root folder

 > php -S 0.0.0.0:8080 -t public/ public/index.php

Mac OS X mysql problem [http://stackoverflow.com/questions/22188026/sqlstatehy000-2002-no-such-file-or-directory](http://stackoverflow.com/questions/22188026/sqlstatehy000-2002-no-such-file-or-directory)
