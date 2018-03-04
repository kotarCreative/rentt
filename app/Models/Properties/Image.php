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
     * Using a year, month and day, it will ensure the correct directories exist
     * on the disk. If they do not, it will create the directories.
     *
     * The directory structure for the disk will look like this: Year -> Month -> Day
     *
     * @param string $diskName
     * @param string $year
     * @param string $month
     * @param string $day
     *
     * @return void
     */
    public static function checkDirectories($year, $month, $day)
    {
        /* Check for year directory */
        if (!Storage::disk(env('IMAGE_DISK'))->exists($year)) {
            Storage::disk(env('IMAGE_DISK'))->makeDirectory($year);
        }

        /* Check for 'year -> month' directory */
        if (!Storage::disk(env('IMAGE_DISK'))->exists($year.'/'.$month)) {
            Storage::disk(env('IMAGE_DISK'))->makeDirectory($year.'/'.$month);
        }

        /* Check for 'year -> month -> day' directory */
        if (!Storage::disk(env('IMAGE_DISK'))->exists($year.'/'.$month.'/'.$day)) {
            Storage::disk(env('IMAGE_DISK'))->makeDirectory($year.'/'.$month.'/'.$day);
        }
    }

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

        Image::checkDirectories(env('IMAGE_DISK'), $year, $month, $day);
        Storage::disk(env('IMAGE_DISK'))->put($year.'/'.$month.'/'.$day.'/'.$filename, File::get($file));

        $path = $year.'/'.$month.'/'.$day.'/'.$filename;

        $img = InterventionImage::make(storage_path(env('IMAGE_ROOT')) . $path)
                ->resize(1920, 1080, function($c) {
                    $c->upsize();
                })
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
