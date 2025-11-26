<?php

namespace App\Modules\Gallery\Repositories;

use App\Models\Gallery;
use App\Models\Project;
use App\Modules\Shared\Repositories\BaseRepository;

class GalleryRepository extends BaseRepository
{
    public function __construct(private Gallery $model)
    {
        parent::__construct($model);
    }


    public function createMedia($model, $Id, array $mediaFiles, string $type) {

    $mediaData = [];

    foreach ($mediaFiles as $file) {
        if (!is_string($file)) {
            continue;
        }
        $mediaData[] = [
            'parent_id'   => $Id,
            'parent_type' => $model,
            'url'            => $file,
            'type'           => $type,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }

    if (!empty($mediaData)) {
        return Gallery::insert($mediaData);
    }

        return false;
    }

    public function updateMedia($model, $Id, array $mediaFiles, string $type) {
        Gallery::where('parent_id', $Id)
            ->where('parent_type', $model)
            ->where('type', $type)
            ->delete();

        return $this->createMedia($model, $Id, $mediaFiles, $type);
    }

    public function createOneMedia($model, $Id, $mediaFile, string $type) {

        $mediaData = [
            'parent_id'   => $Id,
            'parent_type' => $model,
            'url'            => $mediaFile,
            'type'           => $type,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        return $this->create($mediaData);

    }
}
