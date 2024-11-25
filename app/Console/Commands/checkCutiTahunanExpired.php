<?php

namespace App\Console\Commands;

use App\Models\CutiHeader;
use App\Models\CutiLines;
use App\Services\Cuti\TahunanServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class checkCutiTahunanExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkCutiTahunanExpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cuti Tahunan Auto Expired Reject';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
			ini_set('max_execution_time', 300);

			$data = [];

			$service = new TahunanServices;

			$date = date('Y-m-d');

			// dd($date);

			$get = DB::table('view_check_cuti_expired')
							 ->where('date_expired','<=',$date)
							 ->get();

			// dd($get);

			$reject_excuse = "Auto reject system (already expired)";

			if (count($get) > 0) 
			{
				foreach ($get as $key => $value) 
				{
					$cuti_id = $value->cuti_id;
					$random_number = substr(number_format(time() * rand(1111,9999),0,'',''),0,4);

					$data2 = [
						'periksa_st' => 0,
						'approval1_st' => 0,
						'approval2_st' => 0,
						'approval' => 2,
						'reject_id' => 5,
						'reject_excuse' => $reject_excuse
					];

					CutiHeader::where('kd',$value->kd)->update($data2);

					$data_lines = [
						'approval_st' => 0
					];
			
					CutiLines::where('cuti_header_id',$cuti_id)->update($data_lines);
					
					$pengajuan = 'Cuti Tahunan';
					$status = 'reject';
					$otp = $random_number;
					$encoded = base64_encode(time().'&'.$value->kd.'&'.$otp);
					$url = 'approval/cuti/tahunan/' . str_replace('=', '', $encoded);
					$teks_otp = "Kode OTP : *".intval($otp)."*";
					$message = whatsappMessage($value->employee_name, $pengajuan, 'SYSTEM', $value->kd, $status, $reject_excuse);

					$no_wa = $value->no_hp;
					$site = "https://hris.laut-timur.tech/";
					$teks_tengah = $site . $url;

					$message = sprintf("%s \n\n%s \n\n%s \n\n%s \n\nTerima Kasih", $message['subject'], $message['message'], $teks_tengah, $teks_otp);
					callWhatsapp2($no_wa, $message);
				}

				$info = 'Info, Auto Expired Reject success!';
			}
			else
			{
				$info = 'Info, Auto Expired Reject success but empty!';
			}

			// dd($data);

			$this->info($info);
      return $info;

			// $this->info($date);
      // return $date;
    }
}
