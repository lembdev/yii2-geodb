# yii2-geodb
The yii2-geodb geographical database, covers all countries and more than four million cities
Based upon geodb database (http://download.geodb.org/export/dump).

Provide RESTful controllers for:
* Countries
* Regions
* Cities
* Cities names
* Timezones

Provide controller for Select2 input widget

## Requirements
* The minimum requirement by Yii is that your Web server supports PHP 5.5.
* `memory_limit` set to >= 128Mb

## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-source "lembadm/yii2-geodb" "dev-master"
```

or add

```
"lembadm/yii2-geodb": "dev-master"
```

to the require section of your `composer.json` file.

Add to `config/web.php` and `config/console.php`
```
'modules' => [
    ...
    'geo' => 'lembadm\geodb\Module',
    ...
],
```

Then run the migration
```
./yii migrate/up --migrationPath='@vendor/lembadm/yii2-geodb/migrations'
```

## Usage
See demo folder

## Contributors
+ [Alexander Vizhanov](https://github.com/lembadm)

## License
This work is licensed under a Creative Commons Attribution 3.0 License,
see (http://creativecommons.org/licenses/by/3.0/)
The Data is provided "as is" without warranty or any representation of accuracy, timeliness or completeness.

## Comments / Suggestions
Please provide any helpful feedback or requests.

Sorry for my English. Thanks.