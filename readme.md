# Chief #

warning: Chief is still under heavy development and should not be used for production purposes.

## What is Chief
A Blog engine for the Laravel environment. Chief provides a nice maintenance tool for the client and a clean API for the developer to work with. 

No assumptions are made for the blogging implementation on the site. 
This as a break from other cms philosophies where the site had to be build upon the tool itself. Chief merely acts as a module and can be added any given moment during the development stage. 
The developer should design his blog pages with the use of the Chief API as a storage intermediate.  

## dependencies
Laravel specific. Currently, the Chief package is designed to run inside a Laravel environment. There are no immediate plans to broaden the scope to other environments.

## Installing Chief

### Environment setup

#### Include Chief ServiceProvider
Add following line to the required packages list in your composer.json.

```json
"require": {
    "bencavens/chief":"dev-master"
}
```

Run `composer update` from the command line to download the package.

Add `'Bencavens\Chief\ChiefServiceProvider'` as a new service provider to your providers array inside the config/app.php.

Create the Chief alias `'Chief'	=> 'Bencavens\Chief\ChiefFacade'` in the config/app.php as well.


#### Publish config and assets files
`php artisan config:publish bencavens/chief`
`php artisan asset:publish bencavens/chief`

Note: Chief posts makes use of the great redactor wysiwyg editor and handle image uploads behind the scenes mostly without any hassle. 
Should your image inserts fail, be sure to verify that the `public/packages/bencavens/chief/assets` path exists and is writable. 

#### Mail
For optimal usage, make sure your mail environment is up and running. 
Chief will use your default mail settings for its user interaction, like password resetting and the likes.


### Database setup

#### Migrate the database tables.
The necessary tables will be added to your default selected database (config/database.php > default). 
The tables are all prefixed with 'chief' to avoid any collisions.
`php artisan migrate --package="bencavens/chief"`

#### Default user
`php artisan db:seed --class="ChiefSeeder"` for the default admin (admin@example.com - password: chief)
Your environment should be set to anything but production for seeding to be allowed.

