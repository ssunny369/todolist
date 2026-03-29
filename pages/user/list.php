<div class="todo-wrap container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #f5f5f5;">User Management</h3>
            <p class="text-secondary small mb-0">Manage system administrators and users</p>
        </div>
        <a href="./?page=user/create" class="btn btn-dark-soft fw-bold shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
            </svg>
            Create User
        </a>
    </div>

    <div class="todo-card p-0 overflow-hidden shadow-lg">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="color: #f5f5f5;">
                <thead style="background: #1a1a1a;">
                    <tr>
                        <th class="ps-4 border-0 text-secondary small text-uppercase py-3">#</th>
                        <th class="border-0 text-secondary small text-uppercase py-3">Profile</th>
                        <th class="border-0 text-secondary small text-uppercase py-3">Full Name</th>
                        <th class="border-0 text-secondary small text-uppercase py-3">Role</th>
                        <th class="pe-4 border-0 text-secondary small text-uppercase py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = getUsers();
                    $count = 1;
                    while ($row = $users->fetch_object()) {
                        // Determine badge color for roles
                        $roleClass = (isset($row->level) && $row->level === 'admin') ? 'bg-info text-dark' : 'bg-light text-dark opacity-50';
                    ?>
                        <tr style="border-bottom: 1px solid #222;">
                            <td class="ps-4 fw-bold text-secondary"><?php echo $count; ?></td>
                            <td>
                                <img src="<?php echo $row->photo ?? './assets/images/emptyuser.png'; ?>"
                                    class="rounded-circle shadow-sm"
                                    style="width: 45px; height: 45px; object-fit: cover; border: 1px solid #333;">
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo htmlspecialchars($row->name); ?></div>
                                <div class="small text-secondary">@<?php echo htmlspecialchars($row->username); ?></div>
                            </td>
                            <td>
                                <span class="badge <?php echo $roleClass; ?> fw-bold small text-uppercase">
                                    <?php echo $row->level ?? 'USER'; ?>
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <a href="./?page=user/update&id=<?php echo $row->id; ?>"
                                        class="btn btn-sm btn-outline-success px-3 fw-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                        Update
                                    </a>

                                    <a href="./?page=user/delete&id=<?php echo $row->id; ?>"
                                        class="btn btn-sm btn-outline-danger ms-1 px-3 fw-bold delete-btn"
                                        data-name="<?php echo htmlspecialchars($row->name); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                        </svg>
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Hover effect for the table rows */
    .table-hover tbody tr:hover {
        background-color: #151515 !important;
        transition: 0.2s;
    }

    /* Remove default table borders */
    .table> :not(caption)>*>* {
        box-shadow: none;
    }
</style>