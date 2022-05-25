<?php
Use App\Http\Controllers\DosarController;
Use App\Dosar;


?>

<table>
    <tr>AlaBala</tr>
    @foreach ($vizualizare as $row)
    <td>{{$row->id}}</td>
    @endforeach
</table>
