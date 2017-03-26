<?php namespace Alexwenzel\RedirectWizard;

use alexwenzel\redirectwizard\classes\RedirectService;
use Alexwenzel\RedirectWizard\Models\Redirect;
use Cms\Classes\CmsController;
use Event;
use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package Alexwenzel\RedirectWizard
 */
class Plugin extends PluginBase
{
    /**
     * components
     */
    public function registerComponents()
    {

    }

    /**
     * settings
     */
    public function registerSettings()
    {

    }

    /**
     * boot
     */
    public function boot()
    {
        $this->app->bind('redirectService', function ($app) {
            return new RedirectService($app['HttpClient']);
        });

        CmsController::extend(function($controller) {
            $controller->middleware('alexwenzel\redirectwizard\classes\RedirectWizardMiddleware');
        });
    }
}
