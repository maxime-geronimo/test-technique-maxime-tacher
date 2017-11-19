<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParametresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParametresTable Test Case
 */
class ParametresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParametresTable
     */
    public $Parametres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.parametres',
        'app.reves'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Parametres') ? [] : ['className' => 'App\Model\Table\ParametresTable'];
        $this->Parametres = TableRegistry::get('Parametres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Parametres);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
