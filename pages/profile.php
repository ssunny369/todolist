<?php
$oldPasswd = $newPasswd = $confirmNewPasswd = '';
$oldPasswdErr = $newPasswdErr  = '';

if (isset($_POST['changePasswd'], $_POST['oldPasswd'], $_POST['newPasswd'], $_POST['confirmNewPasswd'])) {
    $oldPasswd = trim($_POST['oldPasswd']);
    $newPasswd = trim($_POST['newPasswd']);
    $confirmNewPasswd = trim($_POST['confirmNewPasswd']);
    if (empty($oldPasswd)) {
        $oldPasswdErr = 'please input your old password';
    }
    if (empty($newPasswd)) {
        $newPasswdErr = 'please input your new password';
    }
    if ($newPasswd !== $confirmNewPasswd) {
        $newPasswdErr = 'password does not match';
    }
    if (!isUserHasPassword($oldPasswd)) {
        $oldPasswdErr = 'password is incorrect';
    }
    if (empty($oldPasswdErr) && empty($newPasswdErr)) {
        if (setUserNewPassowrd($newPasswd)) {
            header('Location: ./?page=logout');
        } else {
            echo '<div class="alert alert-danger" role="alert">
                try aggain.
                </div>';
        }
    }
}



if (isset($_POST['uploadPhoto']) && isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];
    if (empty($photo['name'])) {
        echo '<div class="alert alert-danger" role="alert">
            Please select a photo to upload.
            </div>';
    } else {
        try {
            if (changeProfileImage($photo)) {
                echo '<div class="alert alert-success" role="alert">
                    profile image changed successfully.
                    </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                    failed to change profile image.
                    </div>';
            }
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">
                ' . $e->getMessage() . '
                </div>';
        }
    }
}

if (isset($_POST['deletePhoto'])) {
    deleteProfileImage();
}
?>

<div class="container mt-4">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="todo-card p-4 h-100 shadow-sm text-center">
                <h4 class="mb-4 fw-bold" style="color: #f5f5f5;">Profile Picture</h4>

                <form method="post" action="./?page=profile" enctype="multipart/form-data">
                    <div class="mb-4">
                        <input name="photo" type="file" id="profileUpload" hidden accept="image/*">
                        <label role="button" for="profileUpload" class="position-relative d-inline-block">
                            <img id="imgPreview"
                                src="<?php echo loggedInUser()->photo ?? './assets/images/emptyuser.png' ?>"
                                class="rounded-circle shadow"
                                style="width:180px; height:180px; object-fit: cover; border: 3px solid #262626; background: #151515;">
                            <div class="position-absolute bottom-0 end-0 bg-dark-soft rounded-circle p-2 border border-dark shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                    <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                                </svg>
                            </div>
                        </label>
                        <p class="text-secondary small mt-3">Click the image to browse files</p>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <button type="submit" name="uploadPhoto" class="btn btn-dark-soft fw-bold px-4">Save Photo</button>
                        <button type="submit" name="deletePhoto" class="btn btn-outline-danger fw-bold" onclick="return confirm('Delete photo?')">Remove</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="todo-card p-4 h-100 shadow-sm">
                <h4 class="mb-4 fw-bold" style="color: #f5f5f5;">Account Security</h4>

                <form method="post" action="./?page=profile">
                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: #777;">Current Password</label>
                        <input value="<?php echo $oldPasswd ?>" name="oldPasswd" type="password"
                            class="form-control todo-input <?php echo empty($oldPasswdErr) ? '' : 'is-invalid' ?>"
                            placeholder="Confirm current password">
                        <div class="invalid-feedback"><?php echo $oldPasswdErr ?></div>
                    </div>

                    <hr class="my-4" style="border-color: #222;">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold" style="color: #777;">New Password</label>
                            <input name="newPasswd" type="password"
                                class="form-control todo-input <?php echo empty($newPasswdErr) ? '' : 'is-invalid' ?>"
                                placeholder="Min. 8 characters">
                            <div class="invalid-feedback"><?php echo $newPasswdErr ?></div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold" style="color: #777;">Confirm New</label>
                            <input name="confirmNewPasswd" type="password" class="form-control todo-input"
                                placeholder="Repeat new password">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="changePasswd" class="btn btn-dark-soft fw-bold py-2">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Live preview for profile photo
    document.getElementById('profileUpload').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('imgPreview').src = URL.createObjectURL(file);
        }
    }
</script>