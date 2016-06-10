<?php
namespace CommentSystem;

class TextFunctions 
{
	public static function convertURLToHref($t)
	{
		$pattern = '@(http)?(s)?(://)?(([a-zA-Z0-9])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
		if (preg_match($pattern, $t, $url)) {
			$t = preg_replace($pattern, '<a href="' . $url[0]. '" target="_blank">' . $url[0] . '</a>', $t);
		}
		
		return $t;
	}
}