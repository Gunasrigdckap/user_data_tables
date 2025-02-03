<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Marks</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/header/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer/footer.css') }}">
</head>

<body>
    <header class="row">
        @include('includes.header')
    </header>
    <h1>Marks Form</h1>

     <!-- marks form -->
     <form id="marksForm" method="post">
        @csrf
        <input type="hidden" id="user_id" name="user_id">
        <div>
            <label for="name">Name:</label>
            <select id="select_name" name="student_id" style="width: 170px">
                @foreach ($students as $student){
                    <option value="{{ $student->id }}"> {{ $student->name }} </option>
                }

                @endforeach
            </select>
        </div><br>
        <div>
            <label for="subject">Subject:</label>
            <select id="select_subject" name="subject" style="width: 170px">
                <option value="tamil">Tamil</option>
                <option value="english">English</option>
                <option value="maths">Maths</option>
                <option value="science">Science</option>
                <option value="social">Social</option>
            </select>
        </div><br>
        <div>
            <label for="mark">Mark:</label>
            <input type="text" id="mark" name="mark" required>
        </div>
        <br>
        <button type="submit">Submit</button>
    </form>

   <footer>
    @include('includes.footer')
</footer>
<script>
     // form submission
     $(document).ready(function() {
     $('#marksForm').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: '/studentmark/store',
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        $('#marksForm')[0].reset();
                    },
                    error: function (error) {
                        alert('An error occurred');
                        $('#marksForm')[0].reset();
                    },
                });
            });
        });
</script>

</body>
</html>
