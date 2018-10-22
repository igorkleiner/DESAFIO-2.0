<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class criarDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'criar:DB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        printf("\nInicio da criação da estrutura da base de dados");
        \Schema::create('log_utilizacao', function (Blueprint $table) {
			$table->increments('lga_id');
			$table->integer('usu_id')->nullable();
			$table->text('lga_dados')->nullable();
			$table->timestamp('lga_data')->useCurrent();
		});
		//table tipo_cronjob
		\Schema::create('tipo_cronjob', function (Blueprint $table) {
			$table->increments('cron_id');
			$table->string('cron_constante',50);
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->nullable();
			$table->timestamp('deleted_at')->nullable();
		});
		//table cronjob_log
		\Schema::create('cronjob_log', function (Blueprint $table) {
			$table->increments('cronl_id');
			$table->unsignedInteger('cron_id');
			$table->foreign('cron_id')->references('cron_id')->on('tipo_cronjob');
			$table->timestamp('cronl_data_inicio')->useCurrent();
			$table->timestamp('cronl_data_fim')->nullable();
			$table->smallInteger('cronl_status')->nullable();
			$table->text('cronl_mensagem',500)->nullable();
        });
        printf("\nTudo pronto, Have a little fun!!!");
    }
}
