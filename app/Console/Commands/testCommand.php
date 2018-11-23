<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repository\TestRepository;

class testCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'command:name';
    protected $signature = 'testCommand:test_name';

    /**
     * The console command description.
     *
     * @var string
     */
//    protected $description = 'Command description';
    protected $description = 'I am testing';



    private $testRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TestRepository $testRepository)
    {
        $this->testRepository = $testRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $param['age'] = 100;
        $this->testRepository->create($param);
    }
}
