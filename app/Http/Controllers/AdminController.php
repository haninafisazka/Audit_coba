<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Standart;
use App\Models\PeriodeAudit;
use App\Models\UnitAudit;

use Illuminate\Support\Facades\DB;
use app\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PeriodeAudit $periodeAudit)
    {

//        $standart = DB::table('standarts')
//            ->select(DB::raw('DATE_FORMAT(created_at,"%Y") as created_at, id, user_id, type, name'))
//            ->get();

        $periodeAudit = PeriodeAudit::all();

        return view('admin.dashboard', compact('periodeAudit'));
    }

    public function pageTambahPeriodeAudit()
    {
        return view('admin.tambahPeriodeAudit');
    }

    public function pageTambahUnitAudit()
    {
        return view('admin.tambahUnitAudit');
    }

    public function pageTambahAuditee()
    {
        return view('admin.tambahAuditee');
    }


    public function pageTambahAuditor()
    {
        return view('admin.tambahAuditor');
    }

    public function dashboardUnitAudit(UnitAudit $unitAudit)
    {
        $unitAudit = User::role(['admin'])->get();

        return view('admin.dashboardUnitAudit', compact('unitAudit'));
    }

    public function dashboardAuditee()
    {
        $userAuditee = User::role('auditee')->get();

        return view('admin.dashboardAuditee', compact('userAuditee'));
    }

    public function dashboardAuditor()
    {
        $userAuditor = User::role('auditor')->get();

        return view('admin.dashboardAuditor', compact('userAuditor'));
    }

    public function tambahPeriodeAudit(Request $request)
    {
        // $request->validate([
        //     'tanggal_awal_audit'   =>      'required',
        //     'tanggal_akhir_audit'  =>      'required',
        //     'no_sk'                =>      'required|string',
        //     'file_sk'              =>      'required',
        //     'ketua_spi'            =>      'required|string',
        //     'nip_ketua'            =>      'required|string',
        // ]);

        $max = PeriodeAudit::max('id');
        $id = $max +1;

        $periode = new PeriodeAudit;
        $periode->id    = $id;
        $periode->tanggal_awal_audit  = $request->input('tanggal_awal_audit');
        $periode->tanggal_akhir_audit = $request->input('tanggal_akhir_audit');
        $periode->no_sk_tugas_audit      = $request->input('no_sk_tugas_audit');
        $fileName = '';
        if ($request->hasFile('file_sk')){
            $file_sk       = $request->file('file_sk');
            $fileName   = "file"."-".Str::random(5).".".$file_sk->getClientOriginalExtension();
            $file_sk->move(public_path('/file/'),$fileName);
        }
        
        $periode->file_sk = ($request->hasFile('file_sk')) ? $fileName : $periode->file_sk;
        $periode->tanggal_sk          = $request->input('tanggal_sk');
        $periode->ketua_spi           = $request->input('ketua_spi');
        $periode->nip_ketua_spi       = $request->input('nip_ketua_spi');
        $periode->save();
        return redirect()->route('admin.dashboard');

    }

    public function tambahUnitAudit(Request $request)
    {
        $request->validate([
            'nama_unit'              =>      'required|string|max:30',
            'tanggal_audit'          =>      'required|string',
            'no_sk'                  =>      'required|string',
            'ketua_unit'             =>      'required|string',
            'nip_ketua_unit'         =>      'required|string',
        ]);

//        dd($request->all());

        $user = User::create([
            'nama_unit' => ucwords($request['nama_unit']),
            'tanggal_audit' => ucwords($request['tanggal_audit']),
            'no_sk' => ucwords($request['no_sk']),
            'ketua_unit' => ucwords($request['ketua_unit']),
            'nip_ketua_unit' => ucwords($request['nip_ketua_unit'])
        ]);

        $user->assignRole('admin');

        if(!is_null($user)) {
            return redirect()->route('admin.dashboardUnitAudit')->with("success", "Berhasil Tambah");
        }
        else {
            return back()->with("error", "Proses Gagal");
        }

    }

    public function tambahAuditee(Request $request)
    {
        $request->validate([
            'name'              =>      'required|string|max:30',
            'fakultas'          =>      'required|string',
            'prodi'             =>      'required|string',
            'email'             =>      'required|email|unique:users,email',
            'password'          =>      'required|alpha_num|min:6',
        ]);



//        dd($request->all());

        $user = User::create([
            'name' => ucwords($request['name']),
            'fakultas' => ucwords($request['fakultas']),
            'prodi' => ucwords($request['prodi']),
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        $user->assignRole('auditee');

        if(!is_null($user)) {
            return redirect()->route('admin.dashboardAuditee')->with("success", "Berhasil Tambah");
        }
        else {
            return back()->with("error", "Proses Gagal");
        }

    }

    public function tambahAuditor(Request $request)
    {
        $request->validate([
            'name'              =>      'required|string|max:30',
            'fakultas'          =>      'required|string',
            'prodi'             =>      'required|string',
            'email'             =>      'required|email|unique:users,email',
            'password'          =>      'required|alpha_num|min:6',
        ]);

//        dd($request->all());

        $user = User::create([
            'name' => ucwords($request['name']),
            'fakultas' => $request['fakultas'],
            'prodi' => $request['prodi'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        $user->assignRole('auditor');

        if(!is_null($user)) {
            return redirect()->route('admin.dashboardAuditor')->with("success", "Berhasil Tambah");
        }
        else {
            return back()->with("error", "Proses Gagal");
        }

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update( $id)
    {

        try {
            $user = User::where('id', '=', $id)->first();
            $user->password = \Hash::make('123456');
            $user->save();
            return back()->with('success','Berhasil reset password');
        } catch (\Illuminate\Database\QueryException $e) {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $periode = PeriodeAudit::findOrFail($id);
        $periode->delete();

        return redirect()->back()->with('success','Berhasil Menghapus data');
    }
}
