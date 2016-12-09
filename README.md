# Crud
ZF2 Module. Abstract layer for manage domain entity

## Contents
- [Installation](#instalation)
  - [Post installation](#post-installation)
- [Introduction](#introduction)
- [Configuration options](#configuration-options)

## Installation

Add this project in your composer.json:

```json
"require": {
  "t4web/crud": "~1.0.0"
}
```

Now tell composer to download `T4web\Crud` by running the command:

```bash
$ php composer.phar update
```

#### Post installation

Enabling it in your `application.config.php`file.

```php
<?php
return array(
  'modules' => array(
      // ...
      'T4web\Crud',
  ),
  // ...
);
```

## Introduction

This module generate CRUD routes and provides basic CRUD methods and customization it. In our vision CRUD contain 6 actions:
- `new` - action, which display form for new entry,
- `create` - action, which receive array of entry values, it validate values and create entity,
- `read` - action, which display one entity, it validate criteria param and entry exists,
- `update` - action, which receive array of entry values, it validate criteria param and entry exists and validate values + update entity,
- `delete` - action, which delete one entity, it validate criteria param and entry exists,
- `list` - action, which display entities by criteria (filter)

Also this module provide Abstract factories for creating Domain services by short alias:
- `ENTITY_NAME-crud-create-service` - `T4webDomain\Service\Creator` will be created
- `ENTITY_NAME-crud-read-service` - `T4web\Crud\Service\ReadService` will be created
- `ENTITY_NAME-crud-update-service` - `T4webDomain\Service\Updater` will be created
- `ENTITY_NAME-crud-delete-service` - `T4webDomain\Service\Deleter` will be created
- `ENTITY_NAME-crud-list-service` - `T4web\Crud\Service\ListService` will be created

## Configuration options

For use `T4web\Crud` featuers you must define `route-generation` config:
```php
'route-generation' => [
    [
        'entity' => 'user',
        'backend' => [
            'namespace' => '/backend',
            'actions' => [
                'new',
                'create',
                'read',
                'update',
                'delete',
                'list',
            ],
            'options' => [
                'create' => [
                    'changesValidator' => Action\Admin\User\CreateAction\ChangesValidator::class,
                    'controller' => Action\Admin\User\CreateAction\Controller::class,
                    'allowedMethods' => ['POST'],
                    'service' => 'user-crud-delete-service',
                    'redirectTo' => 'admin-user-list',
                ],
                'update' => [
                    'changesValidator' => Action\Admin\User\CreateAction\ChangesValidator::class,
                ],
            ],
        ],
    ],
],
```
where `entity` - entity name for URI (for example: `/backend/user/new`, '/backend/user/create'...),
`actions` - define which actions will be processed, if you not define `delete` action, delete URI will not created,
`options` - define custom options for each action (see [sebaks/zend-mvc-controller](https://github.com/sebaks/zend-mvc-controller))

For current config will be created this routes:

```php
'routes' => [
    'admin-user-new' => [
        'type' => 'Segment',
        'options' => [
            'route'    => '/backend/user/new',
            'defaults' => [
                'allowedMethods' => ['GET'],
                'controller' => 'sebaks-zend-mvc-controller',
            ],
        ],
    ],
    'admin-user-create' => [
        'type' => 'Segment',
        'options' => [
            'route'    => '/backend/user/create',
            'defaults' => [
                'allowedMethods' => ['POST'],
                'controller' => 'Users\Action\Admin\User\CreateAction\Controller',
                'service' => 'user-crud-create-service',
                'redirectTo' => 'admin-user-list',
                'changesValidator' => 'Users\Action\Admin\User\CreateAction\ChangesValidator',
            ],
        ],
    ],
    'admin-user-read' => [
        'type' => 'Segment',
        'options' => [
            'route'    => '/backend/user/read/:id',
            'defaults' => [
                'allowedMethods' => ['GET'],
                'controller' => 'sebaks-zend-mvc-controller',
                'routeCriteria' => 'id',
                'service' => 'user-crud-read-service',
                'criteriaValidator' => 'user-crud-id-validator',
            ],
        ],
    ],
    'admin-user-update' => [
        'type' => 'Segment',
        'options' => [
            'route'    => '/backend/user/update/:id',
            'defaults' => [
                'allowedMethods' => ['POST'],
                'controller' => 'sebaks-zend-mvc-controller',
                'routeCriteria' => 'id',
                'criteriaValidator' => 'user-crud-id-validator'
                'service' => 'user-crud-update-service',
                'redirectTo' => 'admin-user-list',
            ],
        ],
    ],
    'admin-user-delete' => [
        'type' => 'Segment',
        'options' => [
            'route'    => '/backend/user/delete/:id',
            'defaults' => [
                'allowedMethods' => ['GET'],
                'controller' => 'sebaks-zend-mvc-controller',
                'routeCriteria' => 'id',
                'criteriaValidator' => 'user-crud-id-validator'
                'service' => 'user-crud-delete-service',
                'redirectTo' => 'admin-user-list',
            ],
        ],
    ],
]
```
