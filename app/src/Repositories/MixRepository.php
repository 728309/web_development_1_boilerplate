<?php

namespace App\Repositories;

use App\Models\MixModel;
use PDO;

class MixRepository
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
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * @return MixModel[]
     */
    public function getAllPublicMixes(): array
    {
        $sql = '
            SELECT
                m.mix_id,
                m.artist_id,
                a.stage_name AS artist_name,
                m.title,
                m.slug,
                m.description,
                m.genre,
                m.tracklist,
                m.image_path,
                m.media_url,
                m.duration,
                m.is_featured,
                m.is_public,
                m.created_by_user_id,
                m.created_at,
                m.updated_at
            FROM mixes m
            INNER JOIN artists a ON a.artist_id = m.artist_id
            WHERE m.is_public = 1
            ORDER BY m.created_at DESC
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $rows = $statement->fetchAll();
        $mixes = [];

        foreach ($rows as $row) {
            $mixes[] = MixModel::fromArray($row);
        }

        return $mixes;
    }

    public function getPublicMixBySlug(string $slug): ?MixModel
    {
        $sql = '
            SELECT
                m.mix_id,
                m.artist_id,
                a.stage_name AS artist_name,
                m.title,
                m.slug,
                m.description,
                m.genre,
                m.tracklist,
                m.image_path,
                m.media_url,
                m.duration,
                m.is_featured,
                m.is_public,
                m.created_by_user_id,
                m.created_at,
                m.updated_at
            FROM mixes m
            INNER JOIN artists a ON a.artist_id = m.artist_id
            WHERE m.slug = :slug
              AND m.is_public = 1
            LIMIT 1
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':slug' => $slug,
        ]);

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return MixModel::fromArray($row);
    }

    /**
     * @return array<int, array{artist_id:int, stage_name:string}>
     */
    public function getAllArtists(): array
    {
        $sql = '
            SELECT artist_id, stage_name
            FROM artists
            ORDER BY stage_name ASC
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $rows = $statement->fetchAll();
        $artists = [];

        foreach ($rows as $row) {
            $artists[] = [
                'artist_id' => (int) $row['artist_id'],
                'stage_name' => (string) $row['stage_name'],
            ];
        }

        return $artists;
    }

    public function slugExists(string $slug): bool
    {
        $sql = '
            SELECT COUNT(*) 
            FROM mixes
            WHERE slug = :slug
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':slug' => $slug,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }

    public function createMix(
        int $artistId,
        string $title,
        string $slug,
        string $description,
        string $genre,
        ?string $tracklist,
        string $mediaUrl,
        ?int $duration,
        bool $isFeatured,
        int $createdByUserId
    ): int {
        $sql = '
            INSERT INTO mixes (
                artist_id,
                title,
                slug,
                description,
                genre,
                tracklist,
                image_path,
                media_url,
                duration,
                is_featured,
                is_public,
                created_by_user_id
            ) VALUES (
                :artist_id,
                :title,
                :slug,
                :description,
                :genre,
                :tracklist,
                :image_path,
                :media_url,
                :duration,
                :is_featured,
                :is_public,
                :created_by_user_id
            )
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':artist_id' => $artistId,
            ':title' => $title,
            ':slug' => $slug,
            ':description' => $description,
            ':genre' => $genre,
            ':tracklist' => $tracklist,
            ':image_path' => null,
            ':media_url' => $mediaUrl,
            ':duration' => $duration,
            ':is_featured' => $isFeatured ? 1 : 0,
            ':is_public' => 1,
            ':created_by_user_id' => $createdByUserId,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @return array<int, array{comment_id:int, username:string, content:string, created_at:string}>
     */
    public function getCommentsByMixId(int $mixId): array
    {
        $sql = '
            SELECT
                c.comment_id,
                u.username,
                c.content,
                c.created_at
            FROM comments c
            INNER JOIN users u ON u.user_id = c.user_id
            WHERE c.mix_id = :mix_id
              AND c.deleted = 0
            ORDER BY c.created_at DESC
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':mix_id' => $mixId,
        ]);

        $rows = $statement->fetchAll();
        $comments = [];

        foreach ($rows as $row) {
            $comments[] = [
                'comment_id' => (int) $row['comment_id'],
                'username' => (string) $row['username'],
                'content' => (string) $row['content'],
                'created_at' => (string) $row['created_at'],
            ];
        }

        return $comments;
    }

    public function createComment(int $mixId, int $userId, string $content): int
    {
        $sql = '
            INSERT INTO comments (
                mix_id,
                user_id,
                content
            ) VALUES (
                :mix_id,
                :user_id,
                :content
            )
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':mix_id' => $mixId,
            ':user_id' => $userId,
            ':content' => $content,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function getVoteCountsByMixId(int $mixId): array
    {
        $sql = '
        SELECT vote_type, COUNT(*) AS total
        FROM votes
        WHERE mix_id = :mix_id
        GROUP BY vote_type
    ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':mix_id' => $mixId,
        ]);

        $rows = $statement->fetchAll();

        $counts = [
            'likes' => 0,
            'dislikes' => 0,
        ];

        foreach ($rows as $row) {
            if ($row['vote_type'] === 'like') {
                $counts['likes'] = (int) $row['total'];
            }

            if ($row['vote_type'] === 'dislike') {
                $counts['dislikes'] = (int) $row['total'];
            }
        }

        return $counts;
    }

    public function saveVote(int $mixId, int $userId, string $voteType): void
    {
        $deleteSql = '
        DELETE FROM votes
        WHERE mix_id = :mix_id
          AND user_id = :user_id
    ';

        $deleteStatement = $this->pdo->prepare($deleteSql);
        $deleteStatement->execute([
            ':mix_id' => $mixId,
            ':user_id' => $userId,
        ]);

        $insertSql = '
        INSERT INTO votes (
            mix_id,
            user_id,
            vote_type,
            created_at,
            updated_at
        ) VALUES (
            :mix_id,
            :user_id,
            :vote_type,
            NOW(),
            NOW()
        )
    ';

        $insertStatement = $this->pdo->prepare($insertSql);
        $insertStatement->execute([
            ':mix_id' => $mixId,
            ':user_id' => $userId,
            ':vote_type' => $voteType,
        ]);
    }

    public function deleteVotesByMixId(int $mixId): void
    {
        $sql = ' DELETE FROM votes
                 WHERE mix_id = :mix_id';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':mix_id' => $mixId,
        ]);
    }

    public function deleteCommentsByMixId(int $mixId): void
    {
        $sql = "DELETE FROM comments
                WHERE mix_id = :mix_id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':mix_id' => $mixId,
        ]);
    }

    public function deleteMixById(int $mixId): void
    {
        $sql = "DELETE FROM mixes 
                WHERE mix_id = :mix_id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':mix_id' => $mixId,
        ]);
    }
}