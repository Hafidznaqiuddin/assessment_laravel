<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Table Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- // css funtion  -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #040720;
        }

        h1 {
            text-align: center;
            color: #ffffff;
            margin-top: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            text-decoration: none;
            color: #3498db;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: #e74c3c;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 100px;
            margin-left: 1350px;
        }

        .delete-button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none
            display: inline-block;
            transition: background-color 0.3s ease-in-out;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    <h1>Table User</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Birthday</th>
            <th>Created At</th>
            <th>Delete</th>
        </tr>

        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->gender }}</td>
            <td>{{ $user->birthday->format('d/m/y') }}</td>
            <td>{{ $user->created_at }}</td>
            <td>
                <a href="javascript:void(0)" onclick="confirmDelete('{{ route('user.delete', ['id' => $user->id]) }}')"
                    class="delete-button">Delete</a>
            </td>
        </tr>
        @endforeach
    </table>
    <a href="{{ route('form_page') }}"><button type="button">Back</button></a>

     <!-- javascript funtion -->
    <script>
        async function confirmDelete(deleteUrl) {
            const isConfirmed = await Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if (isConfirmed.isConfirmed) {
                try {
                    const response = await fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                        },
                    });

                    if (response.ok) {
                        // User deleted successfully
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'User has been deleted.',
                            icon: 'success',
                        }).then(() => {
                            // Optionally, you can delay the reload
                            setTimeout(() => {
                                location.reload();
                            }, 500); // 1000 milliseconds (1 second) delay, adjust as needed
                        });
                    } else {
                        // Handle errors
                        console.error('Error deleting user:', response.statusText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error deleting user. Please try again later.',
                            icon: 'error',
                        });
                    }
                } catch (error) {
                    console.error('Error deleting user:', error.message);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error deleting user. Please try again later.',
                        icon: 'error',
                    });
                }
            }
        }
    </script>
</body>

</html>