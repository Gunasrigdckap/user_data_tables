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
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
    <link rel="stylesheet" href="{{ asset('css/footer/footer.css') }}">
</head>
<style>
    /* .dataTables_filter {
display: none;
} */
</style>
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
    <div class="filtering">
        <div class="search-box"><label for="search">Search: </label><input type="text" placeholder="search"></div>
        <div class="sorting"><label for="sort">Sort by:</label>
            <select id="sortdrop">
                <option value="id">ID</option>
                <option value="name">Name</option>
                <option value="age">Age</option>
                <option value="dept">Department</option>
                <option value="email">Email</option>
                <option value="subjects">Subjects</option>
            </select>
            <select id="sortby">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
    </div>

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

    <div id="sideOverlay" class="side-overlay">
        <span class="close-btn">&times;</span>
        <h2>User Subjects & Marks</h2>
        <div id="overlayContent">
           {{-- data --}}
        </div>
    </div>
    <script>
        $(document).ready(function(){
            let userTable = $("#usersTable").DataTable({
                ajax: {
                    url: '/users',
                    method: 'GET',
                    data:function(value){
                        value.search = $('.search-box input').val();
                        value.orderColumn = $('#sortdrop').val();
                        value.orderDirection = $('#sortby').val();
                    },
                },
                pageLength: 3,
                ordering: false,
                searching: false,
                lengthMenu: [3,5,10,15,20,30],
                columns: [
                    { data: 'id'},
                    { data: 'name',
                     render: function(data, type, row) {
                return `<span class="user-name" data-id="${row.id}">${data}</span>`;
            }},
                    { data: 'age'},
                    { data: 'dept'},
                    { data: 'email'},
                    { data: 'subjects'}
                ]
            });

            $('#sortdrop,#sortby').on('change',function(){
                let column = $('#sortdrop').val();
                let sortby = $('#sortby').val();
                userTable.ajax.params({
                    orderColumn : column,
                    orderDirection : sortby,
                });
                userTable.ajax.reload();
            })
            $('.search-box input').on('keyup', function() {
        userTable.ajax.reload();
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


$(document).ready(function() {
    $('#usersTable').on('click', '.user-name', function() {
        let userId = $(this).data('id');

        // Fetch subjects and marks for this user
        $.ajax({
            url: '/user/' + userId + '/subjects_and_marks', // Route to fetch subjects and marks
            method: 'GET',
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    let content = '<h3>' + response.data[0].name + '</h3>';
                    content += '<ul>';

                    response.data.forEach(function(item) {
                        content += '<li><strong>Subject:</strong> ' + item.subjects + ' | <strong>Marks:</strong> ' + (item.mark || 'N/A') + '</li>';
                    });

                    content += '</ul>';
                    $('#overlayContent').html(content);
                    $("#sideOverlay").addClass("open");
                }
            },
            error: function(error) {
                console.log('Error fetching data', error);
            }
        });
    });

    // Close the side overlay
    $(".close-btn").on("click", function() {
        $("#sideOverlay").removeClass("open");
    });
});



    </script>
   <footer>
    @include('includes.footer')
</footer>


</body>
</html>
