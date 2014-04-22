<?php namespace Bencavens\Chief\Controllers;

use Illuminate\Routing\Controller;
use Bencavens\Chief\ChiefFacade as Chief;
use Bencavens\Chief\Services\Uploader;
use View,Redirect,Input,App;

class FilesController extends Controller{
	
	/**
	 * Upload an image
	 *
	 * @return Response
	 */
	 public function uploadImage()
	 {
	 	// Validation
	 	// Check if it is an image...

		
	 	//$path = $dir.'/'.$file;
	 	$dir = public_path('packages/bencavens/chief/assets/images');

	 	$uploader = new Uploader($dir);
	 	$filedata = $uploader->upload(\Input::file('file'));

	 	// Redactor specific return data
	 	$data = array(

	 		'filelink' => asset('packages/bencavens/chief/assets/images/'.$filedata->filename)

	 	);

	 	return stripslashes(json_encode($data));
	 }

	

}