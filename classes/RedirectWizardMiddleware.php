<?php
namespace Alexwenzel\RedirectWizard\classes;

use Alexwenzel\RedirectWizard\Models\Redirect;
use Closure;
use Illuminate\Http\Request;

/**
 * Class RedirectWizardMiddleware
 * @package alexwenzel\redirectwizard\classes
 */
class RedirectWizardMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return Redirect|mixed
     */
    public function handle($request, Closure $next)
    {
        $service = app('Alexwenzel\RedirectWizard\classes\RedirectService');

        if ($redirect = $service->redirectMatch($request)) {
            return $service->getRedirect($redirect);
        }

        return $next($request);
    }
}
