<?php

namespace Sebastienheyd\Boilerplate\Menu;

use Auth;
use Illuminate\Support\Collection;
use Lavary\Menu\Builder as LavaryMenuBuilder;

/**
 * Class Builder.
 *
 * @property Collection $items;
 */
class Builder extends LavaryMenuBuilder
{
    private $root = [];

    /**
     * Adds an item to the menu.
     *
     * @param string $title
     * @param array  $options
     *
     * @return \Lavary\Menu\Item|Item
     */
    public function add($title, $options = [])
    {
        $title = sprintf('<span>%s</span>', $title);

        $id = isset($options['id']) ? $options['id'] : $this->id();

        $item = new Item($this, $id, $title, $options);

        if (isset($options['icon'])) {
            $item->icon($options['icon']);
        }

        if (isset($options['role']) || isset($options['permission'])) {
            $ability = ['admin'];
            if (isset($options['role'])) {
                $ability = $ability + explode(',', $options['role']);
            }

            $permission = null;
            if (isset($options['permission'])) {
                $permission = explode(',', $options['permission']);
            }

            $currentUser = Auth::user();
            if ($currentUser->ability($ability, $permission)) {
                $this->items->push($item);
            }
        } else {
            $this->items->push($item);
        }

        return $item;
    }

    /**
     * Add an item to a existing menu item as a submenu item.
     *
     * @param string $id      Id of the menu item to attach to
     * @param string $title   Title of the sub item
     * @param array  $options
     *
     * @return Lavary\Menu\Item
     */
    public function addTo($id, $title, $options = [])
    {
        $parent = $this->whereId($id)->first();

        if (isset($parent)) {
            if (!isset($this->root[$parent->id])) {
                $parent->attr(['url' => '#', 'class' => 'treeview']);
                $str = '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';
                $parent->append($str);
                $this->root[$parent->id] = true;
            }

            $item = $parent->add($title, $options);
        } else {
            $item = $this->add($title, $options);
        }

        $item->icon('circle-o');

        return $item;
    }
}
