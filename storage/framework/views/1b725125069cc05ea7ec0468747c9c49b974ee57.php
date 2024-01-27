<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Table Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
            /* Red color */
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            /* Remove underline from the link */
            display: inline-block;
            transition: background-color 0.3s ease-in-out;
        }

        .delete-button:hover {
            background-color: #c0392b;
            /* Darker red color on hover */
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

        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($user->id); ?></td>
            <td><?php echo e($user->name); ?></td>
            <td><?php echo e($user->email); ?></td>
            <td><?php echo e($user->gender); ?></td>
            <td><?php echo e($user->birthday->format('d/m/y')); ?></td>
            <td><?php echo e($user->created_at); ?></td>
            <td>
                <a href="javascript:void(0)" onclick="confirmDelete('<?php echo e(route('user.delete', ['id' => $user->id])); ?>')"
                    class="delete-button">Delete</a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    <a href="<?php echo e(route('form_page')); ?>"><button type="button">Back</button></a>

    <!-- Updated script for client-side deletion -->
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
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', // Include CSRF token
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

</html><?php /**PATH C:\xampp7\htdocs\assessment-app\my_assessment_app\resources\views/table_page.blade.php ENDPATH**/ ?>