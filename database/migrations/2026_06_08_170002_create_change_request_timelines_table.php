<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('change_request_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('change_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('estimated_days');
            $table->decimal('cost', 12, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('remarks')->nullable();
            $table->enum('manager_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('manager_remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('change_request_timelines');
    }
};
