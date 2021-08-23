<?php

namespace Tanerkay\ModelAcl\Test\Models;

use Tanerkay\ModelAcl\Models\ModelHasAccessControl;

class CustomDatabaseConnectionOnModelHasAccessControlModel extends ModelHasAccessControl
{
    protected $connection = 'custom_connection_name';
}
