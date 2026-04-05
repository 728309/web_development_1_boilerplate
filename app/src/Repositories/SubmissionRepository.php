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
            'developer',
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

    public function getPendingSubmissions(): array
    {
        $sql = "
        SELECT *
        FROM submissions
        WHERE status = 'pending'
        ORDER BY created_at DESC
    ";

        $statement = $this->pdo->query($sql);

        return $statement->fetchAll();
    }

    public function updateSubmissionStatus(int $submissionId, string $status, int $reviewedBy): void
    {
        $sql = "
        UPDATE submissions
        SET status = :status,
            reviewed_by = :reviewed_by,
            reviewed_at = NOW(),
            updated_at = NOW()
        WHERE submission_id = :submission_id
    ";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':status' => $status,
            ':reviewed_by' => $reviewedBy,
            ':submission_id' => $submissionId,
        ]);
    }
}