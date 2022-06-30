<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\DMaster\ProgramStudiModel;
use App\Models\SPMB\CalonMahasiswaModel;
use App\Models\SPMB\JadwalPendaftaranPMBModel;
use App\Models\Keuangan\TransaksiModel;
use App\Models\Keuangan\TransaksiDetailModel;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use App\Mail\NotifikasiRegistrasiPMB;

class RegisterController extends Controller
{
  use RegistersUsers;

  /**
   * Where to redirect users after registration.
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
    $this->middleware('guest');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'register-prodi' => ['required', 'exists:prodi,ID'],
      'register-tahun' => ['required'],
      'register-gelombang' => ['required'],
      'register-biaya' => ['required'],
      'register-kelas' => ['required', 'in:0,1,2,3'],
      'register-name' => ['required', 'string', 'max:255'],
      'register-hp' => ['required', 'unique:users,nomor_hp'],      
      'register-hp2' => ['required', 'unique:users,nomor_hp2'],      
      'register-password' => ['required', 'string', 'min:8'],
      'register-email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
      'g-recaptcha-response' => 'recaptcha',      
    ]);
  }
  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Models\User
   */
  protected function create(array $data)
  {
    $user =  \DB::transaction(function () use ($data) {   
      $prodi = ProgramStudiModel::find($data['register-prodi']);        
      
      $tahun = $data['register-tahun'];
      $gelombang = $data['register-gelombang'];
            
      $created_at = date('wdm');       
			$no_urut = mt_rand(0,9999);
			$no_str_pad = str_pad($no_urut + 1, 4, "0", STR_PAD_LEFT);      
			$id = $tahun.$gelombang.$created_at.$no_str_pad;   

      $user = User::create([
        'username' => $id,
        'password' => \Hash::make($data['register-password']),
        'name' => strtoupper($data['register-name']),
        'email' => $data['register-email'],
        'nomor_hp'=>$data['register-hp'],
        'nomor_hp2'=>$data['register-hp2'],
        'theme' => 'default',
        'default_role'=>'mahasiswabaru',
        'about'=>'Mahasiswa Baru',        
      ]);

      $user->assignRole('mahasiswabaru');
      $permission=Role::findByName('mahasiswabaru')->permissions;
      $user->givePermissionTo($permission->pluck('name'));

      if (!is_null($user))
      { 
        $no_transaksi = \HelperKeuangan::createNoTransaksi();
        $transaksi=TransaksiModel::create([
          'id'=>uniqid('uid'),
          'user_id'=>$user->id,
          'no_transaksi'=>$no_transaksi,
          'no_faktur'=>'',
          'kjur'=>$prodi->ID,
          'ta'=>$tahun,
          'idsmt'=>1,
          'idkelas'=>$data['register-kelas'],
          'no_formulir'=>$id,
          'nim'=>null,
          'commited'=>0,
          'total'=>0,
          'tanggal'=>date('Y-m-d'),
          'akhirbayar'=>date('Y-m-d'),
          'user_id_create'=>$user->id,
          'pid'=>10,
        ]);  
        $transaksi_detail=TransaksiDetailModel::create([
          'id'=>uniqid('uid'),
          'user_id'=>$user->id,
          'transaksi_id'=>$transaksi->id,
          'no_transaksi'=>$transaksi->no_transaksi,
          'kombi_id'=>10,
          'nama_kombi'=>'BIAYA FORMULIR + PENDAFTARAN',
          'biaya'=>\Helper::toInteger($data['register-biaya']),
          'jumlah'=>1,
          'tahun'=>$tahun,
          'gelombang'=>$gelombang,
          'sub_total'=>\Helper::toInteger($data['register-biaya'])    
        ]);
        $transaksi->total=\Helper::toInteger($data['register-biaya']);
        $transaksi->desc='BIAYA FORMULIR + PENDAFTARAN';
        $transaksi->save();

        CalonMahasiswaModel::create([
          'ID'=>$id,
          'NAMA'=>strtoupper($data['register-name']),
          'TAHUN'=>$tahun,
          'GELOMBANG'=>$gelombang,
          'PILIHAN'=>'',
          'KUITANSI'=>'',
          'TEMPATLAHIR'=>'',
          'TANGGALLAHIR'=>\Helper::tanggal('Y-m-d H:i:s'),
          'KELAMIN'=>'',
          'STATUSNIKAH'=>'',
          'AGAMA'=>0,
          'ALAMAT'=>'',
          'TELEPON'=>'',
          'HP'=>$data['register-hp'],
          'WN'=>'',
          'ASALSMA'=>'',
          'NOIJAZAH'=>'',
          'TANGGALIJAZAH'=>\Helper::tanggal('Y-m-d H:i:s'),
          'NILAIUN'=>0,
          'NILAIUNS'=>0,
          'NAMAAYAH'=>'',
          'NAMAIBU'=>'',
          'PEKERJAANORTU'=>'',
          'PEKERJAANIBU'=>'',
          'ALAMATORTU'=>'',
          'PRODI1'=>$prodi->ID,
          'PRODI2'=>'',
          'STATUSPRODI1'=>'',
          'STATUSPRODI2'=>'',
          'STATUSPRODI2'=>'',
          'BIAYA'=>\Helper::toInteger($data['register-biaya']),
          'NOTES'=>'',
          'UPDATER'=>'',
          'TANGGALUPDATE'=>\Helper::tanggal('Y-m-d H:i:s'),
          'NILAI'=>0,
          'LULUS'=>'',
          'NIM'=>'',
          'EMAIL'=>$data['register-email'],
          'PASSWORD'=>'ff45d4eaea6a7141a3fc1de2fddc4eae8d892c00f806ece95fc0b358ad8438d8',        
          'TANGGALDAFTAR'=>\Helper::tanggal('Y-m-d H:i:s'),
          'PASSWORD2'=>'',
          'UPDATERBANK'=>'',
          'TANGGALUPDATEBANK'=>\Helper::tanggal('Y-m-d H:i:s'),
          'STATUS'=>0,
          'SETTINGTAMPILAN'=>'',
          'STATUSLOGIN'=>0,
          'LASTLOGIN'=>\Helper::tanggal('Y-m-d H:i:s'),
          'LASTAKSI'=>\Helper::tanggal('Y-m-d H:i:s'),
          'TOKEN'=>'',
          'UPDATERPMB'=>'',
          'TANGGALUPDATEPMB'=>NULL,
          'TAHUNLULUSSMA'=>'0000',
          'PENDIDIKAN'=>'',
          'ALAMATIBU'=>'',
          'TELEPONAYAH'=>'',
          'TELEPONIBU'=>'',
          'STATUSISIBIODATA'=>0,
          'STATUSPILIHPRODI'=>0,
          'KOTA'=>'',
          'PROVINSI'=>'',
          'COUNTERPASSWORD'=>0,
          'STATUSMULAIUJIAN'=>0,
          'STATUSSELESAIUJIAN'=>0,
          'WAKTUMULAIUJIAN'=>NULL,
          'WAKTUSELESAIUJIAN'=>NULL,
          'FLAGPASSWORD'=>4,
          'SALT'=>'ZX9W2I2Gngro3JGunU8xGaxuRfp3E07e',
          'INSTANSI'=>'',
          'GOLONGAN'=>'',
          'JABATAN'=>'',
          'KLASIFIKASI'=>'',
          'STATUSBELAJAR'=>'',
          'CARABAYAR'=>'',
          'KETERANGANPEMBAYARAN'=>'',
          'PRODI3'=>'',
          'STATUSPRODI3'=>'',
          'STATUSPRODI3'=>'',
          'STPIDMSMHS'=>'B', 
          'JALURMASUK'=>'02',       
          'NIMSEMENTARA'=>'',       
          'GRADE'=>'',       
          'UNIT'=>'',       
          'JENISKELAS'=>$data['register-kelas'],       
          'AKTIVASI'=>0,       
          'STATUSAKTIVASI'=>0,       
          'REGISTRASI'=>1,       
          'TANGGALAKTIVASI'=>NULL,       
          'NIK'=>'',       
          'UKPS'=>0,       
          'NOKPS'=>'',       
          'DUSUN'=>'',       
          'RT'=>'',       
          'RW'=>'',       
          'KELURAHAN'=>'',       
          'KODEPOS'=>'',       
          'IDKECAMATAN'=>'',       
          'IDJENISTINGGAL'=>0,       
          'GOLDARAH'=>'',       
          'ALAMATASALSEKOLAH'=>'',       
          'TGLLAHIRAYAH'=>NULL,                                     
          'IDPENDIDIKANAYAH'=>0,       
          'IDPEKERJAANAYAH'=>0,       
          'PENGHASILANAYAH'=>0,                   
          'TGLLAHIRIBU'=>NULL,       
          'IDPENDIDIKANIBU'=>0,       
          'IDPEKERJAANIBU'=>0,       
          'PENGHASILANIBU'=>0,       
          'TINGKAT'=>$prodi->TINGKAT,
          'IDNEGARA'=>'',                
          'JENISUJIAN'=>0,                
          'IDPAKETSOAL'=>'',                
          'REFERENSI'=>'',                
          'BANKID'=>'',                
          'TERMINALID'=>'',                
          'TRANSAKSIDATETIME'=>'',                
          'IDSMA'=>'',                
          'INVOICE'=>'',               
          'TANGGALREGISTRASI'=>\Helper::tanggal('Y-m-d H:i:s'), 
          'NISN'=>'', 
          'STATUSISIRAPOR'=>0, 
          'STATUSUPLOADDOKUMEN'=>0, 
          'FILELEMBARPENGESAHAN'=>'', 
          'FILENILAIRAPOR'=>'', 
          'RATANILAIRAPOR'=>0, 
          'RATANILAIMAPEL'=>0, 
          'JURUSANSMA'=>'', 
          'SUMBER'=>'', 
          'SUMBERLAIN'=>'', 
          'STATUSVALIDASIBERKAS'=>0, 
          'STATUSKELULUSANRAPOR'=>0, 
          'STATUSKELULUSANADM'=>0, 
          'NOMINATOR'=>'', 
          'PERINGKAT'=>0, 
          'STATUSKELULUSANSEHAT'=>0, 
          'STATUSKELULUSANPSIKOTES'=>0, 
          'STATUSKELULUSANKESEHATAN'=>0, 
          'NOMINATORKESEHATAN'=>'', 
          'TANGGALUPDATEKESEHATAN'=>NULL, 
          'STATUSKELULUSANAKHIR'=>0, 
          'NOMINATORAKHIR'=>'', 
          'TANGGALUPDATEAKHIR'=>NULL, 
          'JENISPRESTASI'=>'', 
          'UJIANONLINE'=>0,         
        ]);    
      }    
      return $user;
    });
    //send email to queue
    Mail::to($user->email)->queue(new NotifikasiRegistrasiPMB($user));

    return $user;
  }
  // Register
  public function showRegistrationForm()
  {
    $jadwal = JadwalPendaftaranPMBModel::select(\DB::raw('
      TAHUN,
      GELOMBANG,
      TANGGALMULAI,
      TANGGALSELESAI,
      BIAYA
    '))
    ->whereRaw('CURDATE() between TANGGALMULAI and TANGGALSELESAI')
    ->orderBy('LASTUPDATE', 'DESC')    
    ->orderBy('GELOMBANG', 'DESC')    
    ->first();    
    
    //daftar program studi
		$list_prodi = ProgramStudiModel::select(\DB::raw('
      `ID`,
      NAMA
    '))
    ->get()
    ->pluck('NAMA','ID')
    ->toArray();

    $daftar_prodi = array('' => 'PILIH PROGRAM STUDI') + $list_prodi;
    
    $buka_registrasi = false;
    return view('/auth/register', [
      'daftar_prodi'=>$daftar_prodi,      
      'jadwal'=>$jadwal,
      'buka_registrasi' => $buka_registrasi,
    ]);
  }
}
