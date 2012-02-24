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
	$html = preg_replace_callback('/((^[*#\s]+[^\n]*$\n)+)/m', 'wiki_render_lists', $html);
	
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

function wiki_preprocess_lists_lines($lines)
{
  foreach ($lines as $i => $line) {
    $lines[$i] = trim($line);
  }
  return array_filter($lines, 'strlen');
}

function wiki_segment_lists_lines($lines)
{
  $segments = array();
  if (empty($lines)) {
    return $segments;
  }
  $char = $lines[0][0];
  $segment = array();
  foreach ($lines as $line) {
    if ($line[0] == $char) {
      $segment[] = $line;
    } else {
      $segments[] = $segment;
      $char = $line[0];
      $segment = array($line);
    }
  }
  $segments[] = $segment;
  return $segments;
}

function wiki_render_lists($matches)
{
  $text = $matches[1];
  $lines = explode("\n", trim($text));
  $lines = wiki_preprocess_lists_lines($lines);
  return wiki_render_lists_lines($lines);
}

function wiki_render_lists_lines($lines)
{  
  $segments = wiki_segment_lists_lines($lines);
  $html = "";
  foreach ($segments as $segment) {
    $html .= wiki_render_list($segment);
  }
  return $html;
}

function wiki_render_list($lines)
{
  $char = $lines[0][0];
  foreach ($lines as $i => $line) {
    $lines[$i] = trim(substr($line, 1));
  }
  $html = "";
  $i = 0;
  while ($i < count($lines)) {
	if ($lines[$i][0] == '*' or $lines[$i][0] == '#') {
      $sublines = array();
      $j = $i;
      while ($j < count($lines) and ($lines[$j][0] == '*' or $lines[$j][0] == '#')) {
        $sublines[] = $lines[$j];
        $j++;
	  }
	  if($lines[0][0] == $char) {
		$html .= '<li>'.wiki_render_lists_lines($sublines).'</li>';
	  } else {
		$html .= wiki_render_lists_lines($sublines);
	  }
	  $i = $j;
    } else {
      $html .= '<li>'.$lines[$i].'</li>';
	  $i++;
    }
  }
  if ($char == '*') {
    return '<ul>'.$html.'</ul>';
  } else {
    return '<ol>'.$html.'</ol>';
  }
}
