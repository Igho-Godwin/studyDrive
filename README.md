# studyDrive

App Installation
====================

development 
============

fill your database credentials in .env

php artisan migrate (to migrate tables)

php artisan passport:install 

php artisan db:seed (to seed course table)

php artisan serve (to run)

courses with active value of 1 are available and those with active value of 0 are unavailable (thats for get all course list)


Testing
========

fill your testing database credentials in .env.testing

php artisan migrate --env=testing (to migrate tables)

php artisan passport:install 

php artisan db:seed (to seed course table)

php vendor/phpunit/phpunit/phpunit (to run test on windows machine)


Postman Documentation Url 
==========================

https://documenter.getpostman.com/view/1599757/SVYtLH54?version=latest






