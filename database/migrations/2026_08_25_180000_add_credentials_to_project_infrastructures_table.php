<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_infrastructures', function (Blueprint $table) {
            $table->string('domain_provider')->nullable()->after('domain_url');
            $table->string('domain_user')->nullable()->after('domain_provider');
            $table->string('domain_pass')->nullable()->after('domain_user');
            $table->string('hosting_user')->nullable()->after('hosting_provider');
            $table->string('hosting_pass')->nullable()->after('hosting_user');
            $table->json('extra_credentials')->nullable()->after('panel_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_infrastructures', function (Blueprint $table) {
            $table->dropColumn([
                'domain_provider',
                'domain_user',
                'domain_pass',
                'hosting_user',
                'hosting_pass',
                'extra_credentials',
            ]);
        });
    }
};
