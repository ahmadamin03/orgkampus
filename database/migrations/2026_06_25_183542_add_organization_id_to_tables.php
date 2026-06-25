<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('organization_id')->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('prokers', function (Blueprint $table) {
            $table->foreignId('organization_id')->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('organization_id')->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('surats', function (Blueprint $table) {
            $table->foreignId('organization_id')->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('keuangans', function (Blueprint $table) {
            $table->foreignId('organization_id')->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->foreignId('organization_id')->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('kepanitiaans', function (Blueprint $table) {
            $table->foreignId('organization_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kepanitiaans', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
        Schema::table('keuangans', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
        Schema::table('surats', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
        Schema::table('prokers', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
    }
};
