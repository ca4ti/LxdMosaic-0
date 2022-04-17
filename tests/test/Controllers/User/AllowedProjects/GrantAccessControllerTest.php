<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;

final class GrantAccessControllerTest extends TestCase
{
    public function setUp() :void
    {
        $builder = new \DI\ContainerBuilder();
        $builder->useAnnotations(true);
        $container = $builder->build();
        $this->routeApi = $container->make("dhope0000\LXDClient\App\RouteApi");

        $this->database = $container->get("dhope0000\LXDClient\Model\Database\Database");
        $this->database->dbObject->beginTransaction();
    }

    public function tearDown() :void
    {
        $this->database->dbObject->rollBack();
    }

    public function test_nonAdminUserTryingToGrantAccess() :void
    {
        $this->expectException(\Exception::class);
        $request =  new Request();
        $request = $request->create(
            "api/User/AllowedProjects/GrantAccessController/grant",
            "POST",
            ["targetUser"=>1, "hosts"=>[1], "projects"=>["default"]],
            [],
            [],
            ["HTTP_USERID"=>2],
        );
        $context = new RequestContext();
        $context->fromRequest($request);

        $this->routeApi->route(
            $request,
            $context,
            true
        );
    }

    public function test_grantUserAccess() :void
    {
        $request =  new Request();
        $request = $request->create(
            "api/User/AllowedProjects/GrantAccessController/grant",
            "POST",
            ["targetUser"=>2, "hosts"=>[1], "projects"=>["default"]],
            [],
            [],
            ["HTTP_USERID"=>1],
        );
        $context = new RequestContext();
        $context->fromRequest($request);

        $result = $this->routeApi->route(
            $request,
            $context,
            true
        );

        $this->assertEquals(["state"=>"success", "message"=>"Granted Access"], $result);
    }
}
