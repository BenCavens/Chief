<?php

/*
|--------------------------------------------------------------------------
| Helper: Teaser
|--------------------------------------------------------------------------
|
| Short version of string
| 
|
*/
if(!function_exists('teaser'))
{
	function teaser($text,$max = null,$ending = null,$clean = true)
	{
		if(is_null($max) or is_string($max)) return $text;

		if($clean)
		{
			$text = cleanupHTML($text);
		}

		$teaser = substr($text,0,$max);

		return strlen($text) <= $max ? $teaser : $teaser . $ending;
	}
}

/*
|--------------------------------------------------------------------------
| Helper: cleanupHTML
|--------------------------------------------------------------------------
|
| Takes an input and cleans up unwanted / malicious HTML
| 
|
*/

if(!function_exists('cleanupHTML'))
{
	function cleanupHTML( $value )
	{
		// Strip entire blocks of malicious code
		$value = preg_replace(array(
			'@<script[^>]*?>.*?</script>@si',
			'@onclick=[^ ].*? @si'
		),'',$value);

		// strip unwanted tags via whitelist...
		$value = strip_tags($value, '<code><span><div><label><a><br><p><b><i><del><strike><u><img><video><audio><iframe><object><embed><param><blockquote><mark><cite><small><ul><ol><li><hr><dl><dt><dd><sup><sub><big><pre><code><figure><figcaption><strong><em><table><tr><td><th><tbody><thead><tfoot><h1><h2><h3><h4><h5><h6>');
		
		// cleanup HTML and any unwanted attributes
		$value = htmLawed($value);

		return $value;
	}
}

/*
|--------------------------------------------------------------------------
| Helper: is_image
|--------------------------------------------------------------------------
|
| Verifies an image is really an image. 
| credits: http://imperavi.com/redactor/docs/security/
|
| @return bool
*/
if(!function_exists('is_image'))
{
	function is_image($image_path)
	{
	    if (!$f = fopen($image_path, 'rb')){ return false; }

	    $data = fread($f, 8);
	    
	    fclose($f);

	    // signature checking
	    $unpacked = unpack("H12", $data);
	    if (array_pop($unpacked) == '474946383961' || array_pop($unpacked) == '474946383761') return "gif";
	    $unpacked = unpack("H4", $data);
	    if (array_pop($unpacked) == 'ffd8') return "jpg";
	    $unpacked = unpack("H16", $data);
	    if (array_pop($unpacked) == '89504e470d0a1a0a') return "png";

	    return false;
	}
}


/**
 * --------------------------------------------------------------------------
 * Array_pair
 * --------------------------------------------------------------------------
 *
 * Constructs a flattened array from multidimensional array 
 * constructed by choses two keys as key->value pair.
 * 
 * 9/12/2013: 	change array_pluck to array_fetch to support flattened dot notation for subarrays
 * 18/04/2014 	convert Collection to raw array
 * 
 * @param   array 
 * @param   string   $value
 * @param   string   $key
 * @return  array
 */
if(!function_exists('array_pair'))
{
	function array_pair($array,$value,$key = null)
	{
		// Convert baserecords to raw array first
		if($array instanceof \Illuminate\Database\Eloquent\Collection )
		{
			$array = $array->toArray();
		}

		// Convert objects to array
		$array = (array) $array;

		if(empty($array)) return $array;

		$values = array_fetch($array,$value);

		if(!is_null($key))
		{
			$keys = array_fetch($array,$key);
			
			return array_combine($keys,$values);
		}

		return $values;
	}
}
