<?php

namespace TwillMenu\Twill\Capsules\Menus\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use \TwillMenu\Twill\Capsules\Menus\Models\Menu;
use App\Models\Slugs\PageSlug;
use App\Models\Translations\PageTranslation;
use Illuminate\Http\Request;
use TwillMenu\Twill\Capsules\Menus\Repositories\MenuRepository;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Config;

class SiteMenuController extends Controller
{
    public $default_language;

    /**
     *
     */
    public function __construct(MenuRepository $repository)
    {
        $this->repository = $repository;
        $this->default_language = config('app.fallback_locale');
    }

    /**
     *
     */
    public function getMenu($menu_position)
    {
        $json = new \stdClass();

        $menu = Menu::with(["blocks" => function ($q) {
            $q->where('blocks.parent_id', '=', null);
        }])->where('position', $menu_position)->first();
        $languages = config('laravellocalization.supportedLocales');

        if ($menu) {

            foreach ($languages as $lang => $language) {

                $menu_data = [];

                foreach ($menu->blocks as $item) {
                    $type = $item->content['item_type'];

                    $temp = [
                        'url' => $this->getUrl($item, $lang, $type),
                        'label' => array_key_exists($lang, $item->content['menu_' . $type . '_label']) ? $item->content['menu_' . $type . '_label'][$lang] : $item->content['menu_' . $type . '_label'][$this->default_language],
                        'children' => $this->getChildrens($item, $lang),
                        'target' => $this->getTarget($item, $lang),
                        'outlined' => $this->outlined($item, $lang),
                        'extra_class' => isset($item->content['extra_class']) ? $item->content['extra_class'] : null,
                    ];

                    array_push($menu_data, $temp);

                }

                $json->$lang = $menu_data;

            }
        }
        return response()->json($json, 200);
    }

    /**
     *
     */
    public function getChildrens($item, $lang)
    {
        $children_data = [];


        $children = Menu::with(["blocks" => function ($q) use ($item) {
            $q->where('blocks.parent_id', '=', $item->id);
        }])->first();


        foreach ($children->blocks as $child) {

            $type = $child->content['item_type'];

            $temp = [
                'url' => $this->getUrl($child, $lang, $type),
                'label' => $this->getLabel($child, $type, $lang),
                'target' => $this->getTarget($child, $lang),
                'outlined' => $this->outlined($child, $lang),
                'children' => $this->getChildrens($child, $lang),
                'extra_class' => isset($child->content['extra_class']) ? $child->content['extra_class'] : null,
            ];

            array_push($children_data, $temp);
        }

        return $children_data;
    }

    /**
     *
     */
    public function getUrl($item, $lang, $type)
    {
        $default_language = config('app.fallback_locale');

        if ($type === 'internal') {
            $internal_item = $item->getRelated('menu_internal_link');
//            $internal_type = $this->getInternalType($internal_item) == 'page' ? '/' : '';
//            $slug = $this->getInternalType($internal_item) == 'page' ? $this->getPageSlug($internal_item[0]->id, $lang, $default_language) : '';

            $slug = $this->getSlug($internal_item, $lang, $default_language);
            $url = config('app.url') . '/' . $lang . '/' . $slug;
        }
        if ($type === 'external') {

            $url = array_key_exists($lang, $item->content['menu_external_link']) ? $item->content['menu_external_link'][$lang] : $item->content['menu_external_link'][$this->default_language];

        }

        return $url;
    }

    /**
     *
     */
    public function getLabel($item, $type, $lang)
    {
        $label = null;

        if ($type === 'external') {
            $label = array_key_exists($lang, $item->content['menu_external_label']) ? $item->content['menu_external_label'][$lang] : $item->content['menu_external_label'][$this->default_language];
        }

        if ($type === 'internal') {
            $internal_item = $item->getRelated('menu_internal_link');
            $internal_type = $this->getInternalType($internal_item);
            $label = count($item->getRelated('menu_internal_link')) > 0 ? $this->getInternalTitle($internal_type, $lang, $internal_item[0]->id, $item) : null;
        }

        return $label;
    }


    /**
     *
     */
    public function getInternalType($item)
    {
        $type = null;
        $page = $item[0]->translations[0]->page_id ?? null;
        $homepage = $item[0]->translations[0]->homepage_id ?? null;

        if ($page != null) {
            $type = 'page';
        }

        if ($homepage != null) {
            $type = 'homepage';
        }

        return $type;
    }

    /**
     *
     */
    public function getInternalTitle($internal_type, $lang, $item, $item_object)
    {
        $title = null;
        $type = 'internal';

        if ($internal_type == 'page') {
            $title = array_key_exists($lang, $item_object->content['menu_' . $type . '_label']) ? $item_object->content['menu_' . $type . '_label'][$lang] : $item_object->content['menu_' . $type . '_label'][$this->default_language];
            //$title = PageTranslation::where('page_id', $item)->where('locale', $lang)->first()->title ?: PageTranslation::where('page_id', $item)->where('locale', $this->default_language)->first()->title;
        }
        return $title;
    }

    /**
     * @param $id
     * @param $lang
     * @param $default_lang
     * @return mixed
     */

    public function getPageSlug($id, $lang, $default_lang)
    {
        $slug = PageSlug::where('page_id', $id)->where('locale', $lang)->where('active', 1)->first();

        if ($slug == null) {

            return PageSlug::where('page_id', $id)->where('locale', $default_lang)->where('active', 1)->first()->slug;

        }
        return $slug->slug;
    }


    public function getSlug($item, $lang, $default_lang)
    {
        $item = $item[0];
        $slug_temp = '';

        if (!is_null($item->slugAttributes)) {
            foreach ($item->slugs as $slug) {
                if ($slug->active && $slug->locale == $lang) {
                    $slug_temp = $slug->slug;
                }
            }

            if (!is_null($item->permalinks)) {
                $slug_temp = $item->permalinks[$lang] . '/' . $slug_temp;
            }

            return $slug_temp;
        }

        if (!is_null($item->slugs)) {
            return $item->slugs[$lang];
        }
    }

    public function getMenuPostition($menu_position): string
    {
        $menu_position_config = config('twill-menu.menu_positions');

        return $menu_position_config[$menu_position - 1]['name'];
    }

    public function getTarget($item, $lang)
    {
        if (isset($item->content['target']) && $item->content['target'] == true) {
            return '_blank';
        }

        return '';
    }

    public function outlined($item, $lang)
    {
        if (isset($item->content['outlined']) && $item->content['outlined'] == true) {
            return $item->content['outlined'];
        }

        return false;
    }

    public function saveFile()
    {
        $menus = Menu::with(["blocks" => function ($q) {
            $q->where('blocks.parent_id', '=', null);
        }])->get();

        foreach ($menus as $menu) {
            $position = $this->getMenuPostition($menu->position);
            if ($menu->default) {
                Storage::disk('public')->put('menu_' . $position . '.json', $this->getMenu($menu->position)->content());
            }
        }
    }
}
