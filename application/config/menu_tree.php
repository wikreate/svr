<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['sidebar'] = array(
    'menu' => array(
        'name' => 'Меню',
        'path' => 'cp/menu',
        'icon' => '<i class="fa fa-list"></i>',
        'parent' => array( 
            'edit-menu',
            'menu'
        )
    ), 

    'beer' => array(
        'name' => 'Пиво',
        'path' => 'cp/beer',
        'icon' => '<i class="fa fa-beer"></i>',
        'parent' => array(
            'add-beer',
            'edit-beer',
            'beer'
        )
    ),

    'town' => array(
        'name' => 'Города',
        'path' => 'cp/town',
        'icon' => '<i class="fa fa-map" aria-hidden="true"></i>',
        'parent' => array(
            'add-town',
            'edit-town',
            'town'
        )
    ), 

    'region' => array(
        'name' => 'Районы',
        'path' => 'cp/region',
        'icon' => '<i class="fa fa-map-signs" aria-hidden="true"></i>',
        'parent' => array(
            'add-region',
            'edit-region',
            'region'
        )
    ),

    'location' => array(
        'name' => 'Магазины',
        'path' => 'cp/location',
        'icon' => '<i class="fa fa-map-marker" aria-hidden="true"></i>',
        'parent' => array(
            'add-location',
            'edit-location',
            'location'
        )
    ),

    'constants' => array(
        'name' => 'Константы',
        'path' => 'cp/constants',
        'icon' => '<i class="fa fa-anchor"></i>',
        'parent' => array(
            'constants'
        )
    )
);