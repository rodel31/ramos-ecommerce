<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Registeration</title>
</head>
<style>

    @keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    body {
        background-image: url("bg.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        text-align: center;
    }

    .container {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .info{
        padding: 15px;
        margin-bottom: 15px;
    }

    .inpuGroup1 {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 15px;
    }

    .inpuGroup1 label { 
        color: #3498db;
        font-family: Verdana;
        font-size: 20px; 
        font-weight: bold;
    }

    h1 {
        color: #1f618d;
        font-family: Century Gothic;
    }
</style>
<script src="js/scripts.js"></script>
<body>
    <div class="container">
    <h1>Registration</h1>
    <br>

        <form action="actions/ramosRegistrationActions.php" method="POST" enctype="multipart/form-data">

            <fieldset class="info">
                <div class="inpuGroup">
                    <label>First Name</label>
                    <input type="text" name="ramos-fname" required>
                </div>
                <div class="inpuGroup">
                    <label>Last Name</label>
                    <input type="text" name="ramos-lname" required>
                </div>
                <div class="inpuGroup">
                    <label>Middle Name</label>
                    <input type="text" name="ramos-mname" required>
                </div>
                <div class="inpuGroup">
                    <label>Contact</label>
                    <input type="number" name="ramos-contact" required>
                </div>
                <div class="inpuGroup">
                    <label>Street</label>
                    <input type="text" name="ramos-street" required>
                </div>
                <div class="inpuGroup">
                    <label>Barangay</label>
                    <input type="text" name="ramos-barangay" required>
                </div>
                <div class="inpuGroup">
                    <label>Municipality</label>
                    <input type="text" name="ramos-municipality" required>
                </div>
                <div class="inpuGroup">
                    <label>Province</label>
                    <input type="text" name="ramos-province" required>
                </div>
                <div class="inpuGroup">
                    <label>ZIP</label>
                    <input type="text" name="ramos-zip" required>
                </div>
                <div class="inpuGroup1">
                    <label>Profile Picture</label>
                    <input type="file" class="DP" name="ramos-profile-picture" accept="image/*" required>
                </div>
            </fieldset>
            

            <fieldset class="info">
                <div class="inpuGroup">
                    <label>Email</label>
                    <input type="email" name="ramos-email" required>
                </div>

                <div class="inpuGroup">
                    <label>Username</label>
                    <input type="text" name="ramos-username" required>
                </div>

                <div class="inpuGroup">
                    <label>Password</label>
                    <input type="password" name="ramos-password" required>
                </div>

                <div class="inpuGroup">
                    <label>Confirm Password</label>
                    <input type="password" name="ramos-confirm-password" required>
                </div>

                <div class="inpuGroup">
                    <label>Register as:</label>
                    <select id="user_type" name="user_type" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    </select><br><br>
                </div>
            </fieldset>

            <button type="submit" name="register" class="ramos-signup">Register</button>
            
        </form>
    </div>
</body>
</html>