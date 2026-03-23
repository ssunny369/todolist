<div class="container">
    <div class="d-flex justify-content-between">
        <h3>User List</h3>
        <a href="./?page=user/create" class="btn btn-success">Create now</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = getUsers();
            $count = 1;
            while ($row = $users->fetch_object()) {
            ?>
                <tr>
                    <td><?php $count ?></td>
                    <td><img src="
                     <?php echo $row->picture ?? './assets/images/emptyuser.png'  ?> 
                    "></td>
                    <td><?php echo $row->name ?></td>
                    <td>
                        <a  href="./?page=user/update&id=<?php echo $row->id ?>" class="btn btn-primary">Update</a >
                        <a  href="./?page=user/delete&id=<?php echo $row->id ?>" class="btn btn-danger">Delete</a >
                    </td>
                </tr>
            <?php
                $count++;
            }
            ?>

        </tbody>
    </table>
</div>
