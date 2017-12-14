<?php

namespace App;

use App\Job;
use Illuminate\Http\File;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inventory_id',
        'inventory_item_id',
        'primary',
        'featured',
        'featured_src',
        'img_src',
        'ordered'
    ];

    public function prepareVariableInventoryItems($data)
    {
    	$variable = [];
        $job = new Job();
    	if(count($data) > 0) {
    		foreach ($data as $key => $value) {
    			$variable[$key] = [
    				'primary' => $value->primary,
    				'primary_name' => "primary_image[{$key}]",
    				'src' => asset(str_replace('public/','storage/',$value->img_src)),
    				'name' => $job->stringToDotDotDot(str_replace('public/inventory_items/', '', $value->img_src)),
                    'old'=>true,
                    'old_id'=>$value->id,
                    'old_name_old'=>"old_image[{$key}][old]",
                    'old_name_id' =>"old_image[{$key}][id]"
    			];
    		}
    	}

    	return $variable;
    }
    /**
     * Resizes image and sends it to tmp file
     *
     * @return path to tmp image (public/tmp)
     */
    public function resize($file, $width, $height)
    {
        // resize regular images to 480x480 and then save it to db
        $resize = \Intervention::make($file);
        $resize->resize($width,$height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $resize_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$file->getClientOriginalExtension();

        // Check to see if tmp file exists
        if(!is_dir(public_path('tmp'))) {
            
            // path does not exist so create it

            Storage::makeDirectory('public/tmp');
        }
        $resize->save(public_path("storage/tmp/{$resize_name}"));
        $saved_image_uri = "{$resize->dirname}/{$resize->basename}";
        $resize->destroy();
        return $saved_image_uri;

    }

    /**
     * Crop image and sends it to tmp file
     *
     * @return path to tmp image (public/tmp)
     */
    public function crop($file, $width, $height, $x = null, $y = null)
    {
        // crop regular images to 480x480 and then save it to db
        $crop = \Intervention::make($file);
        $crop->crop($width,$height, $x, $y);
        $crop_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$file->getClientOriginalExtension();

        // Check to see if tmp file exists
        if(!is_dir(public_path('tmp'))) {
            
            // path does not exist so create it

            Storage::makeDirectory('public/tmp');
        }
        $crop->save(public_path("storage/tmp/{$crop_name}"));
        $saved_image_uri = "{$crop->dirname}/{$crop->basename}";
        $crop->destroy();
        return $saved_image_uri;

    }
}
