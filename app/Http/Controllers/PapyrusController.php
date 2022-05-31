<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Controllers\Controller;
use App\Dosar;
use App\Utilizator;
use Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Kernel;

class PapyrusController extends Controller

{

    function show()
    {
        $dosar = Client::join('dosare', 'dosare.client_id', '=', 'clienti.id')
                             ('dosare', 'dosare.user_id', '=', 'utilizatori.id')
            ->get(['clienti.nume', 'dosare.problema_drept', 'dosare.data_inregistrare', 'dosare.status', 'dosare.informatii', 'utilizatori.Prenume']);

        return view('DetaliisiEditare', ['dosare' => $dosar]);
    }

    public function save(Request $request)

    {
        // selectez coloana id din tabela clienti pt conditia ca numele sa fie cel adaugat in campul din frontend
        $query1 = DB::select("SELECT id FROM clienti WHERE nume='$request->nume'limit 1");
        // returneaza fiecare cheie din array ca string, dar ramane array
        $array = array_map("json_encode", $query1);
        // separa fiecare element din array si ramane doar string
        $query2 = implode(' ', $array);
        //filtreaza si afiseaza int din string
        $query3 = (int)filter_var($query2, FILTER_SANITIZE_NUMBER_INT);
        $faker = Faker\Factory::create();
        $dosare = new Dosar();
        $dosare->problema_drept = $request->problema_drept;
        $dosare->status = $request->Status;
        $dosare->informatii = $request->info;
        $dosare->data_inregistrare = $faker->dateTimeThisMonth;
        $dosare->client_id = $query3;
        $query4 = DB::select("SELECT id FROM utilizatori WHERE Prenume='$request->Prenume' limit 1");
        $array2 = array_map("json_encode", $query4);
        $query5 = implode(' ', $array2);
        $query6 = (int)filter_var($query5, FILTER_SANITIZE_NUMBER_INT);
        $dosare->user_id = $query6;
        $dosare->save();
        return Redirect::to('http://localhost/PAPYRUS/PAPYRUS.files/index.php');
    }

//    public function show()
//    {
//        $join = DB::table('dosare')
//            ->join('clienti', 'dosare.client_id', '=', 'clienti.id')
//            ->join('utilizatori', 'dosare.user_id', '=', 'utilizatori.id')
//            ->orderBy('nume')
//            ->select('dosare.id', 'clienti.nume', 'dosare.problema_drept', 'dosare.data_inregistrare', 'dosare.status', 'dosare.informatii', 'utilizatori.Prenume')
//            ->get();
////        dd($join);
//        $array_list = json_decode(json_encode($join), true);
//
//        return view('DetaliisiEditare', ['dosare' => $array_list]);
//
//    }

    public function edit($id)
    {

        $join = Dosar::query()
            ->join('clienti', 'dosare.client_id', '=', 'clienti.id')
            ->join('utilizatori', 'dosare.user_id', '=', 'utilizatori.id')
            ->orderBy('nume')
            ->select('dosare.id', 'clienti.nume', 'dosare.problema_drept', 'dosare.data_inregistrare', 'dosare.status', 'dosare.informatii', 'utilizatori.Prenume')
            ->where('dosare.id', '=', $id)
            ->get();
//dd($join);
        $dosare = json_decode(json_encode($join), true);
//        dd($dosare);

        return view('Editare', ['dosare' => $dosare]);
    }

    public function update(Request $request)
    {

        $dosar = Dosar::find($request->id);
        $query1 = DB::select("SELECT id FROM clienti WHERE nume='$request->nume'limit 1");
        $array = array_map("json_encode", $query1);
        $query2 = implode(' ', $array);
        $query3 = (int)filter_var($query2, FILTER_SANITIZE_NUMBER_INT);
        $dosar->client_id = $query3;
        $dosar->problema_drept = $request->problema_drept;
        $dosar->data_inregistrare = $request->data_inregistrare;
        $dosar->status = $request->status;
        $dosar->informatii = $request->informatii;
        $query4 = DB::select("SELECT id FROM utilizatori WHERE Prenume='$request->Prenume' limit 1");
        $array2 = array_map("json_encode", $query4);
        $query5 = implode(' ', $array2);
        $query6 = (int)filter_var($query5, FILTER_SANITIZE_NUMBER_INT);
        $dosar->user_id = $query6;
        $dosar->save();
        return redirect('http://papyrus.test/DetaliiDosar');
    }

    public function delete($id)
    {

        $dosar = Dosar::find($id);
        $dosar->delete();
        return redirect('http://papyrus.test/DetaliiDosar');
    }
}


