<?php
if (isset($_POST['user'])) {
    header("Location: register.php");
    die();
} elseif (isset($_POST['admin'])) {
    header("Location: admin/adminLogin.php");
    die();
}
?>

<html>
<title>Select Role</title>
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card shadow-lg border-0 p-4" style="width: 100%; max-width: 380px;">
        <div class="text-center mb-3">
            <h4 class="fw-bold"> Select Your Role</h4>
            <p class="text-muted small">Choose an option below to continue</p>
        </div>

        <form method="post">
            <div class="d-grid gap-3">
                <button type="submit" name="user" class="btn btn-outline-primary btn-lg">
                    👤 User - Register
                </button>

                <button type="submit" name="admin" class="btn btn-outline-dark btn-lg">
                    🔐 Admin - Login
                </button>
            </div>
        </form>
    </div>
</body>

</html>