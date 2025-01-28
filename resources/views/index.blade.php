<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/header/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer/footer.css') }}">
</head>
<body>
    <header class="row">
        @include('includes.header')
    </header>
    <h1>User List Table</h1>

     <!-- user form -->
     <form id="userForm" method="post">
        @csrf
        <input type="hidden" id="user_id" name="user_id">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="age">Age:</label>
            <input type="text" id="age" name="age" required>
        </div>
        <div>
            <label for="dept">Department:</label>
            <input type="text" id="dept" name="dept" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="subjects">Subjects:</label>
            <input type="subjects" id="subjects" name="subjects" required>
        </div>
        <button type="submit">Submit</button>
    </form>

    <!-- data table -->
    <table id="usersTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Department</th>
                <th>Email</th>
                <th>Subjects</th>
            </tr>
        </thead>
    </table>


    <script>
        $(document).ready(function(){
            let userTable = $("#usersTable").DataTable({
                ajax: {
                    url: '/users',
                    method: 'GET',
                },
                pageLength: 3,
                lengthMenu: [3,5,10,15],
                columns: [
                    { data: 'id'  },
                    { data: 'name' },
                    { data: 'age'},
                    { data: 'dept'},
                    { data: 'email'},
                    { data: 'subjects'}
                ]
            });

        });

         // form submission
         $('#userForm').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: '/users/store',
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        $('#userForm')[0].reset();
                        // userTable.ajax.reload();
                    },
                    error: function (error) {
                        // alert('An error occurred');
                    },
                });
            });


    </script>
   <footer>
    @include('includes.footer')
</footer>


</body>
</html>
