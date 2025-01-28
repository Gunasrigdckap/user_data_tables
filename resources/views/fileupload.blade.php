
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="{{ asset('css/header/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer/footer.css') }}">
</head>
<style>
    button {
    height: 30px;
    width: 120px;
    border: none;
    cursor: pointer;
    background-color: lightpink;
    border-radius: 5px;
}

</style>
<body>
    <header class="row">
        @include('includes.header')
    </header>
    <h2>Upload CSV File</h2>
<form action="/import" method="POST" enctype="multipart/form-data">
    @csrf
    <h5>Import CSV : <input type="file" name="file" accept=".csv"></h5>
    <button type="submit">Import CSV</button>
</form>
<footer>
    @include('includes.footer')
</footer>
</body>
</html>
