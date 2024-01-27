<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/lottie-web@5.7.4"></script>

    <!-- // css funtion  -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #040720;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            display: flex;
            align-items: center;
        }

        #lottie-container {
            width: 550px;
            height: 550px;
            margin-left: 200px;
        }

        #form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            height: 600px;
            margin-left: 250px
        }

        h1 {
            text-align: center;
            color: #000000;
            border-bottom: 2px solid #000000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        select,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
        }

        #button1 {
            margin-top: 75px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>

    <!-- javascript funtion -->
    <script>
        //Notification data success
        document.addEventListener('DOMContentLoaded', function () {
            <?php if(Session:: has('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "<?php echo e(Session::get('success')); ?>",
            showConfirmButton: false,
            timer: 3000
        });
        <?php endif; ?>

        //Lottie file funtion
        const animationContainer = document.getElementById('lottie-animation');
        const animationPath = 'https://lottie.host/c8ade029-9950-474e-8ed2-8b6d2c45c9b8/FXosIa96GU.json'; //lottie file link

        if (animationContainer && animationPath) {
            const animation = lottie.loadAnimation({
                container: animationContainer,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: animationPath,
            });
        } else {
            console.error('Invalid animation container or path.');
        }
        });

        //Notification Form
        async function validateForm() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var gender = document.getElementById('gender').value;
            var birthday = document.getElementById('birthday').value;

            // Check if name is empty
            if (name.trim() === '') {
                alert('Please enter your name.');
                return false; // Prevent form submission
            }

            // Check if email is valid
            if (!isValidEmail(email)) {
                alert('Please enter a valid email address.');
                return false;
            }

            // Check if password meets requirements (e.g., minimum length)
            if (password.length < 6) {
                alert('Password must be at least 6 characters.');
                return false;
            }

            // Check if gender is selected
            if (gender === '') {
                alert('Please select your gender.');
                return false;
            }

            // Check if birthday is selected
            if (birthday === '') {
                alert('Please enter your birthday.');
                return false;
            }

            // Check if email is already used
            const isEmailAvailable = await checkEmailAvailability(email);
            if (!isEmailAvailable) {
                alert('This email has already been used.');
                return false;
            }

            return true; // Allow form submission
        }

        // Helper function to validate email format
        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Simulated function to check email availability on the server
        async function checkEmailAvailability(email) {
            return new Promise(resolve => {
                fetch(`/checkEmail?email=${encodeURIComponent(email)}`)
                    .then(response => response.json())
                    .then(data => resolve(data.isAvailable));
            });
        }
    </script>
</head>

<body>
    <div class="container">
        <div id="lottie-container">
            <div id="lottie-animation"></div>
            <a href="<?php echo e(route('user.index')); ?>"><button id="button1" type="button">Go to Table Page</button></a>
        </div>

        <div id="form-container">
            <h1>Create User</h1>

            <form action="<?php echo e(route('user.store')); ?>" method="post" onsubmit="return validateForm()">
                <?php echo csrf_field(); ?> <!-- CSRF protection -->

                <label for="name">Name:</label>
                <input type="text" id="name" name="name">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password">

                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <label for="birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday">

                <label for="status_active">Status Active:</label>
                <input type="checkbox" id="status_active" name="status_active" value="1">

                <button type="submit">Save Data</button>
            </form>
        </div>
    </div>
</body>

</html><?php /**PATH C:\Users\ASUS\Downloads\assessment-app\my_assessment_app\resources\views/form_page.blade.php ENDPATH**/ ?>