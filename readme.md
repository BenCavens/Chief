# Chief

warning: Chief is still under heavy development and should not be used for production purposes.

## What is Chief
A Blog engine for the Laravel environment. Chief provides a nice maintenance tool for the client and a clean API for the developer to work with. 

## How to start developing
No assumptions are made for the blogging implementation on the site. 
This as a break from other cms philosophies where the site had to be build upon the tool itself. Chief merely acts as a module and can be added any given moment during the development stage. 
The developer should design his blog pages with the use of the Chief API as a storage intermediate.  

## dependencies
Laravel specific. Currently, the Chief package is designed to run inside a Laravel environment. There are no immediate plans to broaden the scope to other environments.

# Installing Chief
Add following line to your composer.json: "bencavens/chief":"dev-master"

Run composer update from the command line

Add the service provider to your application
'Bencavens\Chief\ChiefServiceProvider'

Create the Chief alias
'Chief'	=> 'Bencavens\Chief\ChiefFacade'


Migrate the database tables
php artisan migrate --package="bencavens/chief"
10 tables will be added to your database. They are all prefixed with 'chief' to avoid any collisions.


Seed the tables
php artisan db:seed --class="ChiefSeeder" for the default admin (admin@example.com - chief)

publish config and assets files
php artisan config:publish bencavens/chief
php artisan asset:publish bencavens/chief

For optimal usage, make sure your mail env is up and running. Chief will use your default mail settings for some user interaction.
