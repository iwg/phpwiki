<?php
function wiki_render_markup($title, $text)
{
  $html = $text."\n"; // ensure the last line ends
  $html = str_replace("\r\n", "\n", $html);
  $html = str_replace("\r", "\n", $html);
  
  $html = wiki_remove_unsupported($html);
  
  $html = wiki_escape_markdown($html);
  $html = wiki_escape_nowiki0($html);
  $html = wiki_escape_nowiki($html);
  $html = wiki_escape_pre($html);
  $html = wiki_escape_syntaxhighlight($html);
  
  $html = wiki_convert_tables($html); 
  $html = wiki_simple_text($html);

  $html = wiki_unescape_syntaxhighlight($html);
  $html = wiki_unescape_pre($html);
  $html = wiki_unescape_nowiki($html);
  $html = wiki_unescape_nowiki0($html);
  $html = wiki_unescape_markdown($html);
  
  return $html;
}

function wiki_escape_markdown($html)
{
  return preg_replace_callback('/\<markdown\>(.+?)\<\/markdown\>/s', 'wiki_render_markdown', $html);
}

function wiki_unescape_markdown($html)
{
  return preg_replace_callback('/{{markdown,(\d+)}}/s', 'wiki_do_map_markdown', $html);
}

function wiki_do_map_markdown($matches)
{
  return wiki_render_markdown($matches, true);
}

function wiki_render_markdown($matches, $do_map = false)
{
  static $md_maps = array();
  if (isset($do_map) and $do_map === true) {
    return Markdown($md_maps[$matches[1]]);
  }
  $next_index = count($md_maps);
  $md_maps[] = $matches[1];
  return "{{markdown,".$next_index."}}";
}

function wiki_escape_nowiki0($html)
{
  return preg_replace('/\<nowiki\s*\/\>/s', '{{nowiki0}}', $html);
}

function wiki_unescape_nowiki0($html)
{
  return preg_replace('/{{nowiki0}}/s', '', $html);
}

function wiki_escape_nowiki($html)
{
  return preg_replace_callback('/\<nowiki\>(.+?)\<\/nowiki\>/s', 'wiki_render_nowiki', $html);
}

function wiki_unescape_nowiki($html)
{
  return preg_replace_callback('/{{nowiki,(\d+)}}/s', 'wiki_do_map_nowiki', $html);
}

function wiki_do_map_nowiki($matches)
{
  return wiki_render_nowiki($matches, true);
}

function wiki_render_nowiki($matches, $do_map = false)
{
  static $nowiki_maps = array();
  if (isset($do_map) and $do_map === true) {
    return $nowiki_maps[$matches[1]];
  }
  $next_index = count($nowiki_maps);
  $nowiki_maps[] = htmlspecialchars_decode($matches[1]);
  return "{{nowiki,".$next_index."}}";
}

function wiki_escape_pre($html)
{
  return preg_replace_callback('/\<pre\>(.+?)\<\/pre\>/s', 'wiki_render_pre', $html);
}

function wiki_unescape_pre($html)
{
  return preg_replace_callback('/{{pre,(\d+)}}/s', 'wiki_do_map_pre', $html);
}

function wiki_do_map_pre($matches)
{
  return "<pre>\n".htmlentities(wiki_unescape_nowiki(wiki_render_pre($matches, true)))."</pre>\n";
}

function wiki_render_pre($matches, $do_map = false)
{
  static $pre_maps = array();
  if (isset($do_map) and $do_map === true) {
    return $pre_maps[$matches[1]];
  }
  $next_index = count($pre_maps);
  $pre_maps[] = htmlspecialchars_decode($matches[1]);
  return "{{pre,".$next_index."}}\n";
}

function wiki_remove_unsupported($html)
{
  $html = preg_replace('/{{[^}]+}}/', '', $html);
  return $html;
}

function wiki_escape_syntaxhighlight($html)
{
  return preg_replace_callback('/\<syntaxhighlight lang="(.+?)"\>(.+?)\<\/syntaxhighlight\>/s', 'wiki_render_syntaxhighlight', $html);
}

function wiki_unescape_syntaxhighlight($html)
{
  return preg_replace_callback('/{{syntaxhighlight,(\d+)}}/s', 'wiki_do_map_syntaxhighlight', $html);
}

function wiki_do_map_syntaxhighlight($matches)
{
  return wiki_render_syntaxhighlight($matches, true);
}

function wiki_render_syntaxhighlight($matches, $do_map = false)
{
  static $syntaxhighlight_maps = array();
  if (isset($do_map) and $do_map === true) {
    return '<pre lang='.$syntaxhighlight_maps[$matches[1]].'">'.htmlentities($syntaxhighlight_maps[$matches[1]+1]).'</pre>'."\n";
  }
  $next_index = count($syntaxhighlight_maps);
  $syntaxhighlight_maps[] = $matches[1];
  $syntaxhighlight_maps[] = htmlspecialchars_decode($matches[2]);
  return "{{syntaxhighlight,".$next_index."}}\n";
}

function wiki_simple_text($html)
{
  // bold
  $html = preg_replace('/\'\'\'([^\'\n]+)\'\'\'/', '<b>${1}</b>'."<br/>", $html);
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
      '<h'.$i.'>${1}</h'.$i.'>${2}'."\n",
      $html
    );
  }
  
  // natural line breaks
  $html = preg_replace('/\n\n+/', "\n<br/>\n", $html);
  
  // lists
  ////$html = preg_replace_callback('/((^[*#;:\s]+[^\n]*$\n)+)/m', 'wiki_render_lists', $html);
  $html = preg_replace_callback('/((^[*#;:\s]*[*#;:]+[^\n]*$\n)+)/m', 'wiki_render_lists', $html);
  
  // horizontal rule
  $html = preg_replace('/----\s*\n/', '<hr/>'."\n", $html);
  
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
  $lines = explode("\n", $text);
  $intable = false;
  foreach ($lines as $line) {
    $line = trim($line);
    if (substr($line, 0, 2) == '{|') {
      // begin of the table
      $stuff = substr($line, 2);
      $tableopen = true;
      $table = "<table ".trim($stuff).">\n\t<tr>\n";
      $rowopen = true;
    } else if (substr($line, 0, 1) == '|') {
      // table related
      $line = substr($line,1);
      if (preg_match('/[-]+/', $line)) {
        // row break
        if ($thopen) $table .="</th>\n";
        if ($tdopen) $table .="</td>\n";
        if ($rowopen) $table .="\t</tr>\n";
        $table .= "\t<tr>\n";
        $rowopen = true;
        $tdopen = false;
        $thopen = false;
      } else if (substr($line, 0, 1) == '}') {
        // table end
        break;
      } else {
        // td
        if ($thopen) $table .="</th>\n";
        if ($tdopen) $table .="</td>\n";
        $stuff = explode('|', $line, 2);
        if (count($stuff) == 1) {
          $table .= "\t\t<td>\n".wiki_simple_text($stuff[0]);
        } else {
          $table .= "\t\t<td ".trim($stuff[0]).">".wiki_simple_text($stuff[1]);
        }
        $tdopen = true;
      }
    } else if (substr($line, 0, 1) == '!') {
      // th
      if ($thopen) $table .="</th>\n";
      if ($tdopen) $table .="</td>\n";
      $stuff = explode('|', substr($line, 1), 2);
      if (count($stuff) == 1) {
        $table .= "\t\t<th>".wiki_simple_text($stuff[0]);
      } else {
        $table .= "\t\t<th ".trim($stuff[0]).">".wiki_simple_text($stuff[1]);
      }
      $thopen = true;
    } else {
      // plain text
      $table .= wiki_simple_text($line)."\n";
    }
  }
  if ($thopen) $table .="</th>\n";
  if ($tdopen) $table .="</td>\n";
  if ($rowopen) $table .="\t</tr>\n";
  if ($tableopen) $table .="</table>\n";
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
  $f = 0;
  while ($i <= count($lines)) {
    if ($i < count($lines) and ($lines[$i][0] == '*' or $lines[$i][0] == '#')) {
      $sublines = array();
      $j = $i;
      while ($j < count($lines) and ($lines[$j][0] == '*' or $lines[$j][0] == '#')) {
        $sublines[] = $lines[$j];
        $j++;
      }
      if ($f == 0) {
        $html .= '<li>';
        $f = 1;
      }
      $html .= wiki_render_lists_lines($sublines).'</li>';
      $f = 0;
      $i = $j;
    } else if ($i < count($lines) and $lines[$i][0] == ';') {
      $sublines = array();
      $j = $i;
      while ($j < count($lines) and $lines[$j][0] == ';') {
        $sublines[] = $lines[$j];
        $j++;
      }
      if ($f == 0) {
        $html .= '<dt>';
        $f = 1;
      }
      $html .= wiki_render_lists_lines($sublines).'</dt>';
      $f = 0;
      $i = $j;
    } else if ($i < count($lines) and $lines[$i][0] == ':') {
      $sublines = array();
      $j = $i;
      while ($j < count($lines) and $lines[$j][0] == ':') {
        $sublines[] = $lines[$j];
        $j++;
      }
      if ($f == 0) {
        $html .= '<dd>';
        $f = 1;
      }
      $html .= wiki_render_lists_lines($sublines).'</dd>';
      $f = 0;
      $i = $j;
    } else {
      if ($char == ';') {
        if ($f == 0) {
          if ($i < count($lines)) {
            $html .= '<dt>'.$lines[$i];
            $f = 1;
          }
        } else {
          $html .= '</dt>';
          if ($i < count($lines)) {
            $html .= '<dt>'.$lines[$i];
            $f = 1;
          } else {
            $f = 0;
          }
        }      
      } else if ($char == ':') {
        if ($f == 0) {
          if ($i < count($lines)) {
            $html .= '<dd>'.$lines[$i];
            $f = 1;
          }
        } else {
          $html .= '</dd>';
          if ($i < count($lines)) {
            $html .= '<dd>'.$lines[$i];
            $f = 1;
          } else {
            $f = 0;
          }
        }      
      } else {
        if ($f == 0) {
          if ($i < count($lines)) {
            $html .= '<li>'.$lines[$i];
            $f = 1;
          }
        } else {
          $html .= '</li>';
          if ($i < count($lines)) {
            $html .= '<li>'.$lines[$i];
            $f = 1;
          } else {
            $f = 0;
          }
        }  
      }
      $i++;
    }
  }
  if ($char == '*') {
    return '<ul>'.$html.'</ul>';
  } else if($char == '#') {
    return '<ol>'.$html.'</ol>';
  } else if($char == ';' or $char == ':') {
    return '<dl>'.$html.'</dl>';
  }
}
 
