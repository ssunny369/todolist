<?php
$id = $_GET['id'];
$targetUser = readUser($id);
if ($targetUser == null || $targetUser->level == 'admin') {
    header('Location: ./?page=user/list');
}
$name = $targetUser->name;
$username = $targetUser->username;
$nameErr = $usernameErr = '';

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
    if ($targetUser->username !== $username && usernameExists($username)) {
        $usernameErr = 'Username exists!';
    }
    if (empty($nameErr) && empty($usernameErr)) {
        try {
            if (updateUser($id, $name, $username, $passwd, $photo)) {
                $targetUser = readUser($id);
                $name = $targetUser->name;
                $username = $targetUser->username;
                echo '<div class="alert alert-success" role="alert">
                Create success.
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
                    <h2 class="fw-bold" style="color: #f5f5f5;">Update User</h2>
                    <p style="color: #9a9a9a; font-size: 0.9rem;">Editing profile for: <strong>@<?php echo htmlspecialchars($targetUser->username); ?></strong></p>
                </div>

                <form method="post" action="./?page=user/update&id=<?php echo $id; ?>" enctype="multipart/form-data">

                    <div class="d-flex flex-column align-items-center mb-4">
                        <div class="position-relative">
                            <input name="photo" type="file" id="profileUpload" hidden accept="image/*">
                            <label role="button" for="profileUpload" class="d-block position-relative">
                                <img id="imgPreview"
                                    src="<?php echo $targetUser->photo ?? './assets/images/emptyuser.png'; ?>"
                                    class="rounded-circle shadow-sm"
                                    style="width:140px; height:140px; object-fit: cover; background: #1a1a1a; border: 2px solid #333;">
                                <div class="position-absolute bottom-0 end-0 bg-dark-soft rounded-circle p-2 border border-secondary shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                    </svg>
                                </div>
                            </label>
                        </div>
                        <small class="mt-2 text-secondary">Click photo to change</small>
                    </div>

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
                            placeholder="username">
                        <div class="invalid-feedback"><?php echo $usernameErr; ?></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: #777;">New Password (Optional)</label>
                        <input name="passwd" type="password" class="form-control todo-input"
                            placeholder="Leave blank to keep current password">
                    </div>

                    <div class="d-flex gap-2">
                        <a href="./?page=user/list" class="btn btn-outline-soft flex-fill fw-bold py-2">Cancel</a>
                        <button type="submit" class="btn btn-dark-soft flex-fill fw-bold py-2">Update User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // Live preview for image selection
    document.getElementById('profileUpload').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('imgPreview').src = URL.createObjectURL(file);
        }
    }
</script>