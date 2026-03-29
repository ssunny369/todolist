<?php
$name = $username = $passwd = '';
$nameErr = $usernameErr = $passwdErr = '';
if (isset($_POST['name'], $_POST['username'], $_POST['passwd'], $_POST['confirmPasswd'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $passwd = trim($_POST['passwd']);
    $confirmPasswd = trim($_POST['confirmPasswd']);
    if (empty($name)) {
        $nameErr = 'Please input name!';
    }
    if (empty($username)) {
        $usernameErr = 'Please input username!';
    }
    if (empty($passwd)) {
        $passwdErr = 'Please input password!';
    }
    if ($passwd !== $confirmPasswd) {
        $passwdErr = 'Password does not match!';
    }
    if (usernameExists($username)) {
        $usernameErr = 'Username exists!';
    }
    if (empty($nameErr) && empty($usernameErr) && empty($passwdErr)) {
        if (registerUser($name, $username, $passwd)) {
            $name = $username = $passwd = '';
        } else {
            echo '<div class="alert alert-danger" role="alert"> Error </div>';
        }
    }
}

?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="todo-card p-5 shadow-lg">

                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 64px; height: 64px; background: #1a1a1a; border: 1px solid #333; border-radius: 18px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#f5f5f5" class="bi bi-person-plus" viewBox="0 0 16 16">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                    </div>
                    <h2 class="fw-bold" style="color: #f5f5f5;">Create Account</h2>
                    <p style="color: #9a9a9a; font-size: 0.9rem;">Join us and start organizing your tasks</p>
                </div>

                <form method="post" action="./?page=register">

                    <?php if (isset($_POST['name'])): ?>
                        <?php if (empty($nameErr) && empty($usernameErr) && empty($passwdErr)): ?>
                            <div class="alert alert-success border-0 small py-2 bg-success text-white mb-4" role="alert">
                                Registered! <a href="./?page=login" class="text-white fw-bold">Login here</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: #777;">Full Name</label>
                        <input name="name" value="<?php echo htmlspecialchars($name); ?>" type="text"
                            class="form-control todo-input <?php echo empty($nameErr) ? '' : 'is-invalid'; ?>"
                            placeholder="John Doe">
                        <div class="invalid-feedback"><?php echo $nameErr; ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: #777;">Username</label>
                        <input name="username" value="<?php echo htmlspecialchars($username); ?>" type="text"
                            class="form-control todo-input <?php echo empty($usernameErr) ? '' : 'is-invalid'; ?>"
                            placeholder="johndoe88">
                        <div class="invalid-feedback"><?php echo $usernameErr; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold" style="color: #777;">Password</label>
                            <input name="passwd" type="password"
                                class="form-control todo-input <?php echo empty($passwdErr) ? '' : 'is-invalid'; ?>"
                                placeholder="••••••••">
                            <div class="invalid-feedback"><?php echo $passwdErr; ?></div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold" style="color: #777;">Confirm</label>
                            <input name="confirmPasswd" type="password"
                                class="form-control todo-input"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark-soft fw-bold py-2 rounded-3">
                            Register Now
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <span style="color: #777; font-size: 0.85rem;">Already have an account?</span>
                        <a href="./?page=login" class="fw-bold ms-1" style="color: #f5f5f5; text-decoration: none; font-size: 0.85rem; border-bottom: 1px solid #444;">Sign In</a>
                    </div>
                </form>

            </div>

            <p class="text-center mt-4 mb-5 small" style="color: #444;">
                &copy; 2026 TodoMaster Pro
            </p>
        </div>
    </div>
</div>