<?php
namespace Alexwenzel\RedirectWizard\classes;

use Alexwenzel\RedirectWizard\Models\Redirect;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

/**
 * Class RedirectService
 * @package alexwenzel\redirectwizard\classes
 */
class RedirectService
{
    /**
     * @var Redirect
     */
    protected $redirect;

    /**
     * RedirectService constructor.
     *
     * @param Redirect $redirect
     */
    public function __construct(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @param $url
     *
     * @return string
     */
    protected function cleanUrl($url)
    {
        return ltrim($url, '/');
    }

    /**
     * @param Request $request
     *
     * @return bool|Redirect
     */
    public function redirectMatch(Request $request)
    {
        $redirect = $this->redirect;

        /** @var Collection $redirects */
        $redirectsArray = \Cache::rememberForever('alexwenzel.redirectwizard', function() use ($redirect) {
            return $redirect->all()->toArray();
        });

        $redirects = Redirect::hydrate($redirectsArray);

        $filteredRedirects = $redirects->filter(function ($redirect) use ($request) {
            $route = new Route([strtoupper($redirect->redirect_from_method)], $redirect->redirect_from, []);
            return $route->matches($request);
        });

        if ($filteredRedirects->count() > 0) {
            return $filteredRedirects->first();
        }

        return false;
    }

    /**
     * @param Redirect $redirect
     *
     * @return Redirect
     */
    public function getRedirect(Redirect $redirect)
    {
        return redirect($redirect->redirect_to, $redirect->redirect_to_httpstatus);
    }
}
