<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->after('role')->constrained()->nullOnDelete();
            $table->string('mobile')->nullable()->after('email');
            $table->string('designation')->nullable()->after('mobile');
            $table->string('employee_id')->nullable()->unique()->after('designation');
            $table->string('department')->nullable()->after('employee_id');
            $table->string('experience')->nullable()->after('department');
            $table->text('skills')->nullable()->after('experience');
            $table->string('profile_photo')->nullable()->after('skills');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('profile_photo');
            $table->timestamp('last_login_at')->nullable()->after('status');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropConstrainedForeignId('client_id');
            $table->dropColumn([
                'mobile', 'designation', 'employee_id', 'department',
                'experience', 'skills', 'profile_photo', 'status', 'last_login_at',
            ]);
        });
    }
};
