CrunchyProfile
==================
Version 0.0.1 Created by Michal Walkowiak from Crunchy Consulting, Inc ([CrunchyConsulting.com](http://crunchyconsulting.com))

Introduction
------------

CrunchyProfile is an extension to [ZfcUser](http://github.com/ZF-Commons/ZfcUser) and provides very flexible profile editor based on key-value pairs for different kind of fields


Installation Instructions
-------------------------

Installation of CrunchyProfile uses composer. For composer documentation, please refer to [getcomposer.org](http://getcomposer.org).

#### Installation Steps

##### WITH COMPOSER (RECOMMENDED)
1. Add this project to your composer.json

    ```json
    "require": {
        "zf-commons/zfc-base": "dev-master",
        "zf-commons/zfc-user": "0.*",
        "imagine/Imagine": "0.3.*",
        "crunchy/crunchy-profile": "dev-master",
    }
    ```
2. Tell composer to download CrunchyProfile by running the command:

    ```bash
    $ php composer.phar update
    ```

##### … OR BY CLONING PROJECT
* Install the ZfcBase ZF2 module by cloning it into ./vendor/.
* Install the ZfcUser ZF2 module by cloning it into ./vendor/.
* Install the Imagine ZF2 module by cloning it into ./vendor/.
* Clone this project into your ./vendor/ directory.

3. Apply schema from ./vendor/crunchy/crunchy-profile/data/schema.sql

4. Open `configs/application.config.php` and add the following key to your `modules`:

     ```'ZfcBase',
        'ZfcUser',
     	'CrunchyProfile',
     ```

#### Configuration

Copy CrunchyProfile/config/crunchyprofile.global.php.dist to ./config/autoload/crunchyprofile.global.php and define your fields and validation rules for them.


## TO-DO:
* Move more options into configuration
* Add more supported fields and options
* Add more custom options for image processing during upload
