<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\System\ConfigurationModel;

use App\Models\DMaster\ProgramStudiModel;

class LoginController extends Controller
{

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	// Login
	public function showLoginForm()
	{		
		return view('/auth/login');
	}
	/**
	 * ganti field email menjadi username
	*/
	public function username () {
		$login = request()->input('pilihanlogin');
		switch($login)
		{
			case 'email':
				return 'email';
			break;
			case 'nohp':
				return 'nomor_hp';
			break;
			default: 
				return 'username';
		}
	}
	/**
	 * fungsi ini dipanggil saat setelah berhasil login
	*/
	protected function authenticated ()
	{
		//load config
		$config = ConfigurationModel::getCache();
		
		//daftar program studi
		$daftar_prodi = ProgramStudiModel::select(\DB::raw('
			`ID`,
			NAMA
		'))
		->get()
		->pluck('NAMA','ID')
		->toArray();

		request()->session()->put('DAFTAR_PRODI', $daftar_prodi);
		request()->session()->put('DEFAULT_PRODI', $config['DEFAULT_PRODI']);

		//daftar tahun akademik		
		$bulan_saat_ini = date('n');
		$default_ta = $config['DEFAULT_TA'];		
		$default_tahun_pendaftaran = $config['DEFAULT_TAHUN_PENDAFTARAN'];		
		request()->session()->put('DEFAULT_TA', $default_ta);		
		request()->session()->put('DEFAULT_ANGKATAN', $config['DEFAULT_TAHUN_PENDAFTARAN']);
		request()->session()->put('DEFAULT_GELOMBANG', 'all');
		request()->session()->put('DEFAULT_KELAS', 'all');

		$daftar_ta = [];
		for ($i = $default_tahun_pendaftaran; $i >= 2003; $i--)
		{
			$daftar_ta[$i] = $i . '/' . ($i+1);
		}
		request()->session()->put('DAFTAR_TA', $daftar_ta);
		request()->session()->put('DAFTAR_ANGKATAN', $daftar_ta);

		$daftar_ta_limit = [];
		for ($i = $default_tahun_pendaftaran + 6; $i >= 2003; $i--)
		{
			$daftar_ta_limit[$i] = $i . '/' . ($i+1);
		}
		request()->session()->put('DAFTAR_TA_LIMIT', $daftar_ta_limit);
		//semester
		request()->session()->put('DEFAULT_SEMESTER', $config['DEFAULT_SEMESTER']);
		request()->session()->put('DEFAULT_SEMESTER_PENDAFTARAN', $config['DEFAULT_SEMESTER_PENDAFTARAN']);
	}	
}
