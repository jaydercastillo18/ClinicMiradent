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
        Schema::table('doctoras', function (Blueprint $table) {
            if (!Schema::hasColumn('doctoras', 'avatar')) {
                $table->longText('avatar')->nullable()->after('bio');
            } else {
                $table->longText('avatar')->nullable()->change();
            }
        });

        Schema::table('servicios', function (Blueprint $table) {
            if (Schema::hasColumn('servicios', 'imagen_path')) {
                $table->longText('imagen_path')->nullable()->change();
            }
        });

        Schema::table('promociones', function (Blueprint $table) {
            if (Schema::hasColumn('promociones', 'imagen_path')) {
                $table->longText('imagen_path')->nullable()->change();
            }
        });

        Schema::table('casos_exito', function (Blueprint $table) {
            if (Schema::hasColumn('casos_exito', 'antes_img')) {
                $table->longText('antes_img')->nullable()->change();
            }
            if (Schema::hasColumn('casos_exito', 'despues_img')) {
                $table->longText('despues_img')->nullable()->change();
            }
        });

        Schema::table('instalaciones', function (Blueprint $table) {
            if (Schema::hasColumn('instalaciones', 'imagen_path')) {
                $table->longText('imagen_path')->nullable()->change();
            }
        });

        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'value')) {
                $table->longText('value')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctoras', function (Blueprint $table) {
            if (Schema::hasColumn('doctoras', 'avatar')) {
                $table->dropColumn('avatar');
            }
        });
    }
};
