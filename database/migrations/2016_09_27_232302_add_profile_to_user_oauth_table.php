<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileToUserOauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_oauth', function (Blueprint $table) {
            // 👇 添加 nullable() 或 default('')，以兼容 SQLite
            $table->text('profile')->nullable()->after('user_id')->collation('utf8mb4_unicode_ci');
            // 如果你更希望它不为 null，也可以用 ->default('')
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_oauth', function (Blueprint $table) {
            $table->dropColumn('profile');
        });
    }
}
