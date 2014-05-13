<?php

/**
* --------------------------------------------------------------------------
* Helper: Teaser
* --------------------------------------------------------------------------
*
* Short version of string
* 
*
*/
if(!function_exists('chiefteaser'))
{
	function chiefteaser($text,$max = null,$ending = null,$clean = true)
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

/**
* --------------------------------------------------------------------------
* Helper: cleanupHTML
* --------------------------------------------------------------------------
*
* Takes an input and cleans up unwanted / malicious HTML
* 
*
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

/**
* --------------------------------------------------------------------------
* Helper: is_image
* --------------------------------------------------------------------------
*
* Verifies an image is really an image. 
* credits: http://imperavi.com/redactor/docs/security/
*
* @return bool
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
 * Display status label for both posts as users
 * --------------------------------------------------------------------------
 *
 * @param   string 		$label
 * @param 	string 		$type - override autotype
 * @param 	bool 		$dot - show as dot or as full label
 * @return  string
 */
if(!function_exists('showStatus'))
{
	function showStatus($label = null, $type = null,$dot = false)
	{
		if(empty($label)) return '';

		if(is_null($type))
		{
			switch($label)
			{
				case 'draft':
				case 'pending':
					$type = 'warning';
				break;
				case 'archived':
				case 'denied':
					$type = 'danger';
				break;
				case 'published':
				case 'approved':
					$type = 'success';
				break;
				default: 
					$type = 'default';
				break;
			}
		}

		if($dot)
		{
			return '<span class="label label-dot label-'.$type.' tooltip-trigger" data-toggle="tooltip" data-placement="right" title="'.$label.'">&nbsp;</span>';
		}

		return '<span class="label label-'.$type.'">'.$label.'</span>';
	}
}

/**
 * --------------------------------------------------------------------------
 * Display status label as a dot
 * --------------------------------------------------------------------------
 *
 * @param   string 		$label
 * @param 	string 		$type - override autotype
 * @return  string
 */
if(!function_exists('showStatusDot'))
{
	function showStatusDot($label = null, $type = null)
	{
		return showStatus($label,$type,true);
	}
}


/**
 * --------------------------------------------------------------------------
 * Unique slug checker
 * --------------------------------------------------------------------------
 *
 * Makes sure the value is unique and appends a numeric value to make sure it does
 *
 * @param   string   		$slug
 * @param   BaseRepository  $repository class
 * @param   BaseModel 		$resource
 * @return  string
 */
if(!function_exists('unique_slug'))
{
	function unique_slug($slug,\Bencavens\Chief\Core\BaseRepository $repository,\Bencavens\Chief\Core\BaseModel $resource = null)
	{
		$i = 1;

		// We must have the getBySlug method on our repository
		if(!method_exists($repository,'getBySlug'))
		{
			throw new \Exception('Unique_slug helper method requires the repository method getBySlug');
		}

		while($i > 0)
		{
			// Check if slug is unique
			$record = $repository->getBySlug((string)$slug);

			if(!is_null($record))
			{
				if(is_null($resource) or ($record->id != $resource->id))
				{
					$slug = $slug.$i++;
					continue;
				}
			} 
			
			$i = 0;
		}

		return $slug;
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

/**
 * Format a datetime to a given format
 * 
 * @return 	string
 */
if(!function_exists('datetime'))
{
	function datetime($format,$datetime = null,$original_format = null)
	{
		// Default is today
		if(is_null($datetime))
		{
			$datetime = date('Y-m-d H:i:s');
		}		

		if(!is_null($original_format))
		{
			$dt = \DateTime::createFromFormat($original_format,$datetime);
			
			return false != $dt ? $dt->format($format) : null;
		}

		return date($format,strtotime($datetime));
	}
}
