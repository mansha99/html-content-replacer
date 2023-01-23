<?php

namespace App\Http\Controllers;

use App\Libs\ParserHelper;
use DOMDocument;
use DOMNode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;

class ContentReplacerController extends Controller
{
    public function index()
    {
        $content = File::get('content/content.html');
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = true;
        $dom->formatOutput       = true;
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        libxml_use_internal_errors(true);
        foreach ($dom->getElementsByTagName('*') as $element) {
            $value = ParserHelper::DOMinnerHTML($element);
            $tag = $element->tagName;
            if ($tag == "img") {
                $old_src = $element->getAttribute('src');
                list($width, $height, $type, $attr) = getimagesize($old_src);
                $new_src = 'https://via.placeholder.com/' . $width . 'X' . $height . '.png';
                $element->setAttribute('src', $new_src);
                continue;
            }
            if (ParserHelper::isReplaceValueDirectTag($tag)) {
                ParserHelper::setInnerHTML($element, ParserHelper::replaceValueDirect($tag));
            } else {
                $isHTML = ParserHelper::isHTML($value) ? "Y" : "N";
                if ($isHTML == "N") {
                    ParserHelper::setInnerHTML($element, " Lorem");
                }
            }
        }
        $output = $dom->saveHTML();
        echo $output;
    }
}
