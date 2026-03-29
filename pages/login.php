<?php
$username = '';
$usernameErr = $passwdErr = '';
if (isset($_POST['username'], $_POST['passwd'])) {
    $username = trim($_POST['username']);
    $passwd = trim($_POST['passwd']);

    if (empty($username)) {
        $usernameErr = 'Please input username!';
    }
    if (empty($passwd)) {
        $passwdErr = 'Please input password!';
    }
    if (empty($usernameErr) && empty($passwdErr)) {
        $user = logUserIn($username, $passwd);
        if ($user !== false) {
            $_SESSION['user_id'] = $user->id;
            header('Location: ./?page=dashboard');
        } else {
            echo '<div class= "alert-danger" role="alert">
            Login failed!
            </div>';
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="todo-card p-5 shadow-lg">

                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 64px; height: 64px; background: #1a1a1a; border: 1px solid #333; border-radius: 18px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#f5f5f5" class="bi bi-lock" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                        </svg>
                    </div>
                    <h2 class="fw-bold" style="color: #f5f5f5;">Welcome Back</h2>
                    <p style="color: #9a9a9a; font-size: 0.9rem;">Sign in to your Todo Dashboard</p>
                </div>

                <form method="post" action="./?page=login">
                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: #777;">Username</label>
                        <input name="username" value="<?php echo htmlspecialchars($username); ?>" type="text"
                            class="form-control todo-input py-2 <?php echo empty($usernameErr) ? '' : 'is-invalid'; ?>"
                            placeholder="Enter username">
                        <div class="invalid-feedback"><?php echo $usernameErr; ?></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: #777;">Password</label>
                        <input name="passwd" type="password"
                            class="form-control todo-input py-2 <?php echo empty($passwdErr) ? '' : 'is-invalid'; ?>"
                            placeholder="••••••••">
                        <div class="invalid-feedback"><?php echo $passwdErr; ?></div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark-soft fw-bold py-2 rounded-3">
                            Sign In
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <span style="color: #777; font-size: 0.85rem;">Don't have an account?</span>
                        <a href="./?page=register" class="fw-bold ms-1" style="color: #f5f5f5; text-decoration: none; font-size: 0.85rem; border-bottom: 1px solid #444;">Register</a>
                    </div>
                </form>

            </div>

            <p class="text-center mt-4 small" style="color: #444;">
                &copy; 2026 TodoMaster Pro
            </p>
        </div>
    </div>
</div>