<?php

namespace Acacia\Core\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Input\InputArgument;

class AssignRoleCommand extends Command
{
    protected $name = 'acacia:assign-role';

    protected $description = 'Quickly assign a role to a user';

    public function handle()
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');
        try {
            $user = User::query()->where("email","=", $email)->firstOrFail();
            $role = Role::query()->firstOrCreate([
                "name" => $roleName,
            ],[
                "name" => $roleName,
                "guard_name" => "web"
            ]);
            $user->assignRole($role);
            $this->info("$roleName has been given to $user?->name ($email)");
        } catch (\Throwable $exception) {
            \Log::error($exception);
            $this->error($exception->getMessage());
        }
    }
    protected function getArguments(): array
    {
        return [
            ["email",InputArgument::REQUIRED,"Email of user to assign the role to"],
            ["role",InputArgument::REQUIRED,"Role name to assign"],
        ];
    }
}
