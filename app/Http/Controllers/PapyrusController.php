<?php

namespace App\Http\Controllers;

use App\Dosar;
use Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Client;
use App\Utilizator;

class PapyrusController extends Controller

{
// functie pentru salvarea datelor noi in baza de date - adaugare dosar(cu inner join)
// nume dosar =  nume client deja existent in firma, nu va putea fi adaugat unul nou
// referent = Prenume utilizator, deja existent in firma, nu va putea fi adaugat unul nou
// se vor putea adauga doar informatii care nu sunt aduse din alte tabele;
// numele clientului si Prenumele referentului sunt selectate dintr-o lista, fiind predefinite(pentru ca sunt aduse din tabela "clienti", respectiv "utilizatori")

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

// functie de afisare a coloanelor din tabelul "dosare" pentru detalii suplimentare
    public function show()
    {
        $show = Dosar::query()
            ->join('clienti', 'dosare.client_id', '=', 'clienti.id')
            ->join('utilizatori', 'dosare.user_id', '=', 'utilizatori.id')
            ->orderBy('nume')
            ->select('dosare.id', 'clienti.nume', 'dosare.problema_drept', 'dosare.data_inregistrare', 'dosare.status', 'dosare.informatii', 'utilizatori.Prenume')
            ->get();

        return view('DetaliisiEditare', ['dosare' => $show]);

    }
// functie de afisare a coloanelor necesare pentru editare
// se executa inner join si sunt aduse informatiile dorite din baza de date intr-un tabel setat in blade-ul "Editare"
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


// functie editare dosar - identifica si selecteaza dosarul dupa id, executa inner join si updateaza info dosarului cu info introduse sau alese in front-end
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

// functie stergere dosar dupa id - identifica si selecteaza dosar dupa id si sterge dosarul selectat
    public function delete($id)
    {

        $dosar = Dosar::find($id);
        $dosar->delete();
        return redirect('http://papyrus.test/DetaliiDosar');
    }
}


