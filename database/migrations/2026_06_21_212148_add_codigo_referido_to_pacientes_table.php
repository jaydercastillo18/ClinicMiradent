<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('codigo_referido', 20)->nullable()->unique()->after('id');
        });

        // Generate codes for existing patients
        $pacientes = DB::table('pacientes')->get();
        foreach ($pacientes as $paciente) {
            $codigo = null;
            $exists = true;
            while ($exists) {
                $codigo = strtoupper(Str::random(16));
                $exists = DB::table('pacientes')->where('codigo_referido', $codigo)->exists();
            }
            DB::table('pacientes')->where('id', $paciente->id)->update(['codigo_referido' => $codigo]);
        }

        // Now make it not nullable if needed, but since it's an existing table we can just enforce it on app level.
        // It's safer to leave as nullable in DB just in case, but enforce via eloquent. Actually, better to enforce not null now.
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('codigo_referido', 20)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn('codigo_referido');
        });
    }
};
