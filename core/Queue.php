<?php

namespace Core;

use Core\Database;
use PDO;
use DateTime;

class Queue
{
    public static function push(string $job, array $data = [], int $delay = 0)
    {
        $db = Database::connect();

        $availableAt = (new DateTime())->modify("+{$delay} seconds")->format('Y-m-d H:i:s');
        $payload = json_encode($data);

        $sql = "INSERT INTO queue_jobs (job, payload, available_at) VALUES (:job, :payload, :available_at)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':job' => $job,
            ':payload' => $payload,
            ':available_at' => $availableAt
        ]);
    }

    public static function pop(): ?array
    {
        $db = Database::connect();

        $sql = "SELECT * FROM queue_jobs 
                WHERE available_at <= NOW() 
                ORDER BY id ASC LIMIT 1";
        $stmt = $db->query($sql);
        $job = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$job) return null;

        return $job;
    }


    public static function delete($id)
    {
        $db = Database::connect();
        return $db->exec("DELETE FROM queue_jobs WHERE id = $id");
    }

    public static function incrementAttempts($id)
    {
        $db = Database::connect();
        return $db->exec("UPDATE queue_jobs SET attempts = attempts + 1 WHERE id = $id");
    }
}
