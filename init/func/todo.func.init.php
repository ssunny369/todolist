<?php
function createTodo($user_id, $task, $priority, $deadline)
{
    global $db; // Changed from $conn to $db
    $stmt = $db->prepare("INSERT INTO tbl_todos (user_id, task, priority, deadline) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $db->error);
    }

    $stmt->bind_param("isis", $user_id, $task, $priority, $deadline);
    return $stmt->execute();
}

function getTodos($user_id)
{
    global $db;

    $query = $db->prepare('SELECT * FROM tbl_todos WHERE user_id = ? ORDER BY is_done ASC, priority DESC, id DESC');
    $query->bind_param('i', $user_id);
    $query->execute();
    return $query->get_result();
}

function toggleTodo($id, $user_id)
{
    global $db;
    $query = $db->prepare('UPDATE tbl_todos SET is_done = IF(is_done = 1, 0, 1) WHERE id = ? AND user_id = ?');
    $query->bind_param('ii', $id, $user_id);
    $query->execute();
    return $db->affected_rows > 0;
}

function deleteTodo($id, $user_id)
{
    global $db;
    $query = $db->prepare('DELETE FROM tbl_todos WHERE id = ? AND user_id = ?');
    $query->bind_param('ii', $id, $user_id);
    $query->execute();
    return $db->affected_rows > 0;
}
?>