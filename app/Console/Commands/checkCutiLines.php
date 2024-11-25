<?php

namespace App\Console\Commands;

use App\Models\CutiLines;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class checkCutiLines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkCutiLines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cuti Lines Checker not Count';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      ini_set('max_execution_time', 300);

			$get = DB::table('view_check_cuti_lines')->get();

			if (count($get) > 0) 
			{
				foreach ($get as $key => $value) 
				{
					$data = [
						'approval_st' => 1
					];

					CutiLines::where('cuti_header_id',$value->cuti_header_id)->update($data);
				}

				$info = 'Info, Auto approval lines success!';
			}
			else
			{
				$info = 'Info, Auto approval lines success but empty!';
			}

			$this->info($info);
      return $info;
    }
}
