<?php
if (isset($_POST['user_register'])) {
    header("Location: register.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Register</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card shadow-lg border-0 p-4 text-center" style="width: 100%; max-width: 400px;">
        <form method="post">
            <button type="submit" name="user_register" class="btn btn-primary btn-lg w-100">
                👤 Register as User
            </button>
        </form>
    </div>

</body>
</html>
