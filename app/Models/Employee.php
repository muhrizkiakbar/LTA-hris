<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Employee extends Model
{
    use HasFactory, LogsActivity;

		protected $table = 'users';
		protected $fillable = [
			'nik',
			'name',
			'foto',
			'email',
			'password',
			'ktp_no',
			'ktp',
			'no_hp',
			'tempat_lahir',
			'tgl_lahir',
			'gender_id',
			'religion_id',
			'join_date',
			'lokasi_id',
			'marriage_id',
			'blood_id',
			'ptkp_id',
			'country_id',
			'suku',
			'alamat',
			'alamat_lain',
			'kodepos',
			'sign_file',
			'resign_date',
			'resign_reason',
			'resign_file',
			'resign_st',
			'kk',
			'ijazah',
			'ijazah_id',
			'npwp',
			'npwp_no',
			'mutasi_id',
			'bpjstk',
			'bpjs',
			'role_id',
			'lokasi_id',
			'department_id',
			'divisi_id',
			'jabatan_id',
			'department_jabatan_id',
			'atasan_id',
			'bank_id',
			'no_rek',
			'distrik_id',
			'ijazah_institusi',
			'ijazah_jurusan',
			'perusahaan_id',
			'emergency_call',
			'ibu_kandung',
			'resign_types_id',
			'resign_statuses_id',
			'resign_interview_st',
			'resign_clearance_st',
			'bukti_padan',
			'bukti_padan_file',
			'claim_principal_id',
			'email_kantor',
			'family_lain'
		];

		
		public function getActivitylogOptions(): LogOptions
    {
			$data = [
				'nik',
				'name',
				'foto',
				'email',
				'password',
				'ktp_no',
				'ktp',
				'no_hp',
				'tempat_lahir',
				'tgl_lahir',
				'gender_id',
				'religion_id',
				'join_date',
				'lokasi_id',
				'marriage_id',
				'blood_id',
				'ptkp_id',
				'country_id',
				'suku',
				'alamat',
				'alamat_lain',
				'kodepos',
				'sign_file',
				'resign_date',
				'resign_reason',
				'resign_file',
				'resign_st',
				'kk',
				'ijazah',
				'ijazah_id',
				'npwp',
				'npwp_no',
				'mutasi_id',
				'bpjstk',
				'bpjs',
				'role_id',
				'lokasi_id',
				'department_id',
				'divisi_id',
				'jabatan_id',
				'department_jabatan_id',
				'atasan_id',
				'bank_id',
				'no_rek',
				'distrik_id',
				'ijazah_institusi',
				'ijazah_jurusan',
				'perusahaan_id',
				'emergency_call',
				'ibu_kandung',
				'resign_types_id',
				'resign_statuses_id',
				'resign_interview_st',
				'resign_clearance_st',
				'bukti_padan',
				'bukti_padan_file',
				'claim_principal_id',
				'email_kantor',
				'family_lain'
			];

			return LogOptions::defaults()
											 ->logOnly($data)
											 ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName} By : ".Auth::user()->email)
											 ->logOnlyDirty()
											 ->useLogName('Employee');
    }

		public function getLokasiAttribute()
    {
        $get = Lokasi::find($this->lokasi_id);
        if (empty($get)) {
            return NULL;
        } else {
            return $get->title;
        }
    }

		public function getLokasiDetailAttribute()
		{
			return Lokasi::find($this->lokasi_id);
		}

    public function getBloodAttribute()
    {
        return Blood::find($this->blood_id);
    }

    public function getGenderAttribute()
    {
        return Gender::find($this->gender_id);
    }

    public function getMarriageAttribute()
    {
        return Marriage::find($this->marriage_id);
    }

    public function getImageUrlAttribute()
    {
        $imgx = $this->foto;
        $nik = $this->nik;

        if (empty($imgx)) {
            return '<img src="' . Storage::url('upload/employee/profile.png') . '" class="img-fluid" width="50px">';
        } else {
            return '<img src="' . Storage::url('upload/employee/' . $nik . '/' . $imgx).'" class="img-fluid" width="50px">';
        }
    }

    public function getRoleAttribute()
    {
        return UsersRole::find($this->role_id);
    }

    public function getImagePicAttribute()
    {
        $img = $this->foto;
        $nik = $this->nik;

        if (empty($img)) {
            return '<img src="' . Storage::url('upload/employee/profile.png') . '" class="img-fluid" width="150px">';
        } else {
            return '<img src="' . Storage::url('upload/employee/' . $nik . '/' . $img).'" class="img-fluid" width="150px">';
        }
    }

    public function getSignPicAttribute()
    {
        $img = $this->sign_file;
        $nik = $this->nik;

        if ($img == '') {
            return '<img src="' . Storage::url('upload/employee/sign.jpg') . '" class="img-fluid">';
        } else {
            return '<img src="' . Storage::url('upload/employee/' . $nik . '/' . $img) . '" class="img-fluid">';
        }
    }

    public function getUserLokasiAttribute()
    {
        $lokasi = '';
        $user = $this->id;

        $get_lokasi = UserLokasi::where('users_id', $user);

        if ($get_lokasi->count() == 0) {
            return 'Semua Lokasi';
        } else {
            $no = 1;
            $count = $get_lokasi->count();

            foreach ($get_lokasi->get() as $item) {
                $nox = $no++;
                if ($nox == $count) {
                    $sepa = '';
                } else {
                    $sepa = ',';
                }

                $lokasi .= $item->lokasi->title . $sepa;
            }

            return $lokasi;
        }
    }

    public function getMutasiAttribute()
    {
        return Mutasi::where('user_id', $this->id)->where('status', 1)->orderBy('id', 'DESC')->first();
    }

    public function getKontrakAttribute()
    {
        return KontrakKerja::where('user_id',$this->id)->where('status',1)->orderBy('id','DESC')->limit(1)->first();
    }

    public function getTrainingAttribute()
    {
        return TrainingLines::where('user_id',$this->id)->orderBy('id','DESC')->limit(1)->first();
    }

    public function getDepartmentAttribute()
    {
        return Department::find($this->department_id);
    }

    public function getDivisiAttribute()
    {
        return Divisi::find($this->divisi_id);
    }

    public function getEmployeeAttribute()
    {
        return User::find($this->user_id);
    }

    public function getLvlAttribute()
    {
        return Jabatan::find($this->jabatan_id);
    }

    public function getJabatanAttribute()
    {
        return DepartmentJabatan::find($this->department_jabatan_id);
    }

    public function getAtasanAttribute()
    {
        return User::find($this->atasan_id);
    }

    public function getPerusahaanAttribute()
    {
        return Perusahaan::find($this->perusahaan_id);
    }

    public function getCountryAttribute()
    {
        return Country::find($this->country_id);
    }

    public function getSlotingAttribute()
    {
        return Sloting::where('users_id',$this->id)->first();
    }

    public function getBankAttribute()
    {
        return Bank::find($this->bank_id);
    }

    public function getDistrikAttribute()
    {
        return Distrik::find($this->distrik_id);
    }

    public function getIjazahDetailAttribute()
    {
        return Ijazah::find($this->ijazah_id);
    }

    public function getPtkpDetailAttribute()
    {
        return Ptkp::find($this->ptkp_id);
    }

		public function getPtkpAttribute()
    {
        return Ptkp::find($this->ptkp_id);
    }
		
		public function getResignTypeAttribute()
		{
			$type = $this->resign_types_id;

			if (isset($type)) 
			{
				$data = ResignType::find($type);
				$result = $data->title;
			}
			else
			{
				$result = 'Resign';
			}

			return $result;
		}

		public function getResignStatusAttribute()
		{
			$type = $this->resign_statuses_id;

			if (isset($type)) 
			{
				$data = ResignStatus::find($type);
				$result = $data->label;
			}
			else
			{
				$result = '<span class="badge badge-success">Success</span>';
			}

			return $result;
		}

		public function getClaimPrincipalAttribute()
    {
        return ClaimPrincipal::find($this->claim_principal_id);
    }
}
