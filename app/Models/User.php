<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik',
        'name',
        'foto',
        'email',
				'email_kantor',
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
				'bukti_padan',
				'bukti_padan_file',
				'claim_principal_id',
				'family_lain'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $appends = [
    //     'lokasi', 'blood', 'image_url', 'role', 'mutasi'
    // ];

		

    public function getLokasiAttribute()
    {
        $get = Lokasi::find($this->lokasi_id);
        if (empty($get)) {
            return '-';
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

    public function getPtkpAttribute()
    {
        return Ptkp::find($this->ptkp_id);
    }

		public function getClaimPrincipalAttribute()
    {
        return ClaimPrincipal::find($this->claim_principal_id);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
