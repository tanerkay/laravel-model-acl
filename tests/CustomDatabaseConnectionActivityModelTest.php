<?php

namespace Tanerkay\ModelAcl\Test;

use Illuminate\Database\SQLiteConnection;
use Tanerkay\ModelAcl\Models\ModelHasAccessControl;
use Tanerkay\ModelAcl\Test\Models\CustomDatabaseConnectionOnModelHasAccessControlModel;

class CustomDatabaseConnectionActivityModelTest extends TestCase
{
    public function testCustomDatabaseConnectionUsingConfig(): void
    {
        $model = new ModelHasAccessControl();

        $this->assertEquals(config('model_acl.database_connection'), $model->getConnectionName());
    }

    public function testCustomDatabaseConnection(): void
    {
        $model = new ModelHasAccessControl();

        $model->setConnection('custom');

        $this->assertNotEquals(config('model_acl.database_connection'), $model->getConnectionName());
        $this->assertEquals('custom', $model->getConnectionName());
    }

    public function testDatabaseConnectionUsingEmptyConfig(): void
    {
        $this->app['config']->set('model_acl.database_connection', null);

        $model = new ModelHasAccessControl();

        $this->assertInstanceOf(SQLiteConnection::class, $model->getConnection());
    }

    public function testCustomDatabaseConnectionUsingExtendedModel(): void
    {
        $model = new CustomDatabaseConnectionOnModelHasAccessControlModel();

        $this->assertNotEquals(config('model_acl.database_connection'), $model->getConnectionName());
        $this->assertEquals('custom_connection_name', $model->getConnectionName());
    }
}
