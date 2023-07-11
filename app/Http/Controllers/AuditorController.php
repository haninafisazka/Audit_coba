<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DataPendahuluan;
use App\Models\Grade;
use App\Models\GradeStoring;
use App\Models\Question;
use App\Models\Response;
use App\Models\Standart;
use App\Models\User;
use App\Models\StandarRuangLingkup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use mysql_xdevapi\Table;
use Spatie\Permission\Models\Role;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Auth\Access;

class AuditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StandarRuangLingkup $standarRuangLingkup)
    {
        $standarRuangLingkup = StandarRuangLingkup::all();

        return view('auditor.dashboard', compact('standarRuangLingkup'));


//         $data = DataPendahuluan::with('user')
//             ->with('datapendahuluanGrade', function($q){
//                 $q->whereYear('created_at', '=', '2021');
//             })
//             ->get();

// //        $data = User::with('grades','dataPendahuluans')
// //            ->whereHas('roles', function($q){$q->where('name', 'Auditee');
// //        }
// //        )->get();

// //        dd($data);

//         $check = Question::whereYear('created_at','=', Carbon::now()->format('Y'))
//             ->count();

        // return view('auditor.dashboard', compact('data','check'));
    }

    public function uploadPdf($userId, $year)
    {

        $nameslug = User::where('id','=',$userId)->select('prodi')->pluck('prodi');
        $name = \Str::of($nameslug)->slug('-');

        $data = User::with('grades','dataPendahuluans', 'gradeStorings')
            ->with('dataPendahuluans', function ($query) use ($year) {
                return $query->whereYear('created_at', '=', $year);
            })
            ->where('id','=',$userId)
            ->get();


        $dataAuditor = User::with('grades','dataPendahuluans')
            ->with('gradeStorings', function ($query) use ($year) {
        return $query->where('type', '=', 'Auditor')
                     ->whereYear('created_at', '=', $year)
                     ->with('standart','UserViewAuditor');
            })
            ->where('id','=',$userId)->get();

        $auditAuditor = \DB::table('grades')
            ->join('users', 'grades.auditor_id', '=' , 'users.id')
            ->where('grades.user_id', '=', $userId)
            ->select('users.name','grades.description')
            ->groupBy('auditor_id')
            ->get();

        $auditorName = $auditAuditor->pluck('name')->join(', ');

//        dd($auditorName);

//        dd($auditAuditor);

//        dd($dataAuditor);
        $tableAuditee = \DB::table('grade_storings')
            ->join('standarts', 'grade_storings.standart_id', '=', 'standarts.id')
            ->where('auditee_id','=',$userId)
            ->where('grade_storings.type', '=', 'Auditee')
            ->whereYear('grade_storings.created_at','=', $year)
            ->select('grade_storings.grade','standarts.name')
            ->get();

//        dd($tableAuditee);

        $tableAuditor = \DB::table('grade_storings')
            ->join('standarts', 'grade_storings.standart_id', '=', 'standarts.id')
            ->where('auditee_id','=',$userId)
            ->where('grade_storings.type', '=', 'Auditor')
            ->whereYear('grade_storings.created_at','=', $year)
            ->select('grade_storings.grade','standarts.name')
            ->get();


        $countauditee = \DB::table('grade_storings')
            ->join('standarts', 'grade_storings.standart_id', '=', 'standarts.id')
            ->where('auditee_id','=',$userId)
            ->where('grade_storings.type', '=', 'Auditee')
            ->whereYear('grade_storings.created_at','=', $year)
            ->select('grade_storings.grade','standarts.name')
            ->avg('grade');

//        dd($countauditee);

        $avgauditee = round($countauditee);

        $countauditor = \DB::table('grade_storings')
            ->join('standarts', 'grade_storings.standart_id', '=', 'standarts.id')
            ->where('auditee_id','=',$userId)
            ->where('grade_storings.type', '=', 'Auditor')
            ->whereYear('grade_storings.created_at','=', $year)
            ->select('grade_storings.grade','standarts.name')
            ->avg('grade');

//        dd($dataAuditor);

        $avgauditor = round($countauditor);

        $pdf = PDF::loadView('auditor.pdfAuditor', compact('data','dataAuditor', 'tableAuditee','avgauditor', 'avgauditee', 'tableAuditor', 'year', 'auditAuditor', 'auditorName'));
        return $pdf->download('Penjaminan-Mutu-Internal-' .$name = \Str::of($nameslug)->slug('-'). '.pdf');

//        return view('auditor.pdfAuditor', compact('data','dataAuditor', 'tableAuditee','avgauditor', 'avgauditee', 'tableAuditor', 'year', 'auditAuditor', 'auditorName'));
    }
    
    public function tindakan()
    {
        return view('auditor.tindakan.tindakan');
    }

    public function standar()
    {
        return view('auditor.standar.standar');
    }

    public function profile()
    {
        return view('auditor.profile.profile');
    }

    public function setup()
    {
        return view('auditor.setup.setup');
    }

    public function auditing($standartId, $userId)
    {
        $respon = Response::where('standart_id', '=', $standartId)
            ->where('user_id','=',$userId)
            ->get();

        $userId = User::where('id', '=', $userId)->get();

//        dd($respon);

//        dd($userId);

        $standarts = Standart::with('questions')
            ->where('id', '=', $standartId)->get();

        $likert = ["1","2","3","4"];

        $yatidak = ["Ya","Tidak"];

        return view('auditor.response.auditing', compact('standarts','likert','yatidak','userId','respon'));
    }

    public function auditorResponse($id, $year)
    {
        $user = User::where('id', '=', $id)->get();
        $respon = Response::where('user_id', '=', $id)->whereYear('created_at','=', $year)->get();
        $data = DataPendahuluan::where('user_id', '=', $id)->whereYear('created_at','=', $year)->get();

        $standart = Standart::with(['grades' => function($q) use($id,$year) {
            // Query the name field in status table
            $q->where('user_id', '=', $id)->whereYear('created_at','=', $year); // '=' is optional
        }])
            ->get();
//        dd($standart);

        return view('auditor.response.response', compact('respon','user', 'data', 'standart'));
    }


    public function viewData($standart, $user, $year)
    {
        $uid = \Auth::id();

        $gradeAuditee = GradeStoring::where('standart_id', '=', $standart)
            ->where('type', '=', 'Auditee')
            ->where('auditee_id', '=', $user)
            ->whereYear('created_at','=', $year)
            ->pluck('grade');

        $gradeAuditor = GradeStoring::where('standart_id', '=', $standart)
            ->where('type', '=', 'Auditor')
            ->where('auditee_id', '=', $user)
            ->whereYear('created_at','=', $year)
            ->pluck('grade');

        $dataAuditee = Response::where('standart_id', '=', $standart )
            ->where('user_id', '=', $user)
            ->whereYear('created_at','=', $year)
            ->get();

        $dataAuditor = Grade::where('standart_id', '=', $standart )
            ->where('user_id', '=', $user)
            ->whereYear('created_at','=', $year)
            ->get();

        $auditAuditor = \DB::table('grades')
            ->join('users', 'grades.auditor_id', '=' , 'users.id')
            ->where('grades.standart_id', '=', $standart )
            ->whereYear('grades.created_at','=', $year)
            ->where('grades.user_id', '=', $user)
            ->select('users.name','grades.description')
            ->groupBy('grades.auditor_id')
            ->get();

        $standartsAuditee = Standart::where('id', '=', $standart)->get();
        $standartsAuditor = Standart::where('id', '=', $standart)->get();


        return view('auditor.response.view', compact('auditAuditor','gradeAuditee','gradeAuditor','dataAuditee','dataAuditor','standartsAuditee','standartsAuditor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $userId)
    {
        $data = request()->validate([
            'standart_id' => 'required',
            'question.*.question' => 'required',
            'question.*.question_id' => 'required|string',
            'user_id' => 'required',
            'typegrade' => 'required',
            'question.*.answer' => 'required',
            'description' => 'required',
        ]);

        $result=collect($request->question)->map(function ($item)use($request) {
            $item['user_id'] = $request->user_id;
            $item['auditor_id'] = $request->auditor_id;
            $item['standart_id'] = $request->standart_id;
            $item['description'] = $request->description;
            return $item;
        });

        $response=Grade::insert($result->toArray());

        //grade
        $standart = $request->standart_id;

        $standarts2 = Standart::where('id', '=', $request->standart_id)->get();

        foreach ($standarts2 as $sha){
            if ($sha->type == 'Likert'){

                $ca = Question::where('standart_id', '=', $standart)->count();
                $na = array_sum($request->input('question.*.answer'));

                $ma = 4 * $ca;
                $totals2 = (int) round(($na / $ma) * 100);
            }
            else{
                $ca = Question::where('standart_id', '=', $standart)->count();
                $ta = Grade::where('standart_id', '=', $standart)->where('answer', '=', 'Ya')
                    ->where('created_at','=', Carbon::now())
                    ->where('user_id', '=', $request->user_id)
                    ->count();

                $totals2 = (int) round(($ta / $ca) * 100);

            }
        }

        $grade = new GradeStoring();
        $grade->auditor_id = $request->auditor_id;
        $grade->auditee_id = $request->user_id;
        $grade->standart_id = $request->standart_id;
        $grade->grade = $totals2;
        $grade->type = $request->typegrade;

        $grade->save();

        $year = Carbon::now()->format('Y');
        if(!is_null($response || $grade)) {
            return redirect()->route('auditor.response', ['user' => $request->user_id , 'year' => $year] )->with('success', 'Berhasil tambah data');
        }
        else {
            return back()->with("error", "Proses Gagal");
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //        dd($request->all());
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
        ]);

        $data['updated_at'] = Carbon::now() ;
        $data['prodi'] = ucwords($data['prodi']) ;

//        dd($data);

        $update = \DB::table('users')
            ->where('id', '=',$id)
            ->update($data);

//        dd($update);

        if(!is_null($update)) {
            return redirect()->route('auditor.profile')->with('success', 'Berhasil tambah data');
        }
        else {
            return back()->with("error", "Proses Gagal");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function standart()
    {
        return view('auditor.standar.standar');
    }

    public function tambahStandarRuangLingkup(Request $request)
    {
        // $request->validate([
        //     'tanggal_awal_audit'   =>      'required',
        //     'tanggal_akhir_audit'  =>      'required',
        //     'no_sk'                =>      'required|string',
        //     'file_sk'              =>      'required',
        //     'ketua_spi'            =>      'required|string',
        //     'nip_ketua'            =>      'required|string',
        // ]);

        $max = StandarRuangLingkup::max('id');
        $id = $max +1;

        $periode = new StandarRuangLingkup;
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
        return redirect()->back();

    }

    public function pageTambahStandarRuangLingkup()
    {
        return view('auditor.tambahStandarRuangLingkup');
    }
}
