<?php

class Task
{
    private $conn;
    private $table = 'tasks';

    public $id;
    public $name;
    public $description;
    public $time;
    public $userId;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function readById()
    {
        $query = 'SELECT t.name AS Name,t.id AS TaskId,t.description AS Description,
            t.time AS Time,u.username AS Worker,u.id AS WorkerId,s.name AS Status
            FROM tasks t,users u,statustype s WHERE u.id=t.userId AND t.status=s.id AND t.id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function readByUser()
    {
        $query = 'SELECT t.name AS Name,t.id AS TaskId,t.description AS Description,
            t.time AS Time,u.username AS Worker,u.id AS WorkerId,s.name AS Status 
            FROM tasks t,users u,statustype s WHERE u.id=t.userId AND t.status=s.id AND t.userId = ? ORDER BY t.time ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        // same cancer
//        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//        $this->id = $row['TaskId'];
//        $this->name = $row['Name'];
//        $this->description = $row['Description'];
//        $this->time = $row['Time'];
//        $this->userId = $row['WorkerId'];
//        $this->status = $row['Status'];
        return $stmt;
    }

    public function read()
    {
        $query = 'SELECT t.name AS Name,t.id AS TaskId,t.description AS Description,t.time AS Time,
            u.username AS Worker,u.id AS WorkerId,s.name AS Status FROM tasks t,users u,statustype s
            WHERE u.id=t.userId AND t.status=s.id ORDER BY t.time ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByStatus()
    {
        $query = 'SELECT t.name AS Name,t.id AS TaskId,t.description AS Description, t.time AS Time,
            u.username AS Worker,u.id AS WorkerId,s.name AS Status FROM tasks t,users u,statustype s
            WHERE u.id=t.userId AND t.status=s.id AND t.status = ? ORDER BY t.time ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        // causes deletion of lowest value ID for each status of tasks
//        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//        $this->id = $row['TaskId'];
//        $this->name = $row['Name'];
//        $this->description = $row['Description'];
//        $this->time = $row['Time'];
//        $this->userId = $row['WorkerId'];
//        $this->status = $row['Status'];
        return $stmt;
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table .
            ' SET name = :name,
                 description = :description,
                  time = :time,
                   userId = :userId,
                   status = :status';
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':time', $this->time);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':status', $this->status);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table .
            ' SET name = :name,
                 description = :description,
                  time = :time,
                   userId = :userId,
                   status = :status WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':time', $this->time);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);


        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}