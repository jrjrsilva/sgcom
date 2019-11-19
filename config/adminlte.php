<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'SGCOM',

    'title_prefix' => 'Sistema de Gestão de Comando do CPRC/A',

    'title_postfix' => '',
    
    
    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>SGCom</b>',

    'logo_mini' => '<b>SC</b>',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'admin',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        
        [
            'text'        => 'Home',
            'url'         => 'home',
            'icon'        => 'home',
            'label_color' => 'success',
        ],

        [
            'text'        => 'Painel de Gestão',
            'url'         => 'painel/index',
            'icon'        => 'bar-chart-o',
            'label_color' => 'success',    
        ],   
        
        [
            'text'        => 'Serviço Operacional',
            'url'         => '#',
            'icon'        => 'clipboard',
            'label_color' => 'success',    

            'submenu' => [ 
                [
                    'text' => 'Escala Operacional',
                    'url'  => 'servico/escala',
                    'icon' => 'tasks',
                ],  

                [
                    'text' => 'Ocorrências',
                    'url'  => 'servico/ocorrencia',
                    'icon' => 'pencil-square-o',
                ],
                [
                    'text' => 'Listar Ocorrências',
                    'url'  => 'servico/listarocorrencias',
                    'icon' => 'dashboard',
                ]
                ,  
                [
                    'text' => 'Produtividade',
                    'url'  => 'servico/produtividade',
                    'icon' => 'sticky-note',
                ],  
            ]
        ],   

        [
            'text'        => 'Recursos Humanos',
            'url'         => 'rh/listageral',
            'icon'        => 'users',
            'label_color' => 'success',    
        ],   

        [
            'text'        => 'Gestão de Frotas',
            'url'         => 'frota/lista',
            'icon'        => 'truck',
            'label_color' => 'success',    
        ],   

        [
            'text'        => 'Armamento',
            'url'         => 'armas/lista',
            'icon'        => 'bullseye',
            'label_color' => 'success',    
        ],   

        [
            'text'        => 'Inteligência Policial',
            'url'         => 'inteligencia/index',
            'icon'        => 'desktop',
            'label_color' => 'success',    
        ],   

        [
            'text'        => 'CVLI',
            'url'         => 'cvli/index',
            'icon'        => 'odnoklassniki',
            'label_color' => 'danger',    
        ],   
        
        [
            'text'        => 'CVP',
            'url'         => 'cvp/index',
            'icon'        => 'exclamation-circle',
            'label_color' => 'success',    
        ],   

        'Configurações',

        [
            'text' => 'Mensagens',
            'url'  => 'admin/settings',
            'icon' => 'envelope',
        ],

        [
            'text' => 'Chat Serviço Operacional',
            'url'  => 'admin/settings',
            'icon' => 'comments',
        ],

        [
            'text' => 'Calendário',
            'url'  => 'admin/settings',
            'icon' => 'calendar',
        ],

      
     
        [
            'text'    => 'Tabelas Básicas',
            'icon'    => 'share',
            'submenu' => [ 
               
                [
                    'text' => 'Usuários',
                    'url'  => 'admin/usuarios',
                    'icon' => 'user',
                ],
             
                [
                    'text' => 'AISP',
                    'url'  => 'admin/aisp',
                ], 

                [
                    'text' => 'CPR',
                    'url'  => 'admin/cpr',
                ],   
                [
                    'text' => 'OPM',
                    'url'  => 'admin/opm',
                ],
                [
                    'text' => 'Papeis',
                    'url'  => 'admin/papeis',
                ], 
            ],
        ],
       
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
