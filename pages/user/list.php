<div class="todo-wrap container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color: #ffffff;">User Management</h3>
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
            <table class="table table-hover align-middle mb-0" style="color: #ffffff;">
                <thead style="background: #656566;">
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
                        $isAdmin = (isset($row->level) && $row->level === 'admin');
                        $roleClass = $isAdmin ? 'role-admin' : 'role-user';
                    ?>
                        <tr>
                            <td class="ps-4 text-light opacity-75 small fw-bold"><?php echo sprintf("%02d", $count); ?></td>
                            <td>
                                <div class="profile-container">
                                    <img src="<?php echo $row->photo ?? './assets/images/emptyuser.png'; ?>" class="user-avatar">
                                    <?php if ($isAdmin): ?><span class="admin-dot"></span><?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-white mb-0"><?php echo htmlspecialchars($row->name); ?></div>
                                <div class="text-secondary-light tiny-text">@<?php echo htmlspecialchars($row->username); ?></div>
                            </td>
                            <td>
                                <span class="badge-custom <?php echo $roleClass; ?>">
                                    <?php echo strtoupper($row->level ?? 'USER'); ?>
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="action-wrapper">
                                    <a href="./?page=user/update&id=<?php echo $row->id; ?>"
                                        class="action-link edit-link edit-btn"
                                        data-name="<?php echo htmlspecialchars($row->name); ?>">
                                        <i class="bi bi-pencil-square"></i> Update
                                    </a>
                                    <a href="./?page=user/delete&id=<?php echo $row->id; ?>"
                                        class="action-link delete-link delete-btn"
                                        data-name="<?php echo htmlspecialchars($row->name); ?>">
                                        <i class="bi bi-trash3"></i> Delete
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
    /* 1. Base Table Styling */
    .table {
        border-collapse: separate;
        border-spacing: 0 8px;
        /* This creates the "floating row" gap */
        background: transparent;
    }

    .table thead th {
        background: transparent;
        border: none;
        color: #b0b0b0;
        /* Lighter header text */
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* This part overrides Bootstrap's white background */
    .table tbody tr,
    .table-hover tbody tr:hover {
        background-color: #121212 !important;
        /* Pure Dark Gray */
        color: #ffffff !important;
    }

    /* Ensure the cells themselves don't have a background */
    .table td {
        background-color: transparent !important;
        color: #ffffff !important;
    }

    /* Make the text extra bold and bright so it pops */
    .text-white {
        color: #ffffff !important;
        font-weight: 700 !important;
        opacity: 1 !important;
    }

    /* Fix the number column which looks faded in your screenshot */
    .table td:first-child {
        color: #00f2fe !important;
        /* Give it a cool glow color */
        font-weight: bold;
    }

    .text-secondary-light {
        color: #a0a0a0 !important;
        /* Subtle gray for @usernames */
    }

    .tiny-text {
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* 4. Avatar & Profile Styling */
    .profile-container {
        position: relative;
        width: 42px;
        margin-left: 10px;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #444;
    }

    .admin-dot {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 12px;
        height: 12px;
        background: #00f2fe;
        border: 2px solid #1a1a1a;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0, 242, 254, 0.5);
    }

    /* 5. Custom Role Badges */
    .badge-custom {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        display: inline-block;
    }

    .role-admin {
        background: rgba(0, 242, 254, 0.15);
        color: #00f2fe !important;
        border: 1px solid rgba(0, 242, 254, 0.3);
    }

    .role-user {
        background: rgba(255, 255, 255, 0.08);
        color: #e0e0e0 !important;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    /* 6. Action Button Styling */
    .action-wrapper {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .action-link {
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 7px 14px;
        border-radius: 8px;
        transition: 0.2s all ease;
    }

    .edit-link {
        color: #4ade80;
        background: rgba(74, 222, 128, 0.12);
    }

    .edit-link:hover {
        background: #4ade80;
        color: #121212 !important;
    }

    .delete-link {
        color: #f87171;
        background: rgba(248, 113, 113, 0.12);
    }

    .delete-link:hover {
        background: #f87171;
        color: #ffffff !important;
    }

    /* Rounded corners for the start and end of rows */
    .table td:first-child {
        border-radius: 12px 0 0 12px !important;
    }

    .table td:last-child {
        border-radius: 0 12px 12px 0 !important;
    }
</style>