<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\RepositoriesController;
use App\Services\RepositorySync;
use Cake\Http\TestSuite\HttpClientTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RepositoriesController Test Case
 *
 * @uses \App\Controller\RepositoriesController
 */
class RepositoriesControllerTest extends TestCase
{
    use IntegrationTestTrait;
    use HttpClientTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Repositories',
        'app.Branches',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\RepositoriesController::index()
     */
    public function testIndex(): void
    {
        $this->get([
            'controller' => 'Repositories',
            'action' => 'index'
        ]);
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\RepositoriesController::view()
     */
    public function testView(): void
    {
        $this->get([
            'controller' => 'Repositories',
            'action' => 'view',
            1
        ]);
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\RepositoriesController::add()
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $this->post([
            'controller' => 'Repositories',
            'action' => 'add',
        ], [
            'name' => 'Live Cake',
            'url' => 'Testing',
            'forks' => 1,
            'open_issues' => 2,
            'external_ident' => 3,
        ]);
        $this->assertRedirect([
            'controller' => 'Repositories',
            'action' => 'index'
        ]);
        $repositories = $this->getTableLocator()->get('Repositories');
        $query = $repositories->find()->where(['name' => 'Live Cake']);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\RepositoriesController::edit()
     */
    public function testEdit(): void
    {
        $this->enableCsrfToken();
        $this->post([
            'controller' => 'Repositories',
            'action' => 'edit',
            1
        ], [
            'name' => 'Live Cake',
            'url' => 'Testing',
            'forks' => 1,
            'open_issues' => 2,
            'external_ident' => 3,
        ]);
        $this->assertRedirect([
            'controller' => 'Repositories',
            'action' => 'index'
        ]);
        $repositories = $this->getTableLocator()->get('Repositories');
        $query = $repositories->find()->where(['name' => 'Live Cake']);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\RepositoriesController::delete()
     */
    public function testDelete(): void
    {
        $this->enableCsrfToken();
        $this->post([
            'controller' => 'Repositories',
            'action' => 'delete',
            1
        ]);
        $this->assertRedirect([
            'controller' => 'Repositories',
            'action' => 'index'
        ]);
        $repositories = $this->getTableLocator()->get('Repositories');
        $query = $repositories->find();
        $this->assertEquals(0, $query->count());
    }

    public function testDeleteFail(): void
    {
        $this->enableCsrfToken();
        $mock = $this->getMockForModel('Repositories', ['delete']);
        $mock->expects($this->once())
            ->method('delete')
            ->willReturn(false);

        $this->post([
            'controller' => 'Repositories',
            'action' => 'delete',
            1
        ]);
        $this->assertFlashMessage('The repository could not be deleted. Please, try again.');
        $this->assertRedirect([
            'controller' => 'Repositories',
            'action' => 'index'
        ]);
    }

    public function testSync(): void
    {
        $this->mockService(RepositorySync::class, function(){
            $mock = $this->createMock(RepositorySync::class);
            $mock->expects($this->once())->method('sync');

            return $mock;
        });
        $this->get([
            'controller' => 'Repositories',
            'action' => 'sync',
        ]);
        $this->assertResponseOk();
    }

    public function testSyncCakeClientMock(): void
    {
        $this->mockClientGet(
            'https://api.github.com/orgs/cakephp/repos?start_page=1',
            $this->newClientResponse(
                200,
                ['Content-Type: application/json'],
                file_get_contents(TESTS . 'APIResponses' . DS . 'onerepo.json')
            )
        );
        $this->mockClientGet(
            'https://api.github.com/repos/cakephp/localized/branches',
            $this->newClientResponse(
                200,
                ['Content-Type: application/json'],
                file_get_contents(TESTS . 'APIResponses' . DS . 'onebranch.json')
            )
        );
        $this->get([
            'controller' => 'Repositories',
            'action' => 'sync',
        ]);
        $this->assertResponseOk();
    }
}
