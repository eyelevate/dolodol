<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instagram extends Model
{
    //
    public function getFeed($count)
    {
    	$instagram = $this->authenticate();
    	$grab = [];
    	if ($instagram) {
    		try {
	            $feed = $instagram->getPopularFeed();
	            // The getPopularFeed() has an "items" property, which we need.
	            $items = $feed->getItems();
	            if (count($items) > 0) {
	            	foreach ($items as $key => $value) {
	            		if($items[$key]->getImageVersions2() !== null) {
	            			$count--;
	            			if ($count >= 0){
	            				array_push($grab, $items[$key]->getImageVersions2()->getCandidates()[0]->getUrl());
	            			}
	            			
	            		}
	            	}
	            }

	            return ['status'=>true,'data'=>$grab];
	            
	        } catch (\Exception $e) {
	        	return ['status'=>false,'data'=>$e->getMessage()];
	            
	            
	        }
    	} else {
    		return ['status'=>false,'data'=>'Could not log you into Instagram. Please update your authentication.'];
    	}
        
    }

    public function getTimelineFeed($count)
    {
    	$instagram = $this->authenticate();
    	$grab = [];
    	if ($instagram) {
    		try {
	            $feed = $instagram->getTimelineFeed();
	            // The getPopularFeed() has an "items" property, which we need.
	            $items = $feed->getFeedItems();
	            
	            if (count($items) > 0) {
	            	foreach ($items as $key => $value) {
	            		$gcm = $items[$key]->getCarouselMedia();
	            		if($gcm !== null) {
	            			$count--;
	            			if ($gcm[0]->image_versions2 !== null) {
	            				$img_src = $gcm[0]->image_versions2->candidates[0]->url;
								if ($count >= 0 ){
									array_push($grab, $img_src);
								}
	            			}
	            			
	            			
	            		}
	            	}
	            }

	            return ['status'=>true,'data'=>$grab];
	            
	        } catch (\Exception $e) {
	        	return ['status'=>false,'data'=>$e->getMessage()];
	            
	            
	        }
    	} else {
    		return ['status'=>false,'data'=>'Could not log you into Instagram. Please update your authentication.'];
    	}
        
    }
    /**
    * @param $count = number of images i want to display
    * @param $image_type 0 = original size, 1 = squared size
    * @param $video_type 1 = original type, 2 = mp4
    **/
    public function getUserFeed($count, $image_type = 1, $video_type = 2)
    {
    	$instagram = $this->authenticate();
    	$grab = [];
    	if ($instagram) {
    		try {

	            $feed = $instagram->timeline->getUserFeed($instagram->account_id);
	            // The getPopularFeed() has an "items" property, which we need.
	            $items = $feed->fullResponse->items;
	            // dd($items);
	            if ($feed->num_results > 0) {
	            	foreach ($items as $value) {
	            		$type = $value->media_type;
	            		// $caption = (isset($caption)) ? $value->caption->text : 'Empty Caption';
	            		$caption = ($value->caption->text) ? $value->caption->text : 'Empty Caption';


	            		$truncated_caption = (strlen($caption) > 50) ? substr($caption, 0, 50) . '...' : $caption;

	            		if ($count > 0){
	            			switch ($type) {
		            			case 1: // Image
		            				$count--;
		            				$src = $value->image_versions2->candidates[$image_type]->url;
		            				array_push($grab, ['type'=>1,'src'=>$src,'caption'=>$truncated_caption]);
		            				break;

		            			case 2: // Video
		            				$count--;
		            				$src = $value->video_versions[$video_type]->url;
		            				array_push($grab, ['type'=>2,'src'=>$src,'caption'=>$truncated_caption]);
		            				break;
		            			case 8: // Group of images
		            				$cm = $value->carousel_media;
		            				if (count($cm) > 0) {
		            					foreach ($cm as $media) {
		            						$count--;
		            						$src = $media->image_versions2->candidates[$image_type]->url;
		            						array_push($grab, ['type'=>1,'src'=>$src,'caption'=>$truncated_caption]);
		            						break;
		            					}
		            				}
		            				break;
		            			default:
		            				# code...
		            				break;
		            		}
	            		} else {
	            			break;
	            		}
	            	}
	            }


	            return ['status'=>true,'data'=>$grab];
	            
	        } catch (\Exception $e) {
	        	return ['status'=>false,'data'=>$e->getMessage()];
	            
	            
	        }
    	} else {
    		return ['status'=>false,'data'=>'Could not log you into Instagram. Please update your authentication.'];
    	}
        
    }

    private function authenticate()
    {
    	$debug = false;
        $truncatedDebug = false;
        $instagram = new \InstagramAPI\Instagram($debug,$truncatedDebug);
        // dd($instagram);
        try {
            // $instagram->setUser(env('INSTAGRAM_USERNAME'),env('INSTAGRAM_PASSWORD'));
            $instagram->login(env('INSTAGRAM_USERNAME'),env('INSTAGRAM_PASSWORD'));
        } catch (Exception $e) {
            return false;
        }

        return $instagram;
    }
}
