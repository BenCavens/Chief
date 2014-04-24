# Chief #

Warning: Chief is still under heavy development and is undergoing constant changes and should therefore not be used for production purposes.

## What is Chief
A Blog engine for the Laravel environment. Chief provides a nice management tool for the client and a clean API for the developer to work with. 

No assumptions are made for the blogging implementation on the site. 
This as a break from other cms philosophies where the site had to be build upon the tool itself. Chief merely acts as a module and can be added any given moment during the development stage. The developer should design his blog pages with the use of the Chief API as a storage intermediate.  

## Dependencies
Currently, the Chief package is designed to run inside a Laravel environment. For now, there is no intension to build support for other environments.

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
`php artisan config:publish bencavens/chief` and 
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

#### Set up your default user
`php artisan db:seed --class="ChiefSeeder"` for the default admin (admin@admin.com - password: chief)
Your environment should be set to anything but production for seeding to be allowed.

That's it! You seem good to go now.

## Gameplan

- core classes: basemodel and baserepository
- thumbnail addition for post: allow to choose an image as the post thumbnail for use in post overviews
- provide easy spamfilter options (e.g. Akismet) for comment insertions via API. 
- documentation around API
- example snippets for frontend: blog overview, post detail page, comment form, comment insertion and validation
- chief logo
- filter and sorting options for posts, comments and user indexes
- user roles and permissions: admin, manager, chief, writer, co-writer and guest
- versioning for postrecords
- install script (handle separate), needs to be removed after installment
- dashboard for each user with his drafts and latest changed posts
- admin settings page for general options (behind admin auth filter) like language, backup, API key??
- chief::elements() - mysterious no?!
