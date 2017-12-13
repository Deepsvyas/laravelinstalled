<?php
namespace app\Helpers;
class ThemeHelperFacade extends \Illuminate\Support\Facades\Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'themehelper'; }

}