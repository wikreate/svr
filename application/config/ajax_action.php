<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$config['param']  = array(
	
    'addMenu' => array(
        'validator' => false,
        'model_function' => 'addMenu',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'viewElement' => array(
        'validator' => FALSE,
        'model_function' => 'viewElement',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'viewMenuFooter' => array(
        'validator' => FALSE,
        'model_function' => 'viewMenuFooter',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'sortMultiLevel' => array(
        'validator' => FALSE,
        'model_function' => 'sortMultiLevel',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'sortElement' => array(
        'validator' => FALSE,
        'model_function' => 'sortElement',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'nestableElement' => array(
        'validator' => FALSE,
        'model_function' => 'nestableElement',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ), 

    'editMenu' => array(
        'validator' => false,
        'model_function' => 'editMenu',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'editUserdata' => array(
        'validator' => false,
        'model_function' => 'editUserdata',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'addNewUser' => array(
        'validator' => 'new-user',
        'model_function' => 'addNewUser',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),  

    'deleteElement' => array(
        'validator' => FALSE,
        'model_function' => 'deleteElement',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'deleteImageElement' => array(
        'validator' => FALSE,
        'model_function' => 'deleteImageElement',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'deleteSessImg' => array(
        'validator' => FALSE,
        'model_function' => 'deleteSessImg',
        'isset_sess' => false,
        'prepare_path' => 'public/insert_model'
    ),
 

    'addBeer' => array(
        'validator' => false,
        'model_function' => 'addBeer',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),

    'editBeer' => array(
        'validator' => false,
        'model_function' => 'editBeer',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ), 
  
    'addConstants' => array(
        'validator' => FALSE,
        'model_function' => 'addConstants',
        'isset_sess' => 'Данные были сохранены',
        'prepare_path' => 'private/insert_model'
    ),
  
    'changeStatus' => array(
        'validator' => FALSE,
        'model_function' => 'changeStatus',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ),

    'userContact' => array(
        'validator' => FALSE,
        'model_function' => 'userContact',
        'isset_sess' => FALSE,
        'prepare_path' => 'public/insert_model'
    ),

    'addTown' => array(
        'validator' => FALSE,
        'model_function' => 'addTown',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ),

    'editTown' => array(
        'validator' => FALSE,
        'model_function' => 'editTown',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ),

    'addRegion' => array(
        'validator' => FALSE,
        'model_function' => 'addRegion',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ),

    'editRegion' => array(
        'validator' => FALSE,
        'model_function' => 'editRegion',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ), 

    'loadRegion' => array(
        'validator' => FALSE,
        'model_function' => 'loadRegion',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ),

    'addLocation' => array(
        'validator' => FALSE,
        'model_function' => 'addLocation',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ),

    'editLocation' => array(
        'validator' => FALSE,
        'model_function' => 'editLocation',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ),

    'edit_table_order' => array(
        'validator' => FALSE,
        'model_function' => 'edit_table_order',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ),

    'getTownCoord' => array(
        'validator' => FALSE,
        'model_function' => 'getTownCoord',
        'isset_sess' => FALSE,
        'prepare_path' => 'private/insert_model'
    ) 
);

$config['action'] = array(
    'add',
    'view',
    'delete',
    'sortable',
    'like'
);