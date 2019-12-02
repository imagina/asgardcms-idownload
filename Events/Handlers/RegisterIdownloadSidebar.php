<?php

namespace Modules\Idownload\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIdownloadSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('idownload::idownloads.title.idownloads'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('idownload::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.idownload.category.create');
                    $item->route('admin.idownload.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('idownload.categories.index')
                    );
                });
                $item->item(trans('idownload::downloads.title.downloads'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.idownload.download.create');
                    $item->route('admin.idownload.download.index');
                    $item->authorize(
                        $this->auth->hasAccess('idownload.downloads.index')
                    );
                });
                $item->item(trans('idownload::suscriptors.title.suscriptors'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.idownload.suscriptor.create');
                    $item->route('admin.idownload.suscriptor.index');
                    $item->authorize(
                        $this->auth->hasAccess('idownload.suscriptors.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
