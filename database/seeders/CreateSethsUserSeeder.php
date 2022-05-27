<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateSethsUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = User::create([
            'name' => 'Seth Shoemaker',
            'email' => 'shoemakerseth2003@gmail.com',
            'email_verified_at' => '2022-05-26 02:04:01',
            'password' => '$2y$10$OKYRqZ43xKtHyGjUxDZOqOQ2kGYkTFjmz8mQvB.5VEYmCC.Fncv7W',
        ]);

        $organization = Organization::create([
            'name' => 'Demo Organization',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores sapiente eveniet accusamus placeat unde voluptatem ad aliquid quod ipsum. Earum suscipit cumque, recusandae quisquam quod libero magnam omnis cupiditate iure laboriosam ipsam ullam totam cum a consequuntur numquam distinctio ipsa. Vitae praesentium obcaecati dolore cumque? Officia nulla recusandae quibusdam consequuntur sit dolorem ullam quidem ut illum voluptatum repellat, explicabo eos magni neque. Amet ex numquam perferendis. Sequi sapiente voluptatum at culpa voluptatibus, ea quibusdam velit, itaque soluta nostrum hic dignissimos ducimus sunt cumque voluptatem. Est ipsa libero deleniti sed facilis provident, quam vero dolorum culpa dolor sint eum architecto voluptate',
            'owner_id' => $owner->id,
            'password' => '$2y$10$OKYRqZ43xKtHyGjUxDZOqOQ2kGYkTFjmz8mQvB.5VEYmCC.Fncv7W',
        ]);

        $owner_role_id = Role::where('title', 'owner')->pluck('id')->first();
        $owner->org_id = $organization->id;
        $owner->role_id = $owner_role_id;
        $owner->save();

        $submitter_role_id = Role::where('title', 'client')->pluck('id')->first();

        User::create([
            'name' => 'demo client',
            'org_id' => $organization->id,
            'role_id' => $submitter_role_id,
            'email' => 'connect@sethshoemaker.com',
            'email_verified_at' => '2022-05-26 02:04:01',
            'password' => '$2y$10$OKYRqZ43xKtHyGjUxDZOqOQ2kGYkTFjmz8mQvB.5VEYmCC.Fncv7W',
        ]);
    }
}
