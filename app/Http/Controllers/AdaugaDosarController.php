<?php

namespace App\Http\Controllers;
use App\AdaugaDosar2;
use App\Http\Controllers\Controller;
use App\AdaugaDosar;
use Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdaugaDosarController extends Controller

{

    public function save(Request $request)

    {
        // selectez coloana id din tabela clienti pt conditia ca numele sa fie cel adaugat in campul din frontend
        $query1 = DB::select("SELECT id FROM clienti WHERE nume='$request->nume'limit 1");
        // returneaza fiecare cheie din array ca string, dar ramane array
        $array = array_map("json_encode", $query1);
        // separa fiecare element din array si ramane doar string
        $query2= implode(' ', $array);
        //filtreaza si afiseaza int din string
        $query3 = (int) filter_var($query2, FILTER_SANITIZE_NUMBER_INT);
        $faker = Faker\Factory::create();
        $dosare = new AdaugaDosar();
        $dosare->problema_drept = $request->problema_drept;
        $dosare->status = $request->Status;
        $dosare->informatii = $request->info;
        $dosare->data_inregistrare = $faker->dateTimeThisMonth;
        $dosare->client_id = $query3;
        $query4 = DB::select("SELECT id FROM utilizatori WHERE Prenume='$request->Prenume' limit 1");
        $array2 = array_map("json_encode", $query4);
        $query5 = implode(' ', $array2);
        $query6 = (int) filter_var($query5, FILTER_SANITIZE_NUMBER_INT);
        $dosare->user_id = $query6;
        $dosare->save();
        return Redirect::to('http://localhost/papyrus/Project-Antonia/index.php');
    }


}

