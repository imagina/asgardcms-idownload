<?php

namespace Modules\Idownload\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Core\Traits\NamespacedEntity;
use Laracasts\Presenter\PresentableTrait;


class Download extends Model
{
    use Translatable, MediaRelation, NamespacedEntity, PresentableTrait;

    protected $table = 'idownload__downloads';

    public $translatedAttributes = [
        'title',
        'slug',
        'description',
        'translatable_options',
        'download_id',
    ];

    protected $fillable = [
        'category_id',
        'status',
        'options',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function suscriptors()
    {
        return $this->hasMany(Suscriptor::class);
    }

    /**
     * @return mixed
     */
    public function getDownloadFileAttribute()
    {

        $thumbnail = $this->files()->where('zone', 'downloadFile')->first();
        if (!$thumbnail) {
            return null;
        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string,
                'size' => $thumbnail->filesize
            ];
        }
        return json_decode(json_encode($image));

    }

    public function getMainImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'mainimage')->first();
        if (!$thumbnail) {

            $image = [
                'mimeType' => 'image/jpeg',
                'path' => url('modules/iblog/img/post/default.jpg')
            ];

        } else {
            $image = [
                'mimeType' => $thumbnail->mimetype,
                'path' => $thumbnail->path_string
            ];
        }
        return json_decode(json_encode($image));

    }

    public function getGalleryAttribute()
    {


        $gallery = $this->filesByZone('gallery')->get();
        $response = [];
        if(count($gallery)){
            foreach ($gallery as $img) {
                array_push($response, [
                    'mimeType' => $img->mimetype,
                    'path' => $img->path_string
                ]);
            }
        }

        return json_decode(json_encode($response));
    }

}
