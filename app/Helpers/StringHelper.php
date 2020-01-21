<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StringHelper
{


  //For Generating Unique Slug
  public static function createSlug($title, $model, $field, $separator = "-")
  {
    $model = 'App\Models\\' . $model;
    $id = 0;

    $slug =  preg_replace('/\s+/', $separator, (trim(strtolower($title))));
    $slug =  preg_replace('/\?+/', $separator, (trim(strtolower($slug))));
    $slug =  preg_replace('/\#+/', $separator, (trim(strtolower($slug))));
    $slug =  preg_replace('/\/+/', $separator, (trim(strtolower($slug))));

    // $slug = preg_replace('!['.preg_quote($separator).']+!u', $separator, $title);

    // // Remove all characters that are not the separator, letters, numbers, or whitespace.
    // $slug = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($slug));

    // // Replace all separator characters and whitespace by a single separator
    $slug = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $slug);


    // Get any that could possibly be related.
    // This cuts the queries down by doing it once.
    $allSlugs = StringHelper::getRelatedSlugs($slug, $id, $model, $field);
    // If we haven't used it before then we are all good.
    if (!$allSlugs->contains("$field", $slug)) {
      return $slug;
    }
    // Just append numbers like a savage until we find not used.
    for ($i = 1; $i <= 10; $i++) {
      $newSlug = $slug . $separator . $i;
      if (!$allSlugs->contains("$field", $newSlug)) {
        return $newSlug;
      }
    }
    throw new \Exception('Can not create a unique slug');
  }

  protected static function getRelatedSlugs($slug, $id = 0, $model, $field)
  {
    return $model::select("$field")->where("$field", 'like', $slug . '%')
      ->where('id', '<>', $id)
      ->get();
  }



  public static function advanceUTFStrSlug($title, $separator = '-')
  {
    // Convert all dashes/underscores into separator
    $flip = $separator == '-' ? '_' : '-';

    $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

    // Remove all characters that are not the separator, letters, numbers, or whitespace.
    $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', mb_strtolower($title));

    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

    return trim($title, $separator);
  }

  /**
   * Extract URLs from a web page.
   */
  public static function ExtractUrl($text)
  {
    $match_elements = array(
      // HTML
      array('element' => 'a',       'attribute' => 'href'),       // 2.0
      array('element' => 'a',       'attribute' => 'urn'),        // 2.0
      array('element' => 'base',    'attribute' => 'href'),       // 2.0
      array('element' => 'form',    'attribute' => 'action'),     // 2.0
      array('element' => 'img',     'attribute' => 'src'),        // 2.0
      array('element' => 'link',    'attribute' => 'href'),       // 2.0

      array('element' => 'applet',  'attribute' => 'code'),       // 3.2
      array('element' => 'applet',  'attribute' => 'codebase'),   // 3.2
      array('element' => 'area',    'attribute' => 'href'),       // 3.2
      array('element' => 'body',    'attribute' => 'background'), // 3.2
      array('element' => 'img',     'attribute' => 'usemap'),     // 3.2
      array('element' => 'input',   'attribute' => 'src'),        // 3.2

      array('element' => 'applet',  'attribute' => 'archive'),    // 4.01
      array('element' => 'applet',  'attribute' => 'object'),     // 4.01
      array('element' => 'blockquote', 'attribute' => 'cite'),     // 4.01
      array('element' => 'del',     'attribute' => 'cite'),       // 4.01
      array('element' => 'frame',   'attribute' => 'longdesc'),   // 4.01
      array('element' => 'frame',   'attribute' => 'src'),        // 4.01
      array('element' => 'head',    'attribute' => 'profile'),    // 4.01
      array('element' => 'iframe',  'attribute' => 'longdesc'),   // 4.01
      array('element' => 'iframe',  'attribute' => 'src'),        // 4.01
      array('element' => 'img',     'attribute' => 'longdesc'),   // 4.01
      array('element' => 'input',   'attribute' => 'usemap'),     // 4.01
      array('element' => 'ins',     'attribute' => 'cite'),       // 4.01
      array('element' => 'object',  'attribute' => 'archive'),    // 4.01
      array('element' => 'object',  'attribute' => 'classid'),    // 4.01
      array('element' => 'object',  'attribute' => 'codebase'),   // 4.01
      array('element' => 'object',  'attribute' => 'data'),       // 4.01
      array('element' => 'object',  'attribute' => 'usemap'),     // 4.01
      array('element' => 'q',       'attribute' => 'cite'),       // 4.01
      array('element' => 'script',  'attribute' => 'src'),        // 4.01

      array('element' => 'audio',   'attribute' => 'src'),        // 5.0
      array('element' => 'command', 'attribute' => 'icon'),       // 5.0
      array('element' => 'embed',   'attribute' => 'src'),        // 5.0
      array('element' => 'event-source', 'attribute' => 'src'),    // 5.0
      array('element' => 'html',    'attribute' => 'manifest'),   // 5.0
      array('element' => 'source',  'attribute' => 'src'),        // 5.0
      array('element' => 'video',   'attribute' => 'src'),        // 5.0
      array('element' => 'video',   'attribute' => 'poster'),     // 5.0

      array('element' => 'bgsound', 'attribute' => 'src'),        // Extension
      array('element' => 'body',    'attribute' => 'credits'),    // Extension
      array('element' => 'body',    'attribute' => 'instructions'), //Extension
      array('element' => 'body',    'attribute' => 'logo'),       // Extension
      array('element' => 'div',     'attribute' => 'href'),       // Extension
      array('element' => 'div',     'attribute' => 'src'),        // Extension
      array('element' => 'embed',   'attribute' => 'code'),       // Extension
      array('element' => 'embed',   'attribute' => 'pluginspage'), // Extension
      array('element' => 'html',    'attribute' => 'background'), // Extension
      array('element' => 'ilayer',  'attribute' => 'src'),        // Extension
      array('element' => 'img',     'attribute' => 'dynsrc'),     // Extension
      array('element' => 'img',     'attribute' => 'lowsrc'),     // Extension
      array('element' => 'input',   'attribute' => 'dynsrc'),     // Extension
      array('element' => 'input',   'attribute' => 'lowsrc'),     // Extension
      array('element' => 'table',   'attribute' => 'background'), // Extension
      array('element' => 'td',      'attribute' => 'background'), // Extension
      array('element' => 'th',      'attribute' => 'background'), // Extension
      array('element' => 'layer',   'attribute' => 'src'),        // Extension
      array('element' => 'xml',     'attribute' => 'src'),        // Extension

      array('element' => 'button',  'attribute' => 'action'),     // Forms 2.0
      array('element' => 'datalist', 'attribute' => 'data'),       // Forms 2.0
      array('element' => 'form',    'attribute' => 'data'),       // Forms 2.0
      array('element' => 'input',   'attribute' => 'action'),     // Forms 2.0
      array('element' => 'select',  'attribute' => 'data'),       // Forms 2.0

      // XHTML
      array('element' => 'html',    'attribute' => 'xmlns'),

      // WML
      array('element' => 'access',  'attribute' => 'path'),       // 1.3
      array('element' => 'card',    'attribute' => 'onenterforward'), // 1.3
      array('element' => 'card',    'attribute' => 'onenterbackward'), // 1.3
      array('element' => 'card',    'attribute' => 'ontimer'),    // 1.3
      array('element' => 'go',      'attribute' => 'href'),       // 1.3
      array('element' => 'option',  'attribute' => 'onpick'),     // 1.3
      array('element' => 'template', 'attribute' => 'onenterforward'), // 1.3
      array('element' => 'template', 'attribute' => 'onenterbackward'), // 1.3
      array('element' => 'template', 'attribute' => 'ontimer'),    // 1.3
      array('element' => 'wml',     'attribute' => 'xmlns'),      // 2.0
    );

    $match_metas = array(
      'content-base',
      'content-location',
      'referer',
      'location',
      'refresh',
    );

    // Extract all elements
    if (!preg_match_all('/<([a-z][^>]*)>/iu', $text, $matches))
      return array();
    $elements = $matches[1];
    $value_pattern = '=(("([^"]*)")|([^\s]*))';

    // Match elements and attributes
    foreach ($match_elements as $match_element) {
      $name = $match_element['element'];
      $attr = $match_element['attribute'];
      $pattern = '/^' . $name . '\s.*' . $attr . $value_pattern . '/iu';
      if ($name == 'object')
        $split_pattern = '/\s*/u';  // Space-separated URL list
      else if ($name == 'archive')
        $split_pattern = '/,\s*/u'; // Comma-separated URL list
      else
        unset($split_pattern);    // Single URL
      foreach ($elements as $element) {
        if (!preg_match($pattern, $element, $match))
          continue;
        $m = empty($match[3]) ? $match[4] : $match[3];
        if (!isset($split_pattern))
          $urls[$name][$attr][] = $m;
        else {
          $msplit = preg_split($split_pattern, $m);
          foreach ($msplit as $ms)
            $urls[$name][$attr][] = $ms;
        }
      }
    }

    // Match meta http-equiv elements
    foreach ($match_metas as $match_meta) {
      $attr_pattern    = '/http-equiv="?' . $match_meta . '"?/iu';
      $content_pattern = '/content'  . $value_pattern . '/iu';
      $refresh_pattern = '/\d*;\s*(url=)?(.*)$/iu';
      foreach ($elements as $element) {
        if (
          !preg_match('/^meta/iu', $element) ||
          !preg_match($attr_pattern, $element) ||
          !preg_match($content_pattern, $element, $match)
        )
          continue;
        $m = empty($match[3]) ? $match[4] : $match[3];
        if ($match_meta != 'refresh')
          $urls['meta']['http-equiv'][] = $m;
        else if (preg_match($refresh_pattern, $m, $match))
          $urls['meta']['http-equiv'][] = $match[2];
      }
    }

    // Match style attributes
    $urls['style'] = array();
    $style_pattern = '/style' . $value_pattern . '/iu';
    foreach ($elements as $element) {
      if (!preg_match($style_pattern, $element, $match))
        continue;
      $m = empty($match[3]) ? $match[4] : $match[3];
      $style_urls = self::extract_css_urls($m);
      if (!empty($style_urls))
        $urls['style'] = array_merge_recursive(
          $urls['style'],
          $style_urls
        );
    }

    // Match style bodies
    if (preg_match_all('/<style[^>]*>(.*?)<\/style>/siu', $text, $style_bodies)) {
      foreach ($style_bodies[1] as $style_body) {
        $style_urls = self::extract_css_urls($style_body);
        if (!empty($style_urls))
          $urls['style'] = array_merge_recursive(
            $urls['style'],
            $style_urls
          );
      }
    }
    if (empty($urls['style']))
      unset($urls['style']);

    return $urls;
  }

  public static function extract_css_urls($text)
  {
    $urls = array();

    $url_pattern     = '(([^\\\\\'", \(\)]*(\\\\.)?)+)';
    $urlfunc_pattern = 'url\(\s*[\'"]?' . $url_pattern . '[\'"]?\s*\)';
    $pattern         = '/(' .
      '(@import\s*[\'"]' . $url_pattern     . '[\'"])' .
      '|(@import\s*'      . $urlfunc_pattern . ')'      .
      '|('                . $urlfunc_pattern . ')'      .  ')/iu';
    if (!preg_match_all($pattern, $text, $matches))
      return $urls;

    // @import '...'
    // @import "..."
    foreach ($matches[3] as $match)
      if (!empty($match))
        $urls['import'][] =
          preg_replace('/\\\\(.)/u', '\\1', $match);

    // @import url(...)
    // @import url('...')
    // @import url("...")
    foreach ($matches[7] as $match)
      if (!empty($match))
        $urls['import'][] =
          preg_replace('/\\\\(.)/u', '\\1', $match);

    // url(...)
    // url('...')
    // url("...")
    foreach ($matches[11] as $match)
      if (!empty($match))
        $urls['property'][] =
          preg_replace('/\\\\(.)/u', '\\1', $match);

    return $urls;
  }

  /**
   * getValidUrlsFrompage() function
   *
   * 
   * 
   * 
   * 
   * 
   * 
   * @param string $url
   * @return array
   */
  public static function getValidUrlsFrompage($source)
  {
      
    
    $counter=0;
    $starting_postion=0;
    $ending_posting=0;
    $total_lenth=0;
    $string_to_start="href=\"/company";
    $start_string_lenth=6;
    $string_to_end="\"";
    $original_string="original";
    $work_string="work";
    $required_value="required";
    
    $links = [];
    $content = file_get_contents($source);
    $total_lenth=strlen($content);
    $work_string=$content;
    
    
    
     
       for($counter=0;$counter<=9;$counter++)
    {
        $starting_postion=strpos($work_string,$string_to_start);
        $work_string=substr($work_string,$starting_postion+$start_string_lenth,$total_lenth-$starting_postion-10);
        $total_lenth=strlen($work_string);
        $starting_postion=strpos($work_string,$string_to_end);
        $required_string=substr($work_string,0,$starting_postion);
        $links[$counter]=$required_string;
        $work_string=substr($work_string,$starting_postion,$total_lenth-$starting_postion-10);
        $total_lenth=strlen($work_string);
       
    }
        
        
    
   
    
    
    
    
    
    
    
    return $links;
    
  }
  
}
