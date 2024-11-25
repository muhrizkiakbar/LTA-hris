<?php

use App\Http\Controllers\Approval\Absensi\IjinController as AbsensiIjinController;
use App\Http\Controllers\Approval\AppraisalController as ApprovalAppraisalController;
use App\Http\Controllers\Approval\Cuti\KhususController as CutiKhususController;
use App\Http\Controllers\Approval\Cuti\TahunanController as ApprovalCutiTahunanController;
use App\Http\Controllers\Approval\DinasController as ApprovalDinasController;
use App\Http\Controllers\Approval\ResignController as ApprovalResignController;
use App\Http\Controllers\Approval\Surat\IjinController as ApprovalSuratIjinController;
use App\Http\Controllers\Approval\Surat\TugasController as SuratTugasController;
use App\Http\Controllers\Backend\Absensi\AbsensiController;
use App\Http\Controllers\Backend\Absensi\IjinController;
use App\Http\Controllers\Backend\Absensi\RemarksController;
use App\Http\Controllers\Backend\ApprovalHrdController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\Cuti\BersamaController;
use App\Http\Controllers\Backend\Cuti\KhususController;
use App\Http\Controllers\Backend\Cuti\LiburController;
use App\Http\Controllers\Backend\Cuti\TahunanController;
use App\Http\Controllers\Backend\DinasController;
use App\Http\Controllers\Backend\Employee\AppraisalController;
use App\Http\Controllers\Backend\Employee\EmployeeController;
use App\Http\Controllers\Backend\Employee\KonselingController;
use App\Http\Controllers\Backend\Employee\KontrakKerjaController;
use App\Http\Controllers\Backend\Employee\MutasiController;
use App\Http\Controllers\Backend\Employee\ResignController;
use App\Http\Controllers\Backend\Employee\SlotingController;
use App\Http\Controllers\Backend\Employee\SuratPeringatanController;
use App\Http\Controllers\Backend\Employee\TrainingController;
use App\Http\Controllers\Backend\Employee\VaksinController;
use App\Http\Controllers\Backend\GraphController;
use App\Http\Controllers\Backend\Master\DinasExceptBiayaController;
use App\Http\Controllers\Backend\Master\DinasLokasiController;
use App\Http\Controllers\Backend\Master\LokasiController;
use App\Http\Controllers\Backend\Payroll\IncentiveController;
use App\Http\Controllers\Backend\Payroll\KomponenGajiController;
use App\Http\Controllers\Backend\Payroll\PayrollController;
use App\Http\Controllers\Backend\Report\AbsensiController as ReportAbsensiController;
use App\Http\Controllers\Backend\Report\DinasController as ReportDinasController;
use App\Http\Controllers\Backend\Report\EmployeeController as ReportEmployeeController;
use App\Http\Controllers\Backend\Surat\IjinController as SuratIjinController;
use App\Http\Controllers\Backend\Surat\TugasController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
	'register' => false, // Registration Routes...
	'reset' => false, // Password Reset Routes...
	'verify' => false, // Email Verification Routes...
]);

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/approval/cuti/tahunan/{code}', [ApprovalCutiTahunanController::class, 'index']);
Route::post('/approval/cuti/tahunan/otp', [ApprovalCutiTahunanController::class, 'otp'])->name('approval.cuti_tahunan.otp');
Route::get('/approval/cuti/tahunan/periksa/{code}', [ApprovalCutiTahunanController::class, 'periksa'])->name('approval.cuti_tahunan.periksa');
Route::get('/approval/cuti/tahunan/setuju/{code}', [ApprovalCutiTahunanController::class, 'setuju'])->name('approval.cuti_tahunan.setuju');
Route::get('/approval/cuti/tahunan/ketahui/{code}', [ApprovalCutiTahunanController::class, 'ketahui'])->name('approval.cuti_tahunan.ketahui');
Route::post('/approval/cuti/tahunan/reject', [ApprovalCutiTahunanController::class, 'reject'])->name('approval.cuti_tahunan.reject');
Route::post('/approval/cuti/tahunan/reject_update', [ApprovalCutiTahunanController::class, 'reject_update'])->name('approval.cuti_tahunan.reject_update');

Route::get('/approval/cuti/khusus/{code}', [CutiKhususController::class, 'index']);
Route::post('/approval/cuti/khusus/otp', [CutiKhususController::class, 'otp'])->name('approval.cuti_khusus.otp');
Route::get('/approval/cuti/khusus/periksa/{code}', [CutiKhususController::class, 'periksa'])->name('approval.cuti_khusus.periksa');
Route::get('/approval/cuti/khusus/setuju/{code}', [CutiKhususController::class, 'setuju'])->name('approval.cuti_khusus.setuju');
Route::get('/approval/cuti/khusus/ketahui/{code}', [CutiKhususController::class, 'ketahui'])->name('approval.cuti_khusus.ketahui');
Route::post('/approval/cuti/khusus/reject', [CutiKhususController::class, 'reject'])->name('approval.cuti_khusus.reject');
Route::post('/approval/cuti/khusus/reject_update', [CutiKhususController::class, 'reject_update'])->name('approval.cuti_khusus.reject_update');

Route::get('/approval/absensi/ijin/{code}', [AbsensiIjinController::class, 'index']);
Route::get('/approval/absensi/ijin/periksa/{code}', [AbsensiIjinController::class, 'periksa'])->name('approval.absensi_ijin.periksa');
Route::get('/approval/absensi/ijin/setuju/{code}', [AbsensiIjinController::class, 'setuju'])->name('approval.absensi_ijin.setuju');
Route::get('/approval/absensi/ijin/ketahui/{code}', [AbsensiIjinController::class, 'ketahui'])->name('approval.absensi_ijin.ketahui');
Route::post('/approval/absensi/ijin/reject', [AbsensiIjinController::class, 'reject'])->name('approval.absensi_ijin.reject');
Route::post('/approval/absensi/ijin/reject_update', [AbsensiIjinController::class, 'reject_update'])->name('approval.absensi_ijin.reject_update');
Route::post('/approval/absensi/ijin/otp', [AbsensiIjinController::class, 'otp'])->name('approval.absensi_ijin.otp');

Route::get('/approval/surat/tugas/{code}', [SuratTugasController::class, 'index']);
Route::get('/approval/surat/tugas/periksa/{code}', [SuratTugasController::class, 'periksa'])->name('approval.surat_tugas.periksa');
Route::get('/approval/surat/tugas/setuju/{code}', [SuratTugasController::class, 'setuju'])->name('approval.surat_tugas.setuju');
Route::get('/approval/surat/tugas/ketahui/{code}', [SuratTugasController::class, 'ketahui'])->name('approval.surat_tugas.ketahui');
Route::post('/approval/surat/tugas/reject', [SuratTugasController::class, 'reject'])->name('approval.surat_tugas.reject');
Route::post('/approval/surat/tugas/reject_update', [SuratTugasController::class, 'reject_update'])->name('approval.surat_tugas.reject_update');
Route::post('/approval/surat/tugas/otp', [SuratTugasController::class, 'otp'])->name('approval.surat_tugas.otp');

Route::get('/approval/surat/ijin/{code}', [ApprovalSuratIjinController::class, 'index']);
Route::get('/approval/surat/ijin/periksa/{code}', [ApprovalSuratIjinController::class, 'periksa'])->name('approval.surat_ijin.periksa');
Route::get('/approval/surat/ijin/setuju/{code}', [ApprovalSuratIjinController::class, 'setuju'])->name('approval.surat_ijin.setuju');
Route::get('/approval/surat/ijin/ketahui/{code}', [ApprovalSuratIjinController::class, 'ketahui'])->name('approval.surat_ijin.ketahui');
Route::post('/approval/surat/ijin/reject', [ApprovalSuratIjinController::class, 'reject'])->name('approval.surat_ijin.reject');
Route::post('/approval/surat/ijin/reject_update', [ApprovalSuratIjinController::class, 'reject_update'])->name('approval.surat_ijin.reject_update');
Route::post('/approval/surat/ijin/otp', [ApprovalSuratIjinController::class, 'otp'])->name('approval.surat_ijin.otp');

Route::get('/approval/dinas/{code}', [ApprovalDinasController::class, 'index']);
Route::get('/approval/dinas/periksa/{code}', [ApprovalDinasController::class, 'periksa'])->name('approval.dinas.periksa');
Route::get('/approval/dinas/setuju/{code}', [ApprovalDinasController::class, 'setuju'])->name('approval.dinas.setuju');
Route::get('/approval/dinas/ketahui/{code}', [ApprovalDinasController::class, 'ketahui'])->name('approval.dinas.ketahui');
Route::get('/approval/dinas/ketahui_trf/{code}', [ApprovalDinasController::class, 'ketahui_trf'])->name('approval.dinas.ketahui_trf');
Route::post('/approval/dinas/reject', [ApprovalDinasController::class, 'reject'])->name('approval.dinas.reject');
Route::post('/approval/dinas/reject_update', [ApprovalDinasController::class, 'reject_update'])->name('approval.dinas.reject_update');
Route::post('/approval/dinas/otp', [ApprovalDinasController::class, 'otp'])->name('approval.dinas.otp');

Route::get('/resign/interview/{code}', [ApprovalResignController::class, 'interview'])->name('resign.interview');
Route::post('/resign/interview/score', [ApprovalResignController::class, 'interview_score'])->name('resign.interview.store');
Route::post('/resign/interview/otp', [ApprovalResignController::class, 'interview_otp'])->name('resign.interview.otp');
Route::post('/resign/interview/store', [ApprovalResignController::class, 'interview_store'])->name('resign.interview.store');

Route::get('/resign/clearance/{code}', [ApprovalResignController::class, 'clearance'])->name('resign.clearance');
Route::post('/resign/clearance/score', [ApprovalResignController::class, 'clearance_score'])->name('resign.clearance.store');
Route::post('/resign/clearance/otp', [ApprovalResignController::class, 'clearance_otp'])->name('resign.clearance.otp');
Route::post('/resign/clearance/store', [ApprovalResignController::class, 'clearance_store'])->name('resign.clearance.store');

Route::get('/approval/appraisal/{code}', [ApprovalAppraisalController::class, 'index'])->name('approval.appraisal');
Route::post('/approval/appraisal/otp', [ApprovalAppraisalController::class, 'otp'])->name('approval.appraisal.otp');
Route::post('/approval/appraisal/atasan', [ApprovalAppraisalController::class, 'atasan'])->name('approval.appraisal.atasan');
Route::post('/approval/appraisal/manager', [ApprovalAppraisalController::class, 'manager'])->name('approval.appraisal.manager');


Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', [BackendController::class, 'dashboard'])->name('dashboard');

	Route::get('/', [BackendController::class, 'index'])->name('backend');
  Route::get('/backend/logout', [BackendController::class, 'logout'])->name('backend.logout');
	Route::post('/backend/password', [BackendController::class, 'password'])->name('backend.password');
	Route::post('/backend/password_update', [BackendController::class, 'password_update'])->name('backend.password_update');
	Route::get('/backend/history', [BackendController::class, 'history'])->name('backend.history');
	Route::post('/backend/get_department_jabatan', [BackendController::class, 'get_department_jabatan'])->name('backend.get_department_jabatan');
	Route::post('/backend/get_jabatan_exist', [BackendController::class, 'get_jabatan_exist'])->name('backend.get_jabatan_exist');
	Route::post('/backend/get_employee_exchange', [BackendController::class, 'get_employee_exchange'])->name('backend.get_employee_exchange');
	Route::get('/backend/activity_user', [BackendController::class, 'activity_user'])->name('backend.activity_user');

	Route::get('/backend/whatsapp', [BackendController::class, 'whatsapp'])->name('backend.whatsapp');
	Route::get('/backend/whatsapp_resend/{id}', [BackendController::class, 'whatsapp_resend'])->name('backend.whatsapp_resend');

	Route::get('/backend/users', [UserController::class, 'index'])->name('backend.users');
	Route::post('/backend/users/create', [UserController::class, 'create'])->name('backend.users.create');
	Route::post('/backend/users/store', [UserController::class, 'store'])->name('backend.users.store');
	Route::post('/backend/users/edit', [UserController::class, 'edit'])->name('backend.users.edit');
	Route::put('/backend/users/update/{id}', [UserController::class, 'update'])->name('backend.users.update');
	Route::post('/backend/users/lokasi', [UserController::class, 'lokasi'])->name('backend.users.lokasi');
	Route::post('/backend/users/lokasi_update', [UserController::class, 'lokasi_update'])->name('backend.users.lokasi_update');
	Route::get('/backend/users/lokasi_delete/{id}', [UserController::class, 'lokasi_delete'])->name('backend.users.lokasi_delete');
	Route::get('/backend/users/delete/{id}', [UserController::class, 'delete'])->name('backend.users.delete');
	Route::post('/backend/users/password', [UserController::class, 'password'])->name('backend.users.password');
	Route::post('/backend/users/password_update', [UserController::class, 'password_update'])->name('backend.users.password_update');

	Route::get('/backend/approval_hrd', [ApprovalHrdController::class, 'index'])->name('backend.approval_hrd');

	Route::get('/backend/employee', [EmployeeController::class, 'index'])->name('backend.employee');

	Route::get('/backend/employee/create', [EmployeeController::class, 'create'])->name('backend.employee.create');
	Route::post('/backend/employee/store', [EmployeeController::class, 'store'])->name('backend.employee.store');
	Route::get('/backend/employee/detail/{id}', [EmployeeController::class, 'detail'])->name('backend.employee.detail');
	Route::post('/backend/employee/edit', [EmployeeController::class, 'edit'])->name('backend.employee.edit');
	Route::put('/backend/employee/update/{id}', [EmployeeController::class, 'update'])->name('backend.employee.update');
	Route::post('/backend/employee/detail_cuti', [EmployeeController::class, 'detail_cuti'])->name('backend.employee.detail_cuti');
	Route::get('/backend/employee/reset_password/{id}', [EmployeeController::class, 'reset_password'])->name('backend.employee.reset_password');
	Route::post('/backend/employee/sign', [EmployeeController::class, 'sign'])->name('backend.employee.sign');
	Route::post('/backend/employee/sign_update', [EmployeeController::class, 'sign_update'])->name('backend.employee.sign_update');
	Route::post('/backend/employee/ktp', [EmployeeController::class, 'ktp'])->name('backend.employee.ktp');
	Route::post('/backend/employee/ktp_view', [EmployeeController::class, 'ktp_view'])->name('backend.employee.ktp_view');
	Route::put('/backend/employee/ktp_update/{id}', [EmployeeController::class, 'ktp_update'])->name('backend.employee.ktp_update');
	Route::get('/backend/employee/ktp_delete/{id}', [EmployeeController::class, 'ktp_delete'])->name('backend.employee.ktp_delete');
	Route::post('/backend/employee/kartu_keluarga', [EmployeeController::class, 'kartu_keluarga'])->name('backend.employee.kartu_keluarga');
	Route::post('/backend/employee/kartu_keluarga_view', [EmployeeController::class, 'kartu_keluarga_view'])->name('backend.employee.kartu_keluarga_view');
	Route::put('/backend/employee/kartu_keluarga_update/{id}', [EmployeeController::class, 'kartu_keluarga_update'])->name('backend.employee.kartu_keluarga_update');
	Route::get('/backend/employee/kartu_keluarga_delete/{id}', [EmployeeController::class, 'kartu_keluarga_delete'])->name('backend.employee.kartu_keluarga_delete');
	Route::post('/backend/employee/ijazah', [EmployeeController::class, 'ijazah'])->name('backend.employee.ijazah');
	Route::post('/backend/employee/ijazah_view', [EmployeeController::class, 'ijazah_view'])->name('backend.employee.ijazah_view');
	Route::put('/backend/employee/ijazah_update/{id}', [EmployeeController::class, 'ijazah_update'])->name('backend.employee.ijazah_update');
	Route::get('/backend/employee/ijazah_delete/{id}', [EmployeeController::class, 'ijazah_delete'])->name('backend.employee.ijazah_delete');
	Route::post('/backend/employee/npwp', [EmployeeController::class, 'npwp'])->name('backend.employee.npwp');
	Route::post('/backend/employee/npwp_view', [EmployeeController::class, 'npwp_view'])->name('backend.employee.npwp_view');
	Route::put('/backend/employee/npwp_update/{id}', [EmployeeController::class, 'npwp_update'])->name('backend.employee.npwp_update');
	Route::get('/backend/employee/npwp_delete/{id}', [EmployeeController::class, 'npwp_delete'])->name('backend.employee.npwp_delete');
	Route::post('/backend/employee/bukti_padan', [EmployeeController::class, 'bukti_padan'])->name('backend.employee.bukti_padan');
	Route::post('/backend/employee/bukti_padan_view', [EmployeeController::class, 'bukti_padan_view'])->name('backend.employee.bukti_padan_view');
	Route::put('/backend/employee/bukti_padan_update/{id}', [EmployeeController::class, 'bukti_padan_update'])->name('backend.employee.bukti_padan_update');
	Route::get('/backend/employee/bukti_padan_delete/{id}', [EmployeeController::class, 'bukti_padan_delete'])->name('backend.employee.bukti_padan_delete');
	Route::post('/backend/employee/export', [EmployeeController::class, 'export'])->name('backend.employee.export');
	Route::post('/backend/employee/export_proses', [EmployeeController::class, 'export_proses'])->name('backend.employee.export_proses');
	Route::get('/backend/employee/reactive/{id}', [EmployeeController::class, 'reactive'])->name('backend.employee.reactive');

	Route::get('/backend/employee/verifikasi_employee', [EmployeeController::class, 'verifikasi_employee'])->name('backend.employee.verifikasi_employee');
	Route::post('/backend/employee/verifikasi_employee_search', [EmployeeController::class, 'verifikasi_employee_search'])->name('backend.employee.verifikasi_employee_search');

	Route::post('/backend/employee/vaksin', [VaksinController::class, 'index'])->name('backend.employee.vaksin');
	Route::post('/backend/employee/vaksin/store', [VaksinController::class, 'store'])->name('backend.employee.vaksin.store');
	Route::post('/backend/employee/vaksin/view', [VaksinController::class, 'view'])->name('backend.employee.vaksin.view');
	Route::get('/backend/employee/vaksin/delete/{id}', [VaksinController::class, 'delete'])->name('backend.employee.vaksin.delete');

	Route::post('/backend/employee/konseling', [KonselingController::class, 'index'])->name('backend.employee.konseling');
	Route::post('/backend/employee/konseling/store', [KonselingController::class, 'store'])->name('backend.employee.konseling.store');
	Route::post('/backend/employee/konseling/view', [KonselingController::class, 'view'])->name('backend.employee.konseling.view');
	Route::get('/backend/employee/konseling/delete/{id}', [KonselingController::class, 'delete'])->name('backend.employee.konseling.delete');

	Route::post('/backend/employee/surat_peringatan', [SuratPeringatanController::class, 'index'])->name('backend.employee.surat_peringatan');
	Route::post('/backend/employee/surat_peringatan/store', [SuratPeringatanController::class, 'store'])->name('backend.employee.surat_peringatan.store');
	Route::get('/backend/employee/surat_peringatan/view/{id}', [SuratPeringatanController::class, 'view'])->name('backend.employee.surat_peringatan.view');
	Route::get('/backend/employee/surat_peringatan/delete/{id}', [SuratPeringatanController::class, 'delete'])->name('backend.employee.surat_peringatan.delete');

	Route::post('/backend/employee/appraisal', [AppraisalController::class, 'index'])->name('backend.employee.appraisal');
	Route::post('/backend/employee/appraisal/store', [AppraisalController::class, 'store'])->name('backend.employee.appraisal.store');
	Route::get('/backend/employee/appraisal/view/{id}', [AppraisalController::class, 'view'])->name('backend.employee.appraisal.view');
	Route::get('/backend/employee/appraisal/delete/{id}', [AppraisalController::class, 'delete'])->name('backend.employee.appraisal.delete');

	Route::get('/backend/employee/kontrak_kerja', [KontrakKerjaController::class, 'index'])->name('backend.employee.kontrak_kerja');
	Route::post('/backend/employee/kontrak_kerja/create', [KontrakKerjaController::class, 'create'])->name('backend.employee.kontrak_kerja.create');
	Route::post('/backend/employee/kontrak_kerja/store', [KontrakKerjaController::class, 'store'])->name('backend.employee.kontrak_kerja.store');
	Route::get('/backend/employee/kontrak_kerja/delete/{id}', [KontrakKerjaController::class, 'delete'])->name('backend.employee.kontrak_kerja.delete');

	Route::get('/backend/employee/sloting', [SlotingController::class, 'index'])->name('backend.employee.sloting');
	Route::post('/backend/employee/sloting/create', [SlotingController::class, 'create'])->name('backend.employee.sloting.create');
	Route::post('/backend/employee/sloting/store', [SlotingController::class, 'store'])->name('backend.employee.sloting.store');
	Route::post('/backend/employee/sloting/search', [SlotingController::class, 'search'])->name('backend.employee.sloting.search');
	Route::post('/backend/employee/sloting/edit', [SlotingController::class, 'edit'])->name('backend.employee.sloting.edit');
	Route::put('/backend/employee/sloting/update/{id}', [SlotingController::class, 'update'])->name('backend.employee.sloting.update');
	Route::post('/backend/employee/sloting/delete', [SlotingController::class, 'delete'])->name('backend.employee.sloting.delete');
	Route::get('/backend/employee/sloting/generate_jabatan_id', [SlotingController::class, 'generate_jabatan_id']);
	Route::post('/backend/employee/sloting/employee_cabang', [SlotingController::class, 'employee_cabang'])->name('backend.employee.sloting.employee_cabang');

	Route::get('/backend/employee/training', [TrainingController::class, 'index'])->name('backend.employee.training');
	Route::post('/backend/employee/training/create', [TrainingController::class, 'create'])->name('backend.employee.training.create');
	Route::post('/backend/employee/training/store', [TrainingController::class, 'store'])->name('backend.employee.training.store');
	Route::post('/backend/employee/training/search', [TrainingController::class, 'search'])->name('backend.employee.training.search');
	Route::post('/backend/employee/training/search_training', [TrainingController::class, 'search_training'])->name('backend.employee.training.search_training');
	Route::post('/backend/employee/training/detail', [TrainingController::class, 'detail'])->name('backend.employee.training.detail');
	Route::put('/backend/employee/training/update/{id}', [TrainingController::class, 'update'])->name('backend.employee.training.update');

	Route::get('/backend/employee/mutasi', [MutasiController::class, 'index'])->name('backend.employee.mutasi');
	Route::post('/backend/employee/mutasi/create', [MutasiController::class, 'create'])->name('backend.employee.mutasi.create');
	Route::post('/backend/employee/mutasi/store', [MutasiController::class, 'store'])->name('backend.employee.mutasi.store');
	Route::post('/backend/employee/mutasi/employee_department', [MutasiController::class, 'employee_department'])->name('backend.employee.mutasi.employee_department');

	Route::get('/backend/employee/resign', [ResignController::class, 'index'])->name('backend.employee.resign');
	Route::post('/backend/employee/resign/create', [ResignController::class, 'create'])->name('backend.employee.resign.create');
	Route::post('/backend/employee/resign/update', [ResignController::class, 'update'])->name('backend.employee.resign.update');

	Route::get('/backend/cuti/libur', [LiburController::class, 'index'])->name('backend.cuti.libur');
	Route::post('/backend/cuti/libur/store', [LiburController::class, 'store'])->name('backend.cuti.libur.store');
	Route::get('/backend/cuti/libur/delete/{id}', [LiburController::class, 'delete'])->name('backend.cuti.libur.delete');

	Route::get('/backend/cuti/bersama', [BersamaController::class, 'index'])->name('backend.cuti.bersama');
	Route::post('/backend/cuti/bersama/store', [BersamaController::class, 'store'])->name('backend.cuti.bersama.store');
	Route::get('/backend/cuti/bersama/delete/{id}', [BersamaController::class, 'delete'])->name('backend.cuti.bersama.delete');

	Route::get('/backend/cuti/tahunan', [TahunanController::class, 'index'])->name('backend.cuti.tahunan');
	Route::post('/backend/cuti/tahunan/create', [TahunanController::class, 'create'])->name('backend.cuti.tahunan.create');
	Route::post('/backend/cuti/tahunan/store', [TahunanController::class, 'store'])->name('backend.cuti.tahunan.store');
	Route::get('/backend/cuti/tahunan/detail/{kd}', [TahunanController::class, 'detail'])->name('backend.cuti.tahunan.detail');
	Route::get('/backend/cuti/tahunan/delete/{id}', [TahunanController::class, 'delete'])->name('backend.cuti.tahunan.delete');
	Route::post('/backend/cuti/tahunan/periksa', [TahunanController::class, 'periksa'])->name('backend.cuti.tahunan.periksa');
	Route::post('/backend/cuti/tahunan/setuju', [TahunanController::class, 'setuju'])->name('backend.cuti.tahunan.setuju');
	Route::post('/backend/cuti/tahunan/ketahui', [TahunanController::class, 'ketahui'])->name('backend.cuti.tahunan.ketahui');
	Route::post('/backend/cuti/tahunan/reject', [TahunanController::class, 'reject'])->name('backend.cuti.tahunan.reject');

	Route::get('/backend/cuti/khusus', [KhususController::class, 'index'])->name('backend.cuti.khusus');
	Route::post('/backend/cuti/khusus/create', [KhususController::class, 'create'])->name('backend.cuti.khusus.create');
	Route::post('/backend/cuti/khusus/store', [KhususController::class, 'store'])->name('backend.cuti.khusus.store');
	Route::get('/backend/cuti/khusus/detail/{kd}', [KhususController::class, 'detail'])->name('backend.cuti.khusus.detail');
	Route::get('/backend/cuti/khusus/delete/{id}', [KhususController::class, 'delete'])->name('backend.cuti.khusus.delete');
	Route::post('/backend/cuti/khusus/periksa', [KhususController::class, 'periksa'])->name('backend.cuti.khusus.periksa');
	Route::post('/backend/cuti/khusus/setuju', [KhususController::class, 'setuju'])->name('backend.cuti.khusus.setuju');
	Route::post('/backend/cuti/khusus/ketahui', [KhususController::class, 'ketahui'])->name('backend.cuti.khusus.ketahui');
	Route::post('/backend/cuti/khusus/reject', [KhususController::class, 'reject'])->name('backend.cuti.khusus.reject');

	Route::get('/backend/absensi', [AbsensiController::class, 'index'])->name('backend.absensi');
	Route::post('/backend/absensi/generate', [AbsensiController::class, 'generate'])->name('backend.absensi.generate');
	Route::post('/backend/absensi/delete', [AbsensiController::class, 'delete'])->name('backend.absensi.delete');
	Route::post('/backend/absensi/delete_absensi', [AbsensiController::class, 'delete_absensi'])->name('backend.absensi.delete_absensi');

	Route::get('/backend/absensi/ijin', [IjinController::class, 'index'])->name('backend.absensi.ijin');
	Route::post('/backend/absensi/ijin_store', [IjinController::class, 'store'])->name('backend.absensi.ijin_store');
	Route::get('/backend/absensi/ijin_detail/{kd}', [IjinController::class, 'detail'])->name('backend.absensi.ijin_detail');
	Route::get('/backend/absensi/ijin_delete/{id}', [IjinController::class, 'delete'])->name('backend.absensi.ijin_delete');
	Route::post('/backend/absensi/ijin_periksa', [IjinController::class, 'periksa'])->name('backend.absensi.ijin_periksa');
	Route::post('/backend/absensi/ijin_setuju', [IjinController::class, 'setuju'])->name('backend.absensi.ijin_setuju');
	Route::post('/backend/absensi/ijin_ketahui', [IjinController::class, 'ketahui'])->name('backend.absensi.ijin_ketahui');
	Route::post('/backend/absensi/ijin_reject', [IjinController::class, 'reject'])->name('backend.absensi.ijin_reject');
	Route::get('/backend/absensi/ijin_delete/{id}', [IjinController::class, 'delete'])->name('backend.absensi.ijin_delete');

	Route::get('/backend/absensi/remarks', [RemarksController::class, 'index'])->name('backend.absensi.remarks');
	Route::post('/backend/absensi/remarks_store', [RemarksController::class, 'store'])->name('backend.absensi.remarks_store');
	Route::get('/backend/absensi/remarks_delete/{id}', [RemarksController::class, 'delete'])->name('backend.absensi.remarks_delete');

	Route::get('/backend/surat/tugas', [TugasController::class, 'index'])->name('backend.surat.tugas');
	Route::post('/backend/surat/tugas_store', [TugasController::class, 'store'])->name('backend.surat.tugas_store');
	Route::get('/backend/surat/tugas_detail/{kd}', [TugasController::class, 'detail'])->name('backend.surat.tugas_detail');
	Route::get('/backend/surat/tugas_delete/{id}', [TugasController::class, 'delete'])->name('backend.surat.tugas_delete');
	Route::post('/backend/surat/tugas_periksa', [TugasController::class, 'periksa'])->name('backend.surat.tugas_periksa');
	Route::post('/backend/surat/tugas_setuju', [TugasController::class, 'setuju'])->name('backend.surat.tugas_setuju');
	Route::post('/backend/surat/tugas_ketahui', [TugasController::class, 'ketahui'])->name('backend.surat.tugas_ketahui');
	Route::post('/backend/surat/tugas_reject', [TugasController::class, 'reject'])->name('backend.surat.tugas_reject');

	Route::get('/backend/surat/ijin', [SuratIjinController::class, 'index'])->name('backend.surat.ijin');
	Route::post('/backend/surat/ijin_store', [SuratIjinController::class, 'store'])->name('backend.surat.ijin_store');
	Route::get('/backend/surat/ijin_detail/{kd}', [SuratIjinController::class, 'detail'])->name('backend.surat.ijin_detail');
	Route::get('/backend/surat/ijin_delete/{id}', [SuratIjinController::class, 'delete'])->name('backend.surat.ijin_delete');
	Route::post('/backend/surat/ijin_periksa', [SuratIjinController::class, 'periksa'])->name('backend.surat.ijin_periksa');
	Route::post('/backend/surat/ijin_setuju', [SuratIjinController::class, 'setuju'])->name('backend.surat.ijin_setuju');
	Route::post('/backend/surat/ijin_ketahui', [SuratIjinController::class, 'ketahui'])->name('backend.surat.ijin_ketahui');
	Route::post('/backend/surat/ijin_reject', [SuratIjinController::class, 'reject'])->name('backend.surat.ijin_reject');

	// Report Absensi Karyawan
	Route::get('/backend/report/absensi', [ReportAbsensiController::class, 'index'])->name('backend.report.absensi');
	Route::post('/backend/report/absensi/generate', [ReportAbsensiController::class, 'generate'])->name('backend.report.absensi.generate');
	Route::post('/backend/report/absensi/search', [ReportAbsensiController::class, 'search'])->name('backend.report.absensi.search');

	// Report Absensi Karyawan - Resign
	Route::get('/backend/report/absensi/resign', [ReportAbsensiController::class, 'resign'])->name('backend.report.absensi.resign');
	Route::post('/backend/report/absensi/resign_generate', [ReportAbsensiController::class, 'resign_generate'])->name('backend.report.absensi.resign_generate');
	Route::post('/backend/report/absensi/resign_search', [ReportAbsensiController::class, 'resign_search'])->name('backend.report.absensi.resign_search');

	//Report Karyawan
	Route::get('/backend/report/karyawan', [ReportEmployeeController::class, 'karyawan'])->name('backend.report.karyawan');
	Route::post('/backend/report/karyawan_search', [ReportEmployeeController::class, 'karyawan_search'])->name('backend.report.karyawan_search');
	Route::get('/backend/report/kelengkapan', [ReportEmployeeController::class, 'kelengkapan'])->name('backend.report.kelengkapan');
	Route::post('/backend/report/kelengkapan_search', [ReportEmployeeController::class, 'kelengkapan_search'])->name('backend.report.kelengkapan_search');

	//Report Perjalanan Dinas
	Route::get('/backend/report/dinas', [ReportDinasController::class, 'index'])->name('backend.report.dinas');
	Route::post('/backend/report/dinas_search', [ReportDinasController::class, 'search'])->name('backend.report.dinas_search');

	Route::get('/backend/dinas', [DinasController::class, 'index'])->name('backend.dinas');
	Route::get('/backend/dinas/create', [DinasController::class, 'create'])->name('backend.dinas.create');
	Route::post('/backend/dinas/store', [DinasController::class, 'store'])->name('backend.dinas.store');
	Route::get('/backend/dinas/info', [DinasController::class, 'info'])->name('backend.dinas.info');
	Route::post('/backend/dinas/kendaraan', [DinasController::class, 'kendaraan'])->name('backend.dinas.kendaraan');
	Route::post('/backend/dinas/kendaraan_store', [DinasController::class, 'kendaraan_store'])->name('backend.dinas.kendaraan_store');
	Route::get('/backend/dinas/kendaraan_view', [DinasController::class, 'kendaraan_view'])->name('backend.dinas.kendaraan_view');
	Route::get('/backend/dinas/kendaraan_delete/{id}', [DinasController::class, 'kendaraan_delete'])->name('backend.dinas.kendaraan_delete');
	Route::post('/backend/dinas/lokasi_jarak', [DinasController::class, 'lokasi_jarak'])->name('backend.dinas.lokasi_jarak');
	Route::get('/backend/dinas/detail/{kd}', [DinasController::class, 'detail'])->name('backend.dinas.detail');
	Route::get('/backend/dinas/delete/{id}', [DinasController::class, 'delete'])->name('backend.dinas.delete');
	Route::post('/backend/dinas/periksa', [DinasController::class, 'periksa'])->name('backend.dinas.periksa');
	Route::post('/backend/dinas/setuju', [DinasController::class, 'setuju'])->name('backend.dinas.setuju');
	Route::post('/backend/dinas/ketahui', [DinasController::class, 'ketahui'])->name('backend.dinas.ketahui');
	Route::post('/backend/dinas/reject', [DinasController::class, 'reject'])->name('backend.dinas.reject');
	Route::post('/backend/dinas/detail_payment', [DinasController::class, 'detail_payment'])->name('backend.dinas.detail_payment');
	Route::post('/backend/dinas/update_payment', [DinasController::class, 'update_payment'])->name('backend.dinas.update_payment');
	Route::post('/backend/dinas/update_payment_store', [DinasController::class, 'update_payment_store'])->name('backend.dinas.update_payment_store');

	// Payroll Komponen Gaji
	Route::get('/backend/payroll/komponen_gaji', [KomponenGajiController::class, 'index'])->name('backend.payroll.komponen_gaji');
	Route::post('/backend/payroll/komponen_gaji/create', [KomponenGajiController::class, 'create'])->name('backend.payroll.komponen_gaji.create');
	Route::post('/backend/payroll/komponen_gaji/store', [KomponenGajiController::class, 'store'])->name('backend.payroll.komponen_gaji.store');
	Route::post('/backend/payroll/komponen_gaji/detail', [KomponenGajiController::class, 'detail'])->name('backend.payroll.komponen_gaji.detail');
	Route::post('/backend/payroll/komponen_gaji/import', [KomponenGajiController::class, 'import'])->name('backend.payroll.komponen_gaji.import');
	Route::post('/backend/payroll/komponen_gaji/import_store', [KomponenGajiController::class, 'import_store'])->name('backend.payroll.komponen_gaji.import_store');

	// Payroll Generate
	Route::get('/backend/payroll', [PayrollController::class, 'index'])->name('backend.payroll');
	Route::post('/backend/payroll/create', [PayrollController::class, 'create'])->name('backend.payroll.create');
	Route::post('/backend/payroll/store', [PayrollController::class, 'store'])->name('backend.payroll.store');
	Route::get('/backend/payroll/detail/{id}', [PayrollController::class, 'detail'])->name('backend.payroll.detail');
	Route::post('/backend/payroll/detail_view', [PayrollController::class, 'detail_view'])->name('backend.payroll.detail_view');
	Route::post('/backend/payroll/detail_update', [PayrollController::class, 'detail_update'])->name('backend.payroll.detail_update');
	Route::get('/backend/payroll/lock/{id}', [PayrollController::class, 'lock'])->name('backend.payroll.lock');
	Route::get('/backend/payroll/unlock/{id}', [PayrollController::class, 'unlock'])->name('backend.payroll.unlock');
	Route::get('/backend/payroll/delete/{id}', [PayrollController::class, 'delete'])->name('backend.payroll.delete');
	Route::get('/backend/payroll/export', [PayrollController::class, 'export'])->name('backend.payroll.export');

	// Payroll Generate Incentive
	Route::get('/backend/payroll/incentive', [IncentiveController::class, 'index'])->name('backend.payroll.incentive');
	Route::post('/backend/payroll/incentive/store', [IncentiveController::class, 'store'])->name('backend.payroll.incentive.store');
	Route::get('/backend/payroll/incentive/delete/{id}', [IncentiveController::class, 'delete'])->name('backend.payroll.incentive.delete');

	//Generate Chart Dashboard
	Route::get('/backend/graph/chart_kontrak', [GraphController::class, 'chart_kontrak'])->name('backend.graph.chart_kontrak');
	Route::get('/backend/graph/chart_karyawan_gender', [GraphController::class, 'chart_karyawan_gender'])->name('backend.graph.chart_karyawan_gender');
	Route::get('/backend/graph/chart_range_ages', [GraphController::class, 'chart_range_ages'])->name('backend.graph.chart_range_ages');
	Route::get('/backend/graph/chart_absensi', [GraphController::class, 'chart_absensi'])->name('backend.graph.chart_absensi');

	Route::get('/backend/master/dinas_lokasi', [DinasLokasiController::class, 'index'])->name('backend.master.dinas_lokasi');
	Route::post('/backend/master/dinas_lokasi/edit', [DinasLokasiController::class, 'edit'])->name('backend.master.dinas_lokasi.edit');
	Route::put('/backend/master/dinas_lokasi/update/{id}', [DinasLokasiController::class, 'update'])->name('backend.master.dinas_lokasi.update');
	Route::get('/backend/master/dinas_lokasi/delete/{id}', [DinasLokasiController::class, 'delete'])->name('backend.master.dinas_lokasi.delete');

	Route::get('/backend/master/lokasi', [LokasiController::class, 'index'])->name('backend.master.lokasi');
	Route::post('/backend/master/lokasi/store', [LokasiController::class, 'store'])->name('backend.master.lokasi.store');
	Route::post('/backend/master/lokasi/edit', [LokasiController::class, 'edit'])->name('backend.master.lokasi.edit');
	Route::put('/backend/master/lokasi/update/{id}', [LokasiController::class, 'update'])->name('backend.master.lokasi.update');
	Route::get('/backend/master/lokasi/delete/{id}', [LokasiController::class, 'delete'])->name('backend.master.lokasi.delete');

	Route::get('/backend/master/dinas_except', [DinasExceptBiayaController::class, 'index'])->name('backend.master.dinas_except');
	Route::post('/backend/master/dinas_except/store', [DinasExceptBiayaController::class, 'store'])->name('backend.master.dinas_except.store');
	Route::post('/backend/master/dinas_except/edit', [DinasExceptBiayaController::class, 'edit'])->name('backend.master.dinas_except.edit');
	Route::put('/backend/master/dinas_except/update/{id}', [DinasExceptBiayaController::class, 'update'])->name('backend.master.dinas_except.update');
	Route::get('/backend/master/dinas_except/delete/{id}', [DinasExceptBiayaController::class, 'delete'])->name('backend.master.dinas_except.delete');


});
