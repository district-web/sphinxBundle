<?php

namespace DistrictWeb\SphinxBundle\Twig\Extension;

class SphinxExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'sphinx';
    }

    public function getFilters()
    {
        return array(
            'highlight_search' => new \Twig_Filter_Method($this, 'highlight_search_result')
        );
    }

    public function highlight_search_result($haystack, $needle, $tag = 'b')
    {
      $stopwords = array(); // TODO
      $needle = preg_split('/[^a-zàèìòùéA-ZÀÈÌÒÙÉ0-9]+/', $needle);
      if (empty($needle))
      {
        return $haystack;
      }
      if (strlen($haystack) == 0)
      {
        return false;
      }
      $hl = '<' . $tag . '>\1</' . $tag . '>';  // highlight
      $pattern = '#(%s)#i';
      foreach ($needle as $v)
      {
        $v = strtolower($v);
        // limit (3) should be equal to mysql variable 'ft_min_word_len'
        if (strlen(trim($v)) == 0 || in_array($v, $stopwords) || strlen($v) < 3){
          continue; //  no empty words or stopwords
        }
        $qv = preg_quote($v); // regex quote
        $qv1 = preg_quote(htmlentities($v));  // regex quote
        $regex = sprintf($pattern, $qv);
        $haystack = preg_replace($regex, $hl, $haystack);
        if ($qv != $qv1)
        {
          $regex1 = sprintf($pattern, $qv1);
          $haystack = preg_replace($regex1, $hl, $haystack);
        }
      }
      return $haystack;
    }
}