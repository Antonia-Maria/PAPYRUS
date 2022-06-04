<?php

namespace App\Http\Controllers;

use App\Dosar;
use Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PapyrusController extends Controller

{
// functie pentru salvarea datelor noi in baza de date - adaugare dosar(cu inner join)
// nume dosar =  nume client deja existent in firma, nu va putea fi adaugat unul nou
// referent = Prenume utilizator, deja existent in firma, nu va putea fi adaugat unul nou
// se vor putea adauga doar informatii care nu sunt aduse din alte tabele;
// numele clientului si Prenumele referentului sunt selectate dintr-o lista, fiind predefinite(pentru ca sunt aduse din tabela "clienti", respectiv "utilizatori")

    public function save(Request $request)
    {
        // selectez din baza de date, din tabela "clienti", id-ul specific numelui clientului ales in lista(adus din coloana "nume")
        // va returna un array
        $query_nume = DB::select("SELECT id FROM clienti WHERE nume='$request->nume'limit 1");
        // va returna cheile din array ca string, dar ramane array
        $array_nume = array_map("json_encode", $query_nume);
        // separa fiecare element din array si ramane doar string, nu va mai fi array
        $implode_nume = implode(' ', $array_nume);
        //filtreaza si afiseaza integer-ul(id-ul) din string-ul rezultat, pentru a putea fi atribuit coloanei client_id din dosare si a sti ce nume cheama din tabela "clienti"
        $nume_filter = (int)filter_var($implode_nume, FILTER_SANITIZE_NUMBER_INT);
        $faker = Faker\Factory::create();
        $dosare = new Dosar();
        $dosare->problema_drept = $request->problema_drept;
        $dosare->status = $request->Status;
        $dosare->informatii = $request->info;
        $dosare->data_inregistrare = $faker->dateTimeThisMonth;
        $dosare->client_id = $nume_filter;
        // selectez din baza de date, din tabela "utilizatori", id-ul specific Prenumelui utilizatorului ales in lista(adus din coloana "Prenume")
        // va returna un array
        $query_Prenume = DB::select("SELECT id FROM utilizatori WHERE Prenume='$request->Prenume' limit 1");
        // va returna cheile din array ca string, dar ramane array
        $array_Prenume = array_map("json_encode", $query_Prenume);
        // separa fiecare element din array si ramane doar string, nu va mai fi array
        $implode_Prenume = implode(' ', $array_Prenume);
        //filtreaza si afiseaza integer-ul(id-ul) din string-ul rezultat, pentru a putea fi atribuit coloanei user_id din dosare si a sti ce Prenume cheama din tabela "utilizatori"
        $Prenume_filter = (int)filter_var($implode_Prenume, FILTER_SANITIZE_NUMBER_INT);
        $dosare->user_id = $Prenume_filter;
        // se salveaza toate datele aduse cu request din front-end pentru un nou dosar
        $dosare->save();
        // redirectionez catre index pentru a putea fi vizualizat noul dosar adaugat
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
        // selectez din baza de date, din tabela "clienti", id-ul specific numelui clientului ales in lista(adus din coloana "nume")
        // va returna un array
        $query_nume = DB::select("SELECT id FROM clienti WHERE nume='$request->nume'limit 1");
        // va returna cheile din array ca string, dar ramane array
        $array_nume = array_map("json_encode", $query_nume);
        // separa fiecare element din array si ramane doar string, nu va mai fi array
        $implode_nume = implode(' ', $array_nume);
        //filtreaza si afiseaza integer-ul(id-ul) din string-ul rezultat, pentru a putea fi atribuit coloanei client_id din dosare si a sti ce nume cheama din tabela "clienti"
        $nume_filter = (int)filter_var($implode_nume, FILTER_SANITIZE_NUMBER_INT);
        $dosar->client_id = $nume_filter;
        $dosar->problema_drept = $request->problema_drept;
        $dosar->data_inregistrare = $request->data_inregistrare;
        $dosar->status = $request->status;
        $dosar->informatii = $request->informatii;
        // selectez din baza de date, din tabela "utilizatori", id-ul specific Prenumelui utilizatorului ales in lista(adus din coloana "Prenume")
        // va returna un array
        $query_Prenume = DB::select("SELECT id FROM utilizatori WHERE Prenume='$request->Prenume' limit 1");
        // va returna cheile din array ca string, dar ramane array
        $array_Prenume = array_map("json_encode", $query_Prenume);
        // separa fiecare element din array si ramane doar string, nu va mai fi array
        $implode_Prenume = implode(' ', $array_Prenume);
        //filtreaza si afiseaza integer-ul(id-ul) din string-ul rezultat, pentru a putea fi atribuit coloanei user_id din dosare si a sti ce Prenume cheama din tabela "utilizatori"
        $Prenume_filter = (int)filter_var($implode_Prenume, FILTER_SANITIZE_NUMBER_INT);
        $dosar->user_id = $Prenume_filter;
        // se salveaza toate datele aduse cu request din front-end pentru dosarul modificat
        $dosar->save();
        // redirectionez catre blade-ul DetaliisiEditare pentru a putea fi vizualizat dosarul modificat
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


