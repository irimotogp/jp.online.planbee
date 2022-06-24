<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\IntroducerType;
use App\Enums\NthType;
use App\Enums\ISDType;
use App\Enums\WEGType;
use App\Enums\DirectionType;

class CreateIntroducersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('introducers', function (Blueprint $table) {
            $table->id();
            $table->string('sinsei_name')->nullable()->commet('登録申請者氏名');
            $table->string('sinsei_email')->nullable()->commet('登録申請者メールアドレス');
            $table->enum('introducer_type', IntroducerType::ALL_OPTIONS)->nullable()->commet('タイプ');
            $table->string('syoukai_id')->nullable()->commet('紹介取次店ID');
            $table->string('syoukai_name')->nullable()->commet('紹介取次店名');
            $table->string('eva_id')->nullable()->commet('エバンジェリストID');
            $table->string('eva_name')->nullable()->commet('エバンジェリスト名');
            $table->enum('nth_type', NthType::ALL_OPTIONS)->nullable()->commet('Nth人目');
            $table->enum('isd_type', ISDType::ALL_OPTIONS)->nullable()->commet('直上者指定');
            $table->string('isd_id')->nullable()->commet('直上者ID');
            $table->string('isd_name')->nullable()->commet('直上者名');
            $table->enum('direction_type', DirectionType::ALL_OPTIONS)->nullable()->commet('直上者のライン');
            $table->enum('weg_type', WEGType::ALL_OPTIONS)->nullable()->commet('電解水生成器');
            $table->text('note')->nullable()->commet('備考');
            $table->string('uuid')->nullable()->comment('UUID');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('introducers');
    }
}
