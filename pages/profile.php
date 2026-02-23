<?php
$oldPasswd = $newPasswd = $confirmNewPasswd = '';
$oldPasswdErr = $newPasswdErr = '';

$user = loggedInUser();

if(isset($_POST['updatePhoto'])) updatePhoto($user);
if(isset($_POST['deletePhoto'])) deletePhoto($user);

$user = loggedInUser();

$currentPhoto = (!empty($user->photo) && file_exists('./assets/images/' . $user->photo))
    ? './assets/images/' . $user->photo : './assets/images/emptyuser.png';
?>

<div class="row">
    <div class="col-6">
        <form method="post" action="./?page=profile" enctype="multipart/form-data">
            <div class="d-flex justify-content-center">
                <input name="photo" type="file" accept=".png, .jpg, .jpeg" id="profileUpload" hidden>
                <label role="button" for="profileUpload">
                    <img id="previewImg" src="<?php echo $currentPhoto ?>" class="rounded"
                        style="width:150px; height:150px; object-fit:cover;">
                </label>
            </div>
            <div class="d-flex justify-content-center mt-2">
                <button type="submit" name="deletePhoto" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete your photo?')">Delete</button>
                <button type="submit" name="updatePhoto" class="btn btn-success">Upload</button>
            </div>
        </form>

        <script>
            document.getElementById('profileUpload').onchange = function(){
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(e){
                    document.getElementById('previewImg').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        </script>
    </div>

    <div class="col-6">
        <form method="post" action="./?page=profile" class="col-md-8 col-lg-6 mx-auto">
            <h3>Change Password</h3>
            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input value="<?php echo $oldPasswd ?>" name="oldPasswd" type="password" class="form-control 
                <?php echo empty($oldPasswdErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $oldPasswdErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input name="newPasswd" type="password" class="form-control 
                <?php echo empty($newPasswdErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $newPasswdErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input name="confirmNewPasswd" type="password" class="form-control">
            </div>
            <button type="submit" name="changePasswd" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>