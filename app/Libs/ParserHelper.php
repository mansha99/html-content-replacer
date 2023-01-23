<?php

namespace App\Libs;

use DOMDocument;
use DOMNode;

class ParserHelper
{
    public static function isHTML($string)
    {
        if ($string != strip_tags($string)) {
            return true;
        } else {
            return false;
        }
    }

    public static function DOMinnerHTML(DOMNode $element)
    {
        $innerHTML = "";
        $children  = $element->childNodes;

        foreach ($children as $child) {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }
    public static function setInnerHTML($element, $html)
    {
        $fragment = $element->ownerDocument->createDocumentFragment();
        $fragment->appendXML($html);
        $clone = $element->cloneNode(); // Get element copy without children
        $clone->appendChild($fragment);
        $element->parentNode->replaceChild($clone, $element);
    }
    //Tag to be replaced, no matter child exist or not
    public static function isReplaceValueDirectTag($tag)
    {
        return in_array($tag, ["label", "p"]);
    }
    //Replace directly , wether child exist or not
    public static function replaceValueDirect($tag)
    {
        if ($tag == "label") {
            return "Lorem Label contenyt";
        }
        if ($tag == "li") {
            return "Lorem Li content";
        }
        if ($tag == "p") {
            return "Lorem p content";
        }
        return "Lorem Ipsum";
    }
    //Replace directly , wether child exist or not
    public static function replaceValue($tag)
    {
        if ($tag == "label") {
            return "Ipsum Label contenyt";
        }
        if ($tag == "li") {
            return "Ipsum Li content";
        }
        if ($tag == "p") {
            return "Ipsum p content";
        }

        return "Ipsum Ipsum";
    }
    
}
