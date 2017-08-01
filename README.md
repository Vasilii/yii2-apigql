andyharis/yii2-apigql
==========
yii2-apigql provides methods to work with database on CRUD operations

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).
Either run
```
composer require andyharis/yii2apigql
```
Usage
---
For example we have 3 table/models: Users, Messages, Post.

* `Users` -> hasMany `Messages`
* `Messages` -> hasOne `Post`

We want to access clients with all messages including post:
```json
{
  "username": "",
  "avatarUrl": "",
  "messages": {
    "textMessage": "",
    "dateAdded": "",
    "post": {
      "postName": ""
    }
  }
}
```
Make request and get all data with the same format you provided.

GET `/clients?select={"username": "","avatarUrl": "","messages": {"textMessage": "","dateAdded": "","post": {"postName": ""}}}`
```json
// response
[
  {
    "username": "Andyahr",
    "avatarUrl": "http://example.com/andyhar.png",
    "messages": [
      {
        "textMessage": "Hey what a nice post!",
        "dateAdded": "1500276704",
        "post": {
          "postName": "Post about API"
        }
      },
      {
        "textMessage": "Make more posts like this!",
        "dateAdded": "1500279841",
        "post": {
          "postName": "Post about API"
        }
      }
    ]
  },
  {},
  {},
  ...
]
```
* Access main model and nested relations data with one query.
* Sort by nested relations:
  * `/clients?select={...}&sort=messages.dateAdded` - sort by `messages.dateAdded ASC`
  * `/clients?select={...}&sort=!messages.post.postName` - sort by `post.postName DESC`
* Filter data with nested conditions:
  * `/clients?select={"username":"=Andyhar"}` - where `username equals Andyhar`
  * `/clients?select={"messages":{"textMessage":"~Rocks"}}` - where `messages.textMessage like Rocks`
  * `/clients?select={"messages":{"post":{"likes":">35"}}}` - where `messages.post.likes > 35`


Getting started
---
After installation you should enable this module extension in your config file:
1. Open your `frontend/config/main.php`
2. Add module `gql` to `bootstrap` section
```php
// main.php
return [
  'id' => 'app-frontend',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log', 'gql'],
   ...
];
``` 
Then you need to initialize component itself.
Just add new component `gql` to list of your components:
```php
// main.php
'components' => [
   'gql' => [
     'class' => "andyharis\yii2apigql\Bootstrap",
     'relations' => require 'models.php'
    ],
    ...
]
```
Creating file models.php
---
As you can see we `require 'models.php'` to let component know which models to use.

So you probably want create a separate file to store you models for this case.
```php
// models.php
use andyharis\yii2apigql\components\api\Relations;
// Initializing component relations class which will handle dependencies
$object = new Relations();
// Add all models you need to work with
$object
  ->addModel(String $name, String $className)
  ...
  ...
  ->addModel('clients', \frontend\models\Clients::className())
  ->addModel('job', \frontend\models\Job::className());
// we need to return this object with relations
return $object;
```
Where:
* `clients` - indicates name for your model
* `\frontend\models\Clients::className()` - indicates what model should use to fetch and update data

Almost there
---
Another important thing is to extend all your models with `Yii2ApigqlRecord` component.
```php
// frontend/models/Clients.php
namespace frontend\models;

use andyharis\yii2apigql\components\Yii2ApigqlRecord;
// This is important, because Yii2ApigqlRecord has some methods which use your models to make magic. 
// Of course you can extend it with your class but don't forget to extend Yii2ApigqlRecord
class Clients extends Yii2ApigqlRecord
```
That's it. Now you can work with `yii2apigql`.

For more info please visit Wiki for API documentation.
