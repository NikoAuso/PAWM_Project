<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stagione {{$stagione}}</title>
    <style>
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
            font-family: Tahoma, sans-serif;
            font-size: 16px;
        }

        /* Zebra striping */
        tr:nth-of-type(odd) {
            background: #eee;
        }

        th {
            background: #337ef8;
            color: white;
            font-weight: bold;
        }

        td, th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
    </style>
</head>

<body>

<div style="width: 95%; margin: 0 auto;">
    <div style="width: 100%; float: left;">
        <h1>Tavoli stagione {{$stagione}}</h1>
    </div>
</div>

<table style="position: relative; top: 50px;">
    <thead>
    <tr>
        <th>Nome tavolo</th>
        <th>Persone</th>
        <th>Età media</th>
        <th>Dettagli</th>
        <th>Evento</th>
        <th>Data</th>
        <th>Fatto da</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tables as $table)
        @php($result = \Illuminate\Support\Facades\DB::table('events')->select('titolo', 'date')->where('id', $table->event_id)->first())
        @php($user = \Illuminate\Support\Facades\DB::table('users')->select('name', 'surname')->where('username', $table->fattoDa)->first())
        <tr>
            <td style="text-transform: uppercase;">{{ $table->nome }}</td>
            <td>{{ $table->persone }}</td>
            <td>{{ $table->etaMedia }}</td>
            <td>{{($table->dettagli == NULL || $table->dettagli == "/" || $table->dettagli == " ") ? "/" : $table->dettagli}}</td>
            <td>{{$result->titolo}}</td>
            <td data-sort='{{\Carbon\Carbon::parse($result->date)}}'>
                {{\Carbon\Carbon::parse($result->date)->format('d/m/Y')}}
            </td>
            <td>{{$user->name}} {{$user->surname}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>

</html>
