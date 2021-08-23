<?php

namespace Tanerkay\ModelAcl\Test\Models;

use Tanerkay\ModelAcl\Models\ModelHasAccessControl;

class CustomTableNameOnModelHasAccessControlModel extends ModelHasAccessControl
{
    protected $table = 'custom_table_name';
}
