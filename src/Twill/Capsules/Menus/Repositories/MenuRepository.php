<?php

namespace TwillMenu\Twill\Capsules\Menus\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use TwillMenu\Twill\Capsules\Menus\Models\Menu;

class MenuRepository extends ModuleRepository
{
    use HandleBlocks, HandleTranslations, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    // Save JSON file when menus is created
    public function afterSave($object, $fields) {
        parent::afterSave($object, $fields);

        // Calls that specific method from the specified controlle
        app('TwillMenu\Twill\Capsules\Menus\Http\Controllers\Site\SiteMenuController')->saveFile();
    }
}
