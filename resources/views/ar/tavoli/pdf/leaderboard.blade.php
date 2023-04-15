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
            font-family: "Metropolis", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji", sans-serif;
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
        <h1>Classifica tavoli stagione {{$stagione}}</h1>
    </div>
</div>

<table style="position: relative; top: 50px;">
    <thead>
    <tr>
        <th>Pos.</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Username</th>
        <th>Numero tavoli</th>
    </tr>
    </thead>
    <tbody>
    @php ($c = 1)
    @foreach($tables as $data)
        @if($data->fattoDa == "ACCOUNT ONELOVE")
            @php($data = null)
        @endif
        @php($user = \Illuminate\Support\Facades\DB::table('users')->where('username', $data->fattoDa)->first())
        <tr>
            <td>{{$c++}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->surname}}</td>
            <td>{{$user->username}}</td>
            <td>{{$data->count}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>

</html>
