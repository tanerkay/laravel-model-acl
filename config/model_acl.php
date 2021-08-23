<?php

return [

    /*
     * If set to false, no model based access control rules will be checked.
     */
    'enabled' => env('MODEL_ACL_ENABLED', true),

    /*
     * You can specify an auth driver that gets used by authorization rules.
     * If this is null we'll use the default Laravel auth driver.
     */
    'default_auth_driver' => null,

    /*
     * If set to true, the subject returns soft deleted models.
     */
    'subject_returns_soft_deleted_models' => false,

    /*
     * This model will be used to store access control records.
     * It should implement the `\Tanerkay\ModelAcl\Contracts\AccessControlContract` interface
     * and extend `\Illuminate\Database\Eloquent\Model`.
     */
    'access_control_model' => \Tanerkay\ModelAcl\Models\ModelHasAccessControl::class,

    /*
     * This is the name of the table that will be created by the migration and
     * used by the Activity model shipped with this package.
     */
    'table_name' => 'model_has_access_control',

    /*
     * This is the database connection that will be used by the migration and
     * the `ModelHasAccessControl` model shipped with this package. In case it's not set,
     * the config `database.default` will be used instead.
     */
    'database_connection' => env('MODEL_ACL_DB_CONNECTION'),

    /*
     * This maps methods invoked in rules to callable methods on models implementing the
     * `Authenticatable` contract.
     */
    'authenticatable_methods' => [
        'has_role' => env('MODEL_ACL_AUTHENTICATABLE_HAS_ROLE', 'hasRole'),
        'has_permission' => env('MODEL_ACL_AUTHENTICATABLE_HAS_PERMISSION', 'hasPermission'),
    ],
];
