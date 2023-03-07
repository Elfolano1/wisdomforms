<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('interview_forms', function (Blueprint $table) {
            $table->id();
            $table->date('Date')->nullable();
            $table->text('Q_1')->nullable();
            $table->text('Q_2')->nullable();
            $table->boolean('Q_3')->default(0);
            $table->text('Q_4')->nullable();
            $table->text('Q_5')->nullable();
            $table->text('Q_6')->nullable();
            $table->boolean('Q_7')->default(0);
            $table->text('Q_8')->nullable();
            $table->text('Q_9')->nullable();
            $table->boolean('Q_10')->default(0);
            $table->boolean('Q_11')->default(0);
            $table->boolean('Q_12')->default(0);
            $table->text('Q_13')->nullable();
            $table->text('Q_14')->nullable();
            $table->text('Q_15')->nullable();
            $table->boolean('Q_16')->default(0);
            $table->text('Q_17')->nullable();
            $table->text('Q_18')->nullable();
            $table->text('Q_19')->nullable();
            $table->text('Q_20')->nullable();
            $table->boolean('signed')->default(0);
            $table->boolean('close_status')->default(0);
            $table->boolean('send_status')->default(0);
            $table->boolean('status')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable();
        //    $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_forms');
    }
};
