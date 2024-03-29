<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Task.php';

$database = new Database();
$db = $database->connect();

$task = new Task($db);

$result = $task->read();
$num = $result->rowCount();

if ($num > 0) {
    $taskArr = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $taskItem = array(
            'Name' => $row['Name'],
            'TaskId' => $row['TaskId'],
            'Description' => $row['Description'],
            'Time' => $row['Time'],
            'Worker' => $row['Worker'],
            'WorkerId' => $row['WorkerId'],
            'Status' => $row['Status'],
        );
        array_push($taskArr, $taskItem);
    }
    echo json_encode($taskArr);
} else {
    echo json_encode(array('message' => 'No tasks found'));
}