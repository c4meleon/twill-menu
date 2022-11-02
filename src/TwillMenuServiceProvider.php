<?php

namespace TwillMenu;

use A17\Twill\TwillPackageServiceProvider;

class TwillMenuServiceProvider extends TwillPackageServiceProvider
{

    public function register()
    {
        $this->publishes([
            __DIR__ . '/Twill/Capsules/Menus/resources/views/admin/form.blade.php' => base_path('resources/views/admin/menus/form.blade.php'),
            __DIR__ . '/Twill/Capsules/Menus/resources/views/admin/blocks' => base_path('resources/views/admin/blocks'),
            __DIR__ . '/Twill/Capsules/Menus/resources/views/site/' => base_path('resources/views/site'),
        ],'twill-menu-views');

        $this->publishes([
            __DIR__ . '/Twill/Capsules/Menus/resources/views/site/' => base_path('resources/views/site'),
        ],'twill-menu-views-site');


        $this->publishes([
            __DIR__ . '/Twill/Capsules/Menus/Http/Controllers/MenuController.php' => base_path('app/Http/Controllers/Admin/MenuController.php'),
            __DIR__ . '/Twill/Capsules/Menus/Http/Controllers/Site/SiteMenuController.php' => base_path('app/Http/Controllers/Site/SiteMenuController.php'),

            __DIR__ . '/Twill/Capsules/Menus/Repositories/MenuRepository.php' => base_path('app/Repositories/MenuRepository.php'),

        ] ,'twill-menu-controller');

        $this->publishes([
            __DIR__ . '/Twill/Capsules/Menus/config/twill-menu.php' => base_path('config/twill-menu.php'),
        ] ,'twill-menu-config');

    }


}
