<?php

use Core\Queue;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

echo "Queue Worker started...\n";

while (true) {
    echo "searching ... \n";
    $job = Queue::pop();

    if ($job) {

        $class = trim($job['job']);
        $data  = json_decode($job['payload'], true);

        echo "Running job: $class\n";

        if (class_exists($class)) {

            try {
                $instance = new $class;
                $instance->handle($data);

                Queue::delete($job['id']);
                echo "Job executed and deleted.\n";
            } catch (Throwable $e) {

                echo "Job failed: " . $e->getMessage() . "\n";
                Queue::incrementAttempts($job['id']);
            }
        } else {
            echo "Job class not found: $class\n";
            Queue::incrementAttempts($job['id']);
        }
    } else {
        sleep(5);
    }
}
