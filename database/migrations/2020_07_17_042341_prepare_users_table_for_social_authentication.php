<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrepareUsersTableForSocialAuthentication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            /* fbsg-signature-createSocialite:<begin> up function - prepare_users_table_for_social_authentication */
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
            /* fbsg-signature-createSocialite:<end> up function - prepare_users_table_for_social_authentication */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            /* fbsg-signature-createSocialite:<begin> down function - prepare_users_table_for_social_authentication */
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
            /* fbsg-signature-createSocialite:<end> down function - prepare_users_table_for_social_authentication */
        });
    }
}
