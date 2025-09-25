<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up(): void
       {
           Schema::table('photos', function (Blueprint $table) {
               $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('category_id');
           });
       }

       public function down(): void
       {
           Schema::table('photos', function (Blueprint $table) {
               $table->dropColumn('status');
           });
       }
   };