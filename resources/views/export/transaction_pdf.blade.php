<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export</title>

    <style>
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }

        Zebra striping
        tr:nth-of-type(odd) {
            background: #eee;
        }

        th {
            color: rgb(0, 0, 0);
            font-weight: bold;
        }

        td,
        th {
            padding: 10px;
            border: 1px solid #000000;
            text-align: left;
            font-size: 18px;
        }
        .none{
            border: none
        }


    </style>

</head>

<body>

    <div>
        <div style="display: flex; justify-content: center;">
            <h1>Laporan {{ $tipe_transaksi }} User : {{ $nama_user }}</h1>
        </div>
        <div style="display: flex; justify-content: center;">
            <h2>Tanggal : {{ $tanggal_transaksi_start }} - {{ $tanggal_transaksi_end }}</h2>
        </div>

    </div>

    <table style="position: relative; top: 50px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Penginput</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td data-column="Date">
                        {{ date('F j, Y', strtotime($data->tanggal_transaksi)) }}
                    </td>
                    <td >{{ $data->keterangan }}</td>
                    <td >{{ $data->user->name }}</td>
                    <td >{{ $data->nominal }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="none"></td>
                <td class="none"></td>
                <td class="none"></td>
                <td class="none"></td>
                <td>{{ $total }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
