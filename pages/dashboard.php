<?php
$user = loggedInUser();
if (empty($user)) {
    echo '<script>window.location = "./?page=login";</script>';
    exit();
}

$todo = '';
$deadline = '';
$priority = 1;
$todoErr = '';
$message = '';

if (isset($_POST['todo_action'])) {
    $action = $_POST['todo_action'];

    if ($action === 'add') {
        $todo = trim($_POST['todo']);
        $deadline = $_POST['deadline'] ?? null;
        $priority = (int)($_POST['priority'] ?? 1);

        if (empty($todo)) {
            $todoErr = 'Please input your task!';
        }

        if (empty($todoErr)) {
            if (createTodo($user->id, $todo, $priority, $deadline)) {
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

usort($todoList, function ($a, $b) {
    if ($b->priority === $a->priority) {
        return strtotime($b->created_at) <=> strtotime($a->created_at);
    }
    return $b->priority <=> $a->priority;
});

function renderTodoItem($todoItem)
{
    $priorityMap = [
        3 => ['label' => 'In a Hurry ⚡', 'class' => 'bg-danger'],
        2 => ['label' => 'Important ⭐', 'class' => 'bg-warning text-dark'],
        1 => ['label' => 'Normal', 'class' => 'bg-light text-dark border']
    ];
    $p = $priorityMap[$todoItem->priority] ?? $priorityMap[1];
?>
    <div class="todo-item mb-3 p-2 border-bottom <?php echo $todoItem->is_done ? 'opacity-75' : ''; ?>">
        <div class="d-flex justify-content-between align-items-center gap-3">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge <?php echo $p['class']; ?> small"><?php echo $p['label']; ?></span>
                    <span class="todo-text fw-semibold <?php echo $todoItem->is_done ? 'text-decoration-line-through text-secondary' : ''; ?>">
                        <?php echo htmlspecialchars($todoItem->task); ?>
                    </span>
                </div>
                <small class="text-secondary d-block mt-1">
                    Deadline: <?php echo $todoItem->deadline ? date('M d, Y', strtotime($todoItem->deadline)) : 'No deadline'; ?>
                </small>
            </div>

            <div class="d-flex gap-2">
                <form method="post" action="./?page=dashboard" class="m-0" id="toggle-form-<?php echo $todoItem->id; ?>">
                    <input type="hidden" name="todo_action" value="toggle">
                    <input type="hidden" name="todo_id" value="<?php echo $todoItem->id; ?>">
                    <button type="button"
                        class="btn btn-sm <?php echo $todoItem->is_done ? 'btn-outline-secondary' : 'btn-success'; ?>"
                        onclick="confirmToggle(<?php echo $todoItem->id; ?>, <?php echo $todoItem->is_done ? 'true' : 'false'; ?>)">
                        <?php echo $todoItem->is_done ? 'Undo' : 'Done'; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                        </svg>
                    </button>
                </form>

                <form method="post" action="./?page=dashboard" class="m-0" id="delete-form-<?php echo $todoItem->id; ?>">
                    <input type="hidden" name="todo_action" value="delete">
                    <input type="hidden" name="todo_id" value="<?php echo $todoItem->id; ?>">
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $todoItem->id; ?>)">
                        Delete
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<div class="todo-wrap container mt-4">
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
                <div id="real-time-clock" class="fw-bold text-primary small"></div>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="text-secondary small">Total Tasks</div>
                    <div class="fs-3 fw-bold"><?php echo $totalTodo; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="text-secondary small">Active</div>
                    <div class="fs-3 fw-bold"><?php echo $activeTodo; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="text-secondary small">Done</div>
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

            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-bold text-muted">Task Description</label>
                    <input name="todo" value="<?php echo htmlspecialchars($todo); ?>" type="text"
                        class="form-control todo-input <?php echo empty($todoErr) ? '' : 'is-invalid'; ?>"
                        placeholder="What needs to be done?">
                    <div class="invalid-feedback"><?php echo $todoErr; ?></div>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="3">In a Hurry ⚡</option>
                        <option value="2">Important ⭐</option>
                        <option value="1" selected>Normal</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Deadline</label>
                    <input name="deadline" type="date" class="form-control" value="<?php echo htmlspecialchars($deadline); ?>">
                </div>

                <div class="col-md-2 d-grid align-self-end">
                    <button type="submit" class="btn btn-dark-soft fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                        </svg>
                        Add Task</button>
                </div>
            </div>
        </form>
    </div>

    <div class="todo-card p-4 mb-4">
        <h4 class="mb-3">My Tasks</h4>
        <?php
        $activeTasks = array_filter($todoList, fn($t) => !$t->is_done);
        $completedTasks = array_filter($todoList, fn($t) => $t->is_done);

        if (empty($activeTasks)) { ?>
            <div class="text-secondary mb-4 p-3 border rounded text-center">No pending tasks! 🎉</div>
        <?php } else {
            foreach ($activeTasks as $todoItem) {
                renderTodoItem($todoItem);
            }
        } ?>

        <?php if (!empty($completedTasks)) { ?>
            <hr class="my-4">
            <h4 class="mb-3 text-success">Completed Tasks</h4>
        <?php foreach ($completedTasks as $todoItem) {
                renderTodoItem($todoItem);
            }
        } ?>
    </div>
</div>