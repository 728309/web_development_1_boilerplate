<?php

namespace App\Models;
class MixModel
{
    public int $mix_id;
    public int $artist_id;
    public string $artist_name;
    public string $title;
    public string $slug;
    public string $description;
    public string $genre;
    public ?string $tracklist;
    public ?string $image_path;
    public string $media_url;
    public ?int $duration;
    public bool $is_featured;
    public bool $is_public;
    public int $created_by_user_id;
    public string $created_at;
    public string $updated_at;

    public static function fromArray($row): self
    {
        $mix = new self();

        $mix->mix_id = (int) $row['mix_id'];
        $mix->artist_id = (int) $row['artist_id'];
        $mix->artist_name = (string) $row['artist_name'];
        $mix->title = (string) $row['title'];
        $mix->slug = (string) $row['slug'];
        $mix->description = (string) $row['description'];
        $mix->genre = (string) $row['genre'];
        $mix->tracklist = $row['tracklist'] !== null ? (string) $row['tracklist'] : null;
        $mix->image_path = $row['image_path'] !== null ? (string) $row['image_path'] : null;
        $mix->media_url = (string) $row['media_url'];
        $mix->duration = $row['duration'] !== null ? (int) $row['duration'] : null;
        $mix->is_featured = (bool) $row['is_featured'];
        $mix->is_public = (bool) $row['is_public'];
        $mix->created_by_user_id = (int) $row['created_by_user_id'];
        $mix->created_at = (string) $row['created_at'];
        $mix->updated_at = (string) $row['updated_at'];

        return $mix;
    }

}