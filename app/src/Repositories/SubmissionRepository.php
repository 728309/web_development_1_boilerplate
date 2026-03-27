<?php

namespace App\Repositories;

use PDO;

class SubmissionRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host=mysql;dbname=sk_production_hub;charset=utf8mb4',
            'root',
            'secret123'
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createSubmission(
        int $userId,
        string $title,
        string $artistName,
        string $description,
        string $genre,
        string $mediaUrl
    ): void {
        $sql = "
            INSERT INTO submissions (
                user_id,
                title,
                artist_name,
                description,
                genre,
                media_url,
                status,
                admin_feedback,
                reviewed_by,
                reviewed_at,
                created_at,
                updated_at
            ) VALUES (
                :user_id,
                :title,
                :artist_name,
                :description,
                :genre,
                :media_url,
                'pending',
                NULL,
                NULL,
                NULL,
                NOW(),
                NOW()
            )
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':artist_name' => $artistName,
            ':description' => $description,
            ':genre' => $genre,
            ':media_url' => $mediaUrl,
        ]);
    }
}