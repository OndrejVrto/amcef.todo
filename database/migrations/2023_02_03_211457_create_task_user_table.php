<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void {
        Schema::create('task_user', function (Blueprint $table): void {
            $table->smallInteger('owner_type');
            $table->foreignId('task_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->primary(['user_id', 'task_id'], 'task_user_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('task_user');
    }
};
