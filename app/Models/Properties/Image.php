<?php

namespace App\Models\Properties;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use InterventionImage;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    /**
     * Takes a file from a HTTP request and will store it onto the disk.
     *
     * @param string $diskName
     * @param file $file
     *
     * @return string
     */
    public function saveWithFile($file)
    {
        $filename = md5($file->getClientOriginalName() . microtime()) . '.' . $file->getClientOriginalExtension();

        $date = Carbon::now('utc');

        $year = $date->year;
        $month = $date->month;
        $day = $date->day;

        Storage::disk(env('PROPERTY_IMAGE_DISK'))->put($year.'/'.$month.'/'.$day.'/'.$filename, File::get($file));

        $prefix = Storage::disk(env('PROPERTY_IMAGE_DISK'))->getDriver()->getAdapter()->getPathPrefix();
        $path = $year.'/'.$month.'/'.$day.'/'.$filename;

        $img = InterventionImage::make($prefix . $path)
            ->fit(1920, 1080)
            ->orientate()
            ->save();

        // Set properties to model
        $this->filename = $file->getClientOriginalName();
        $this->filepath = $path;
        $this->mime_type = $file->getClientMimeType();
        $this->save();

        return $path;
    }

    /**
     * Takes a disk name and file path to determine if it exists on the server.
     *
     * @param string $diskName
     * @param string $path
     *
     * @return boolean
     */
    public static function exists($path)
    {
        return Storage::disk(env('IMAGE_DISK'))->exists($path);
    }

    /**
     * Takes a disk name and file path and returns the associated file on the server
     *
     * @param string $diskName
     * @param string $path
     *
     * @return file
     */
    public static function get($path)
    {
        return Storage::disk(env('IMAGE_DISK'))->get($path);
    }
}
