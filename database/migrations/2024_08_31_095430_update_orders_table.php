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
        Schema::table('orders',function ($table){
            $table->biginteger('contactno');
            $table->string('status')->default('Not Deliver yet');
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders',function ($table){
            $table->dropColumn('contactno');
            $table->dropColumn('status');
         });
    }
};
