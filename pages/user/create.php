<?php
$name = $username = $passwd = '';
$nameErr = $usernameErr = $passwdErr = '';
if (isset($_POST['name'], $_POST['username'], $_POST['passwd'], $_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $passwd = trim($_POST['passwd']);
    if (empty($name)) {
        $nameErr = 'please input name!';
    }
    if (empty($username)) {
        $usernameErr = 'please input username!';
    }
    if (empty($passwd)) {
        $passwdErr = 'please input password!';
    }
    if (usernameExists($username)) {
        $usernameErr = 'Username exists!';
    }
    if (empty($nameErr) && empty($usernameErr) && empty($passwdErr)) {
        try {
            if (createUser($name, $username, $passwd, $photo)) {
                $name = $username = $passwd = '';
                echo '<div class="alert alert-success" role="alert">
                Create success.
                </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                 Create failed!
                </div>';
            }
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">
                 ' . $e->getMessage() . '
                </div>';
        }
    }
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="todo-card p-5 shadow-lg">

                <div class="text-center mb-4">
                    <h2 class="fw-bold" style="color: #f5f5f5;">Create User</h2>
                    <p style="color: #9a9a9a; font-size: 0.9rem;">Admin Panel: Add a new member</p>
                </div>

                <form method="post" action="./?page=user/create" enctype="multipart/form-data">

                    <div class="d-flex flex-column align-items-center mb-4">
                        <div class="position-relative">
                            <input name="photo" type="file" id="profileUpload" hidden accept="image/*">
                            <label role="button" for="profileUpload" class="d-block position-relative">
                                <img id="imgPreview" src="./assets/images/emptyuser.png"
                                    class="rounded-circle img-thumbnail shadow-sm"
                                    style="width:150px; height:150px; object-fit: cover; background: #1a1a1a; border: 2px dashed #444;">
                                <div class="position-absolute bottom-0 end-0 bg-dark-soft rounded-circle p-2 shadow-sm" style="border: 1px solid #444;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                                        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4z" />
                                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                                    </svg>
                                </div>
                            </label>
                        </div>
                        <small class="mt-2" style="color: #777;">Click to upload photo</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: #777;">Full Name</label>
                        <input name="name" value="<?php echo htmlspecialchars($name); ?>" type="text"
                            class="form-control todo-input <?php echo empty($nameErr) ? '' : 'is-invalid'; ?>"
                            placeholder="Full name">
                        <div class="invalid-feedback"><?php echo $nameErr; ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: #777;">Username</label>
                        <input name="username" value="<?php echo htmlspecialchars($username); ?>" type="text"
                            class="form-control todo-input <?php echo empty($usernameErr) ? '' : 'is-invalid'; ?>"
                            placeholder="username">
                        <div class="invalid-feedback"><?php echo $usernameErr; ?></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: #777;">Password</label>
                        <input name="passwd" type="password"
                            class="form-control todo-input <?php echo empty($passwdErr) ? '' : 'is-invalid'; ?>"
                            placeholder="••••••••">
                        <div class="invalid-feedback"><?php echo $passwdErr; ?></div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark-soft fw-bold py-2 rounded-3">
                            Create User
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // Script to preview the image immediately after selection
    document.getElementById('profileUpload').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('imgPreview').src = URL.createObjectURL(file);
        }
    }
</script>