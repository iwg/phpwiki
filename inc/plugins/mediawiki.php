<?php
function wiki_render_markup($title, $text)
{
  $html = $text."\n"; // ensure the last line ends
  $html = str_replace("\r\n", "\n", $html);
  $html = str_replace("\r", "\n", $html);
  
  // bold
  $html = preg_replace('/\'\'\'([^\'\n]+)\'\'\'/', '<b>${1}</b>', $html);
  // italic
  $html = preg_replace('/\'\'([^\'\n]+)\'\'?/', '<i>${1}</i>', $html);
  
  // TODO process image and file links here so internal links can have namespace colons (:)
  
  // internal links with text
  $html = preg_replace_callback('/\[\[([^|\n\]]+)[|]([^|\n\]]+)\]\]/', 'wiki_render_internal_link_with_text', $html);
  // internal links without text
  $html = preg_replace_callback('/\[\[([^|\n\]]+)\]\]/', 'wiki_render_internal_link_without_text', $html);
  
  // headings
	for ($i = 6; $i >= 2; $i--) {
		$html = preg_replace(
			'/[=]{'.$i.'}([^=]+)[=]{'.$i.'}\n(\n+)/',
			'<h'.$i.'>${1}</h'.$i.'>${2}',
			$html
		);
	}
	
	// natural line breaks
	$html = preg_replace('/\n\n+/', "\n<br/>\n", $html);
	
	// lists
	$html = preg_replace('/((^\s*[*#]+[^\n]*$\n)+)/m', '<pre>${1}</pre>', $html);
	// TODO change them to real lists
	
	// horizontal rule
	$html = preg_replace('/----/', '<hr/>', $html);
	
	// remove redundant line breaks
	$html = preg_replace('/[>]<br\/>([\n]?)[<]/', '>${1}<', $html);
  
  return $html;
}

function wiki_render_internal_link_with_text($matches)
{
  $path = $matches[1];
  $target = SITE_BASE.'/'.$path;
  $text = $matches[2];
  return '<a href="'.$target.'">'.$text.'</a>';
}

function wiki_render_internal_link_without_text($matches)
{
  $path = $matches[1];
  $target = SITE_BASE.'/'.$path;
  return '<a href="'.$target.'">'.$path.'</a>';
}
