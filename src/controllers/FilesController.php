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
	 	$dir = public_path('packages/bencavens/chief/assets/images');

	 	$uploader = new Uploader($dir);
	 	$filedata = $uploader->upload(\Input::file('file'));

	 	// Redactor specific return data
	 	$data = array(

	 		'filelink' 	=> asset('packages/bencavens/chief/assets/images/'.$filedata->filename),
	 		'title' 	=> $filedata->originalName

	 	);

	 	// Verify the uploaded file is indeed an image
	 	if(!is_image($data['filelink'])) return false;

	 	return stripslashes(json_encode($data));
	 }

	

}