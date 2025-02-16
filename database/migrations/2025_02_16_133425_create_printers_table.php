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
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            //name
            $table->string('name');
            //interface
            $table->string('connection_type');
            //mac address nullable
            $table->string('mac_address')->nullable();
            //ip address nullable
            $table->string('ip_address')->nullable();
            //paper width
            $table->integer('paper_width');
            //default printer
            $table->boolean('default')->default(false);
            //business id
            $table->foreignId('business_id')->constrained('businesses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
