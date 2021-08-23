<?php

namespace Tanerkay\ModelAcl\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Tanerkay\ModelAcl\ModelAclServiceProvider;
use Tanerkay\ModelAcl\Test\Models\Node;
use Tanerkay\ModelAcl\Test\Models\User;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ModelAclServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('model_acl.database_connection', 'sqlite');
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);

        config()->set('auth.providers.users.model', User::class);
        config()->set('app.key', 'base64:'.base64_encode(
            Encrypter::generateKey(config()['app.cipher'])
        ));
    }

    protected function setUpDatabase()
    {
        $this->migrateActivityLogTable();

        $this->createTables('nodes', 'users');
        $this->seedModels(Node::class, User::class);
    }

    protected function migrateActivityLogTable()
    {
        require_once __DIR__.'/../database/migrations/create_model_has_access_control_table.php.stub';

        (new \CreateModelHasAccessControlTable())->up();
    }

    protected function createTables(...$tableNames)
    {
        collect($tableNames)->each(function (string $tableName) {
            Schema::create($tableName, function (Blueprint $table) use ($tableName) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->timestamps();
                $table->softDeletes();

                if ($tableName === 'users') {
                    $table->string('roles')->nullable();
                }

                if ($tableName === 'nodes') {
                    $table->integer('user_id')->unsigned()->nullable();
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                }
            });
        });
    }

    protected function seedModels(...$modelClasses)
    {
        collect($modelClasses)->each(function (string $modelClass) {
            foreach (range(1, 0) as $index) {
                /** @var Model $modelClass */
                $modelClass::create(['name' => "name {$index}"]);
            }
        });
    }
}
