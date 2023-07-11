<!DOCTYPE html>
<html>
<head>
    <title>Tambah Auditor</title>
    <style>
        /* CSS untuk mengatur tampilan halaman tambah auditor */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 300px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary:focus {
            outline: none;
        }

        .btn-primary:active {
            background-color: #0056b3;
            transform: translateY(1px);
        }
    </style>
</head>
<body>
    <h1>Tambah Auditor</h1>
    <form method="POST" action="tambahAuditor">@csrf
        <div class="form-group">
            <label for="nama">Nama Auditor:</label>
            <input type="text" id="nama" name="nama" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email Auditor:</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="posisi">Posisi Auditor:</label>
            <input type="text" id="posisi" name="posisi" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</body>
</html>
