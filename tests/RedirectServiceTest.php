<?php
namespace Alexwenzel\RedirectWizard\tests;

require_once "../../../tests/PluginTestCase.php";

use alexwenzel\redirectwizard\classes\RedirectService;
use Alexwenzel\RedirectWizard\Models\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PluginTestCase;

/**
 * Class SucheComponentTest
 * @package alexwenzel\berlinerbadestellen\tests
 */
class RedirectServiceTest extends PluginTestCase
{
    /**
     * @test
     */
    public function serviceReturnsCorrectValue()
    {
        $request = Request::create('/my-route');

        Redirect::create(
            [
                'redirect_from' => '/my-route',
                'redirect_from_method' => 'get',
                'redirect_to' => 'new-route',
                'redirect_to_httpstatus' => '301',
            ]
        );

        $service = new RedirectService(new Redirect());
        $myRedirect = $service->redirectMatch($request);

        $this->assertInstanceOf(Redirect::class, $myRedirect);
        $this->assertInstanceOf(RedirectResponse::class, $service->getRedirect($myRedirect));
    }

    /**
     * @test
     * create 2 routes, 2. one should match
     */
    public function patternRedirectMatch()
    {
        $request = Request::create('/my-route/my-pattern');

        Redirect::create(
            [
                'redirect_from' => '/whatever/my-pattern',
                'redirect_from_method' => 'get',
                'redirect_to' => 'redirect-1',
                'redirect_to_httpstatus' => '301',
            ]
        );

        Redirect::create(
            [
                'redirect_from' => '/{var}/my-pattern',
                'redirect_from_method' => 'get',
                'redirect_to' => 'redirect-2',
                'redirect_to_httpstatus' => '301',
            ]
        );

        $service = new RedirectService(new Redirect());
        $myRedirect = $service->redirectMatch($request);
        $this->assertEquals('redirect-2', $myRedirect->redirect_to);
        $this->assertEquals('301', $myRedirect->redirect_to_httpstatus);
    }

    /**
     * @test
     */
    public function patternRedirectMatch2()
    {
        $request = Request::create('/my/request/12');

        Redirect::create(
            [
                'redirect_from' => '/my/{pattern}/12',
                'redirect_from_method' => 'get',
                'redirect_to' => 'redirect-1',
                'redirect_to_httpstatus' => '301',
            ]
        );

        Redirect::create(
            [
                'redirect_from' => '/my/{pattern}/13',
                'redirect_from_method' => 'get',
                'redirect_to' => 'redirect-2',
                'redirect_to_httpstatus' => '301',
            ]
        );

        $service = new RedirectService(new Redirect());
        $myRedirect = $service->redirectMatch($request);
        $this->assertEquals('redirect-1', $myRedirect->redirect_to);
    }

    /**
     * @test
     */
    public function patternRedirectMatch3()
    {
        $request = Request::create('/my/request/12');

        Redirect::create(
            [
                'redirect_from' => '/my/{pattern}',
                'redirect_from_method' => 'get',
                'redirect_to' => 'redirect-1',
                'redirect_to_httpstatus' => '301',
            ]
        );

        $service = new RedirectService(new Redirect());
        $this->assertFalse($service->redirectMatch($request));
    }

    /**
     * @test
     */
    public function simpleRedirectNotMatch()
    {
        $request = Request::create('/abc');

        $myRedirect = Redirect::create(
            [
                'redirect_from' => '/my-route',
                'redirect_from_method' => 'get',
                'redirect_to' => 'new-route',
                'redirect_to_httpstatus' => '301',
            ]
        );

        $service = new RedirectService(new Redirect());
        $this->assertFalse($service->redirectMatch($request));
    }
}
