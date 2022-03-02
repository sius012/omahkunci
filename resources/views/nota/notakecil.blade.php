@php
$no = 1;
$subtotal = 0;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">





    <title>Document</title>
    <style>

        @font-face {
            font-family: 'tes';
            src: url("{{storage_path('fonts/fontku.ttf') }}") format("truetype");
            font-weight: 400; // use the matching font-weight here ( 100, 200, 300, 400, etc).
            font-style: normal; // use the matching font-style here
        }
        * {
            font-family: monospace;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: -0.5px;
            font-stretch: 10%;
        }

        html {
            margin: 0;
            max-width: 80mm;
        }

        body {
            margin: 0px;


        }

        .cont {}

        h3 {}

        span {
            font-family: "Brush 455";
        }

        .mulia {
            font-size: 35pt;

        }

        .trans:before {
            content: ' ';
            display: block;
            position: absolute;
            left: 15%;
            top: 2%;
            width: 75%;
            height: 50%;
            opacity: 0.2;
            background-image: url("{{public_path('nota/mj.png')}}");
            background-repeat: no-repeat;
            background-position: 40% 50%;
            background-size: 25rem;
        }

        .heading {
            left: 20px;
            margin: 0px;
        }

        .cont {
            width: 21.5cm;
            top: 0px;
        }

        .trans {
            width: 85%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .trans td {
            border: 1px solid black;


        }

        .trans .null {
            padding: 10px;
        }

        .trans th {
            border: 1px solid black;

        }

        .row {
            padding: 0px;
        }

        h4 {
            margin: 3px;
            font-size: 9.5pt;
        }

        .foot {
            margin: 10px;
        }

        th {
            font-size: 8pt;
        }

        td {
            font-size: 5pt;
            padding: 0px;
            margin-top: -10px;
        }

        img {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            margin-top: 15px;
            margin-left: 10px;

            height: 25px;
        }

        .container {
            justify-content: center;
            margin-top: 0;
        }

        .row {
            left: 100px;
        }

    </style>
    <style>
        .logo-title {
            font-size: 20pt;
            font-weight: bold;

            margin: 0;
            margin-left: -45px;
        }

        table {
            font-size: 10pt;
            width: 63mm;
            align-items: center;
        }

        td,
        th {
            font-size: 10pt;
        }

        .centering {
            margin-top: -20px;
            margin-left: 60px;
        }

        h1 {
            margin: 80px;
            margin-bottom: 40px;
        }

        hr {
            border: dotted;

            margin:0;
        }

        .alamat {
            font-size: 8pt;
            margin-left: -30px;

            font-weight: lighter;

            text-align: center;
            width: 200px;
            margin-bottom:4px;
        }

        p {
            font-size: 9pt;
        }

    </style>
</head>
<body>

    <div class="container">

        <div class="row centering" style="margin-top:0.5px;">
            <img src="{{ public_path('assets/logo.svg') }}" alt="">
            <p class="alamat">Jl. Agus Salim D no.10 <br> Telp/Fax. (024) 3554929 / 085712423453 <br> Semarang <br></p>
        </div>


        <hr style="margin:0;">
        <div>
            <table>

                <tr>
                    <td>{{$data[0]->no_nota}}</td>
                    <td align="right">YTH. {{$data[0]->nama_pelanggan}}</td>

                </tr>
                <tr>
                    <td></td>
                    <td style="text-align:right;" class="ml-3">
                        {{$data[0]->telepon}}
                        <br>
                        {{$data[0]->alamat}}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td align=>{{date("d-m-Y" ,strtotime($data[0]->created_at))}}</td>
                    <td align="right">KSR. {{$data[0]->name}}</td>
                </tr>

            </table>
        </div>
        <hr sytle="margin:0;">
        <div class="row">
            <div class="col d-flex align-items-center justify-content-center">
                <table class="table">


                    <tbody>
                        @foreach($data2 as $dats)
                        <tr>

                            <td colspan="2">{{$dats->nama_produk}}</td>


                        </tr>

                        <tr>
                            <td style="width: 120px">{{number_format($dats->harga,"0",".",".")}}{{" x"}} {{$dats->jumlah}} </td>
                            <td align="right">- {{$dats->potongan * $dats->jumlah}}</td>
                            <td align="right">Rp.{{number_format(($dats->harga - $dats->potongan) * $dats->jumlah,"0",".","." )}}</td>
                            @php $no++; $subtotal+=$dats->jumlah * ($dats->harga - $dats->potongan); @endphp
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <table>

                    <tr>
                        <td>Subtotal</td>
                        <td align="right">Rp.{{number_format($subtotal,0,".",".")}}</td>

                    </tr>
                    <tr>
                        <td>Potongan</td>
                        <td align="right">Rp.{{number_format($data[0]->diskon, 0,".",".")}}</td>

                    </tr>
                    <tr>
                        <td></td>
                        <td align="right">Rp.{{number_format($subtotal - $data[0]->diskon, 0,".",".") }}</td>

                    </tr>

                    <tr>
                        <td>Dibayar</td>
                        <td align="right">Rp. {{number_format($data[0]->bayar,0,".",".") }}</td>

                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td align="right">Rp. {{number_format( $data[0]->bayar - ($subtotal - $data[0]->diskon),0,".",".") }}</td>

                    </tr>

                </table>
                <hr style="margin:0;">
                <p style="margin:3px;">* Barang yang sudah dibeli <br> tidak dapat ditukar<br><br>

                    Terimakasih</p>
            </div>
        </div>


</body>
</html>