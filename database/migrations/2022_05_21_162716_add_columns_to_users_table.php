<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name',100)->nullable()->after('name');
            $table->string('last_name',100)->nullable()->after('first_name');
            $table->tinyInteger('role')->default(0)->comment('0 = user, 1 = admin')->after('last_name');
            $table->string('image')->nullable()->after('role');
        });

        DB::table('users')->insert([
            'name' => 'Admin',
            'role' => 1,
            'email' => env('ADMIN_EMAIL')?? 'admin@gmail.com',
            'password' => '$2y$10$QQjgPtbJpFSrXyNmObrMS.CRn8R09Z6yhRfis/bJqsfRK30Aii8AO',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('role');
            $table->dropColumn('image');
        });
    }
};
