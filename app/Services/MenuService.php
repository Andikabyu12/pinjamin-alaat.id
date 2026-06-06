<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class MenuService
{
    /**
     * Get menu items based on user role
     */
    public static function getMenuItems()
    {
        $user = Auth::user();

        if (!$user) {
            return [];
        }

        return Config::get("menu.menus.{$user->role}", []);
    }

    /**
     * Check if menu item is active
     */
    public static function isActive($activePattern)
    {
        if (is_array($activePattern)) {
            foreach ($activePattern as $pattern) {
                if (request()->routeIs($pattern)) {
                    return true;
                }
            }

            return false;
        }

        return request()->routeIs($activePattern);
    }

    /**
     * Determine whether a menu item or its submenu is active
     */
    public static function isMenuOpen(array $menu)
    {
        if (isset($menu['active']) && self::isActive($menu['active'])) {
            return true;
        }

        if (!empty($menu['subMenu'])) {
            foreach ($menu['subMenu'] as $subMenu) {
                if (self::isActive($subMenu['route'])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get all menu items from config
     */
    public static function getAllMenus()
    {
        return Config::get('menu.menus', []);
    }

    /**
     * Get menu items for a specific role
     */
    public static function getMenusByRole($role)
    {
        return Config::get("menu.menus.{$role}", []);
    }
}
