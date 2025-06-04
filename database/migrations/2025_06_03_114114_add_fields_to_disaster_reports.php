<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDisasterReports extends Migration
{
    public function up()
    {
        Schema::table('disaster_reports', function (Blueprint $table) {
            $table->string('damage_report', 255)->nullable()->after('damage_status');
            $table->unsignedBigInteger('reported_by')->nullable()->after('damage_report');
            $table->timestamp('reported_at')->nullable()->after('reported_by');

            $table->foreign('reported_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('disaster_reports', function (Blueprint $table) {
            $table->dropForeign(['reported_by']);
            $table->dropColumn(['damage_report', 'reported_by', 'reported_at']);
        });
    }
}
