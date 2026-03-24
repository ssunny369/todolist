<?php
function createTodo($user_id, $task)
{
    global $db;
    $query = $db->prepare('INSERT INTO tbl_todos (user_id, task) VALUES (?, ?)');
    $query->bind_param('is', $user_id, $task);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}

function getTodos($user_id)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_todos WHERE user_id = ? ORDER BY is_done ASC, id DESC');
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();
    return $result;
}

function toggleTodo($id, $user_id)
{
    global $db;
    $query = $db->prepare('UPDATE tbl_todos SET is_done = IF(is_done = 1, 0, 1) WHERE id = ? AND user_id = ?');
    $query->bind_param('ii', $id, $user_id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}

function deleteTodo($id, $user_id)
{
    global $db;
    $query = $db->prepare('DELETE FROM tbl_todos WHERE id = ? AND user_id = ?');
    $query->bind_param('ii', $id, $user_id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
?>