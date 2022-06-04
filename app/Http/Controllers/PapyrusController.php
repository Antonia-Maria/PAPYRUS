<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Controllers\Controller;
use App\Dosar;
use App\Utilizator;
use Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class PapyrusController extends Controller

{

    public function save(Request $request)

    {
        $nume_dosar = Client::query()
            ->SELECT('clienti.id')
            ->WHERE('nume', '=', $request->nume)
            ->LIMIT(1)
            ->get();
        $faker = Faker\Factory::create();
        $dosare = new Dosar();
        $dosare->problema_drept = $request->problema_drept;
        $dosare->status = $request->Status;
        $dosare->informatii = $request->info;
        $dosare->data_inregistrare = $faker->dateTimeThisMonth;
        $dosare->client_id = $nume_dosar[0]['id'];
        $referent_dosar = Utilizator::query()
            ->SELECT('utilizatori.id')
            ->WHERE('Prenume', '=', $request->Prenume)
            ->LIMIT(1)
            ->get();
        $dosare->user_id = $referent_dosar[0]['id'];
        $dosare->save();
        return Redirect::to('http://localhost/PAPYRUS/PAPYRUS.files/index.php');
    }

    public function show()
    {
        $join = Dosar::query()
            ->join('clienti', 'dosare.client_id', '=', 'clienti.id')
            ->join('utilizatori', 'dosare.user_id', '=', 'utilizatori.id')
            ->orderBy('nume')
            ->select('dosare.id', 'clienti.nume', 'dosare.problema_drept', 'dosare.data_inregistrare', 'dosare.status', 'dosare.informatii', 'utilizatori.Prenume')
            ->get();

        return view('DetaliisiEditare', ['dosare' => $join]);

    }

    public function edit($id)
    {

        $dosare = Dosar::query()
            ->join('clienti', 'dosare.client_id', '=', 'clienti.id')
            ->join('utilizatori', 'dosare.user_id', '=', 'utilizatori.id')
            ->orderBy('nume')
            ->select('dosare.id', 'clienti.nume', 'dosare.problema_drept', 'dosare.data_inregistrare', 'dosare.status', 'dosare.informatii', 'utilizatori.Prenume')
            ->where('dosare.id', '=', $id)
            ->get();

        return view('Editare', ['dosare' => $dosare]);
    }

    public function update(Request $request)
    {

        $dosar = Dosar::find($request->id);
        $nume_dosar = Client::query()
            ->SELECT('clienti.id')
            ->WHERE('nume', '=', $request->nume)
            ->LIMIT(1)
            ->get();
        $dosar->client_id = $nume_dosar[0]['id'];
        $dosar->problema_drept = $request->problema_drept;
        $dosar->data_inregistrare = $request->data_inregistrare;
        $dosar->status = $request->status;
        $dosar->informatii = $request->informatii;
        $referent_dosar = Utilizator::query()
            ->SELECT('utilizatori.id')
            ->WHERE('Prenume', '=', $request->Prenume)
            ->LIMIT(1)
            ->get();
        $dosar->user_id = $referent_dosar[0]['id'];
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


