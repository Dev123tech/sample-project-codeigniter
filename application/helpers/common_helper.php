<?php
if ( ! function_exists('s3_file_upload') ) {
	function s3_file_upload($path='',$fileName=''){
		$return = false;
		$ci = & get_instance(); 
		
		if(is_file($path)){
			$destination= 'uploads/mp4/'.$ci->current_user->id;
			if(!is_dir($destination)){
				mkdir($destination, 0777, true);
			}
			$destination.='/'.$fileName;
			


			$output = shell_exec ('ffmpeg -i "'.$path.'" -b 1500k -vcodec libx264 -vpre slow -vpre baseline -g 30 "'.$destination.'" 2>&1');
			if($output){
				$regex_duration = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
				if (preg_match($regex_duration, $output, $regs)) {
					$hours = $regs [1] ? $regs [1] : null;
					$mins = $regs [2] ? $regs [2] : null;
					$secs = $regs [3] ? $regs [3] : null;
					$ms = $regs [4] ? $regs [4] : null;
				}
				$duration = $hours.':'.$mins.':'.$secs;
				$tumb_image = generateRandomString().'.jpeg';
			
				
				
				$destination= 'uploads/'.$ci->current_user->id.'/video_thumb/'.$tumb_image;
				//ob_start();
				//$cmd = "/usr/bin/ffmpeg -y -i SampleVideo_1080x720_2mb.mp4 -deinterlace -an -s  75x75 -ss 00:00:00 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg aa.jpeg 2>&1";
				$cmd = "/usr/bin/ffmpeg -y -i $path -deinterlace -an -ss 00:00:03 -t 00:00:04 -r 1 -y -vcodec mjpeg -f mjpeg $destination 2>&1";
				//passthru ($cmd);
				$output = shell_exec($cmd);   


				$return =  array('duration'=>$duration,'tumb_image'=> $tumb_image);
				
				/*echo "<pre>";
				print_r($output);
				echo "</pre>"; die;*/
				
			}
		}else{
			echo "fiel not found"; die;
		}
		
		return $return;
	}
}


if ( ! function_exists('get_video_duration') ) {
	function get_video_duration($path=''){
		$return = false;
		$ci = & get_instance();
		$destination = 'uploads/video_files/video_15_1.mp4';
		
		if(is_file($path)){
			

			$output = exec("ffmpeg -i ".$path." 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,//");

			//$output = shell_exec ('ffmpeg -i "'.$path.'" -b 1500k -vcodec libx264 -vpre slow -vpre baseline -g 30 "'.$destination.'" 2>&1');
			
			// print_r($output);		
				return $output ;
			}
		else{
			// echo $path;
			echo "fiel not found"; die;
		}
		
		return $return;
	}
}


if ( ! function_exists('crateVideoThumb') ) {
	function crateVideoThumb($source=''){
		$return = false;
		$ci = & get_instance();
		
		if(is_file($source)){
			    $filename = generateRandomString().'.jpeg';
			    $destination= 'uploads/'.$ci->current_user->id.'/video_thumb';
			    if(!is_dir($destination)){
					mkdir($destination, 0777, true);
				}
			    
			    
								
			    $destination= 'uploads/'.$ci->current_user->id.'/video_thumb/'.$filename;
				//ob_start();
				//$cmd = "/usr/bin/ffmpeg -y -i SampleVideo_1080x720_2mb.mp4 -deinterlace -an -s  75x75 -ss 00:00:00 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg aa.jpeg 2>&1";
				$cmd = "/usr/bin/ffmpeg -y -i $source -deinterlace -an -ss 00:00:03 -t 00:00:04 -r 1 -y -vcodec mjpeg -f mjpeg $destination 2>&1";
				//passthru ($cmd);
				$output = shell_exec($cmd);  
				if($output){
					$regex_duration = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
					if (preg_match($regex_duration, $output, $regs)) {
						$hours = $regs [1] ? $regs [1] : null;
						$mins = $regs [2] ? $regs [2] : null;
						$secs = $regs [3] ? $regs [3] : null;
						$ms = $regs [4] ? $regs [4] : null;
					}

				$duration = $hours.':'.$mins.':'.$secs;
				$return =  array('duration'=>$duration,'tumb_image'=> $filename);
			  }
				//ob_clean();
		}
		
		return $return;
	}
}

if ( ! function_exists('generateRandomString') ) {
	function generateRandomString($length = 8) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}

