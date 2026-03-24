<?php
    echo isAdmin() ? 'ADMIN' : 'USER';
?>
<?php
$user = loggedInUser();
if (empty($user)) {
    echo '<script>window.location = "./?page=login";</script>';
    exit();
}

$todo = '';
$todoErr = '';
$message = '';

if (isset($_POST['todo_action'])) {
    $action = $_POST['todo_action'];

    if ($action === 'add') {
        $todo = trim($_POST['todo']);
        if (empty($todo)) {
            $todoErr = 'Please input your task!';
        }

        if (empty($todoErr)) {
            if (createTodo($user->id, $todo)) {
                echo '<script>window.location = "./?page=dashboard";</script>';
                exit();
            } else {
                $message = '<div class="alert alert-danger">Cannot add task!</div>';
            }
        }
    }

    if ($action === 'toggle') {
        $todo_id = (int)$_POST['todo_id'];
        toggleTodo($todo_id, $user->id);
        echo '<script>window.location = "./?page=dashboard";</script>';
        exit();
    }

    if ($action === 'delete') {
        $todo_id = (int)$_POST['todo_id'];
        deleteTodo($todo_id, $user->id);
        echo '<script>window.location = "./?page=dashboard";</script>';
        exit();
    }
}

$todoResult = getTodos($user->id);

$todoList = [];
$totalTodo = 0;
$doneTodo = 0;
$activeTodo = 0;

while ($row = $todoResult->fetch_object()) {
    $todoList[] = $row;
    $totalTodo++;
    if ($row->is_done) {
        $doneTodo++;
    } else {
        $activeTodo++;
    }
}
?>

<style>
    body {
        background: #070707;
        color: #f5f5f5;
    }

    .navbar {
        background: #0d0d0d !important;
        border-bottom: 1px solid #222;
    }

    .navbar .nav-link,
    .navbar .navbar-brand {
        color: #f5f5f5 !important;
    }

    .todo-wrap {
        max-width: 1100px;
        margin: 30px auto;
    }

    .todo-hero {
        background: linear-gradient(135deg, #111 0%, #1a1a1a 100%);
        border: 1px solid #2a2a2a;
        border-radius: 22px;
        padding: 28px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, .45);
    }

    .todo-card {
        background: #101010;
        border: 1px solid #262626;
        border-radius: 18px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .35);
    }

    .todo-input {
        background: #151515 !important;
        border: 1px solid #2e2e2e !important;
        color: #fff !important;
    }

    .todo-input:focus {
        box-shadow: none !important;
        border-color: #777 !important;
    }

    .todo-item {
        background: #121212;
        border: 1px solid #242424;
        border-radius: 16px;
        padding: 16px 18px;
        margin-bottom: 12px;
    }

    .todo-item.done {
        opacity: .78;
        border-color: #333;
    }

    .todo-item.done .todo-text {
        text-decoration: line-through;
        color: #9a9a9a;
    }

    .stat-box {
        background: #0f0f0f;
        border: 1px solid #262626;
        border-radius: 16px;
        padding: 16px;
    }

    .btn-dark-soft {
        background: #f1f1f1;
        color: #000;
        border: none;
    }

    .btn-dark-soft:hover {
        background: #dcdcdc;
        color: #000;
    }

    .btn-outline-soft {
        border-color: #444;
        color: #f5f5f5;
    }

    .btn-outline-soft:hover {
        background: #222;
        color: #fff;
    }
</style>

<div class="todo-wrap container">
    <div class="todo-hero mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="mb-1">Todo Dashboard</h2>
                <div class="text-secondary">
                    <?php echo htmlspecialchars($user->name); ?> — 
                    <?php echo isAdmin() ? 'ADMIN' : 'USER'; ?>
                </div>
            </div>
            <div class="text-end">
                <div class="text-secondary">Today</div>
                <div class="fs-5"><?php echo date('F d, Y'); ?></div>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="text-secondary">Total Tasks</div>
                    <div class="fs-3 fw-bold"><?php echo $totalTodo; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="text-secondary">Active</div>
                    <div class="fs-3 fw-bold"><?php echo $activeTodo; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="text-secondary">Done</div>
                    <div class="fs-3 fw-bold"><?php echo $doneTodo; ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $message; ?>

    <div class="todo-card p-4 mb-4">
        <h4 class="mb-3">Add New Task</h4>
        <form method="post" action="./?page=dashboard">
            <input type="hidden" name="todo_action" value="add">
            <div class="row g-2 align-items-start">
                <div class="col-md-10">
                    <input name="todo" value="<?php echo htmlspecialchars($todo); ?>" type="text"
                        class="form-control todo-input <?php echo empty($todoErr) ? '' : 'is-invalid'; ?>"
                        placeholder="Write your task here...">
                    <div class="invalid-feedback">
                        <?php echo $todoErr; ?>
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark-soft fw-bold">Add Task</button>
                </div>
            </div>
        </form>
    </div>

    <div class="todo-card p-4">
        <h4 class="mb-3">My Tasks</h4>

        <?php if (empty($todoList)) { ?>
            <div class="text-secondary">No task yet. Add one above.</div>
        <?php } else { ?>
            <?php foreach ($todoList as $todoItem) { ?>
                <div class="todo-item <?php echo $todoItem->is_done ? 'done' : ''; ?>">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="todo-text fw-semibold">
                                <?php echo htmlspecialchars($todoItem->task); ?>
                            </div>
                            <small class="text-secondary">
                                Created: <?php echo date('M d, Y h:i A', strtotime($todoItem->created_at)); ?>
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <form method="post" action="./?page=dashboard" class="m-0">
                                <input type="hidden" name="todo_action" value="toggle">
                                <input type="hidden" name="todo_id" value="<?php echo $todoItem->id; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <?php echo $todoItem->is_done ? 'Undo' : 'Done'; ?>
                                </button>
                            </form>

                            <form method="post" action="./?page=dashboard" class="m-0"
                                onsubmit="return confirm('Delete this task?')">
                                <input type="hidden" name="todo_action" value="delete">
                                <input type="hidden" name="todo_id" value="<?php echo $todoItem->id; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>