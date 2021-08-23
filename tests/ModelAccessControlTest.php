<?php

namespace Tanerkay\ModelAcl\Test;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tanerkay\ModelAcl\Exceptions\AuthorizationException;
use Tanerkay\ModelAcl\Models\ModelHasAccessControl;
use Tanerkay\ModelAcl\Rules\HasRole;
use Tanerkay\ModelAcl\Test\Models\Node;
use Tanerkay\ModelAcl\Test\Models\User;

class ModelAccessControlTest extends TestCase
{
    protected Node $node;
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->node = new class() extends Node {
            use SoftDeletes;
        };

        $this->user = new class() extends User {
            use SoftDeletes;
        };

        $this->assertCount(0, ModelHasAccessControl::all());
    }

    public function testModelAccessControl(): void
    {
        $node = $this->createNode();

        $ruleDefinitions = [
            [
                'class' => HasRole::class,
                'arguments' => 'editor',
            ]
        ];

        $node->addAccessControl('edit', $ruleDefinitions, 'editor can edit nodes');

        $editor = $this->createUser('editor');

        $node->can('edit', $editor);

        $member = $this->createUser('member');

        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage(AuthorizationException::doesNotHaveRole('editor')->getMessage());
        $node->can('edit', $member);
    }

    private function createNode(): Node
    {
        $node = new $this->node();
        $node->name = 'my first page';
        $node->save();

        return $node;
    }

    private function createUser(string|array $roles): User
    {
        $user = new $this->user();
        $user->name = 'Jarrah';
        $user->roles = (array) $roles;
        $user->save();

        return $user;
    }
}
