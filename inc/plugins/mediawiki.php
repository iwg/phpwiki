<?php
function wiki_render_markup($title, $text)
{
  $html = $text."\n"; // ensure the last line ends
  $html = str_replace("\r\n", "\n", $html);
  $html = str_replace("\r", "\n", $html);
  
  $html = wiki_convert_tables($html);
  $html = wiki_simple_text($html);
  
  return $html;
}

function wiki_simple_text($html)
{
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
      '/[=]{'.$i.'}([^=]+)[=]{'.$i.'}\n(\n*)/',
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

function wiki_convert_tables($text)
{
  $lines = explode("\n", $text);
  $innertable = 0;
  $innertabledata = array();
  foreach ($lines as $line) {
    if (substr($line, 0, 2) == '{|') {
      // inner table
      $innertable++;
    }
    $innertabledata[$innertable] .= $line."\n";
    if ($innertable) {
      // we're inside
      if (substr($line, 0, 2) == '|}') {
        $innertableconverted = wiki_convert_table($innertabledata[$innertable]);
        $innertabledata[$innertable] = "";
        $innertable--;
        $innertabledata[$innertable] .= $innertableconverted."\n";
      }
    }
  }
  return $innertabledata[0];
}

function wiki_convert_table($text)
{
	$lines = explode("\n",$text);
	$intable = false;
	
	//var_dump($lines);
	foreach($lines as $line){
		$line = trim($line);
		if(substr($line,0,1) == '{'){
			//begin of the table
			$stuff = explode('| ',substr($line,1),2);
			$tableopen = true;
			$table = "<table ".$stuff[0].">\n";
		} else if(substr($line,0,1) == '|'){
			// table related
			$line = substr($line,1);
			if(substr($line,0,5) == '-----'){
				// row break
				if($thopen)
					$table .="</th>\n";
				if($tdopen)
					$table .="</td>\n";
				if($rowopen)
					$table .="\t</tr>\n";
				$table .= "\t<tr>\n";
				$rowopen = true;
				$tdopen = false;
				$thopen = false;
			}else if(substr($line,0,1) == '}'){
				// table end
				break;
			}else{
				// td
				$stuff = explode('| ',$line,2);
				if($tdopen)
					$table .="</td>\n";
				if(count($stuff)==1)
					$table .= "\t\t<td>".wiki_simple_text($stuff[0]);
				else
					$table .= "\t\t<td ".$stuff[0].">".
						wiki_simple_text($stuff[1]);
				$tdopen = true;
			}
		} else if(substr($line,0,1) == '!'){
			// th
			$stuff = explode('| ',substr($line,1),2);
			if($thopen)
				$table .="</th>\n";
			if(count($stuff)==1)
				$table .= "\t\t<th>".wiki_simple_text($stuff[0]);
			else
				$table .= "\t\t<th ".$stuff[0].">".
					wiki_simple_text($stuff[1]);
			$thopen = true;
		}else{
			// plain text
			$table .= wiki_simple_text($line) ."\n";
		}
		//echo "<pre>".++$i.": ".htmlspecialchars($line)."</pre>";
		//echo "<p>Table so far: <pre>".htmlspecialchars($table)."</pre></p>";
	}
	if($thopen)
		$table .="</th>\n";
	if($tdopen)
		$table .="</td>\n";
	if($rowopen)
		$table .="\t</tr>\n";
	if($tableopen)
		$table .="</table>\n";
	//echo "<hr />";
	//echo "<p>Table at the end: <pre>".htmlspecialchars($table)."</pre></p>";
	//echo $table;	
	return $table;
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
