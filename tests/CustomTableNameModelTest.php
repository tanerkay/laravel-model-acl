<?php

namespace Tanerkay\ModelAcl\Test;

use Tanerkay\ModelAcl\Models\ModelHasAccessControl;
use Tanerkay\ModelAcl\Test\Models\CustomTableNameOnModelHasAccessControlModel;

class CustomTableNameModelTest extends TestCase
{
    public function testCustomTableNameUsingConfig(): void
    {
        $model = new ModelHasAccessControl();

        $this->assertEquals($model->getTable(), config('model_acl.table_name'));
    }

    public function testCustomTableNameUsingModelProperty(): void
    {
        $model = new ModelHasAccessControl();
        $customTableName = 'no_homers_club';

        $model->setTable($customTableName);

        $this->assertNotEquals(config('model_acl.table_name'), $model->getTable());
        $this->assertEquals($customTableName, $model->getTable());
    }

    public function testCustomTableNameUsingCustomModel(): void
    {
        $model = new CustomTableNameOnModelHasAccessControlModel();

        $this->assertNotEquals(config('model_acl.table_name'), $model->getTable());
        $this->assertEquals('custom_table_name', $model->getTable());
    }
}
