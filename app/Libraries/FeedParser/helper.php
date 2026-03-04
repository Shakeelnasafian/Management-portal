<?php

namespace App\Libraries\FeedParser;
function cleanString($string){
    $db = new db();
    $current_encoding = mb_detect_encoding($string, 'UTF-8', true);
    $string = ($current_encoding == "UTF-8") ? $string : utf8_encode($current_encoding);
    $string = html_entity_decode($string);
    $string = strip_tags($string, '<p><strong><br><img><ul><ol><li><h1><h2><h3><h4><h5><h6><table><tbody><tr><th><td>');
    $string =trim(preg_replace('~[\r\n\t]~', '',$string));

    // balance tags
    $string = force_balance_tags($string);

    $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  // use this pattern to remove any empty tag
    $string = preg_replace($pattern, '', $string);

    if(empty($string)){
        $string = NULL;
    }else{
        $string = $db->escape(htmlentities($string, ENT_COMPAT, 'UTF-8', false));
    }
    return $string;
}

function is_word_exists ($haystack, $needle = [], $offset=0) {
    $haystack = html_entity_decode($haystack);
    
    if (!is_array($needle)) {
    $needle = array($needle);
    }
    
    foreach ($needle as $searchstring) {
    if (stripos($haystack,$searchstring) !== false) return true;
    }
    
    return false;
}

/* Here is the function to delete the cookie file XD */
function delete_cookie_file($name)
{
    $file_pointer = dirname(__DIR__) . "/cookie_files/" . $name;
    $status = false;
    if (!unlink($file_pointer)) {
        $status = "$file_pointer cannot be deleted due to an error";
    } else {
        $status = "$file_pointer has been deleted";
    }
    return $status;
}

/**
* Balances tags of string using a modified stack.
*
* @since 2.0.4
* @since 5.3.0 Improve accuracy and add support for custom element tags.
*
* @author Leonard Lin <leonard@acm.org>
* @license GPL
* @copyright November 4, 2001
* @version 1.1
* @todo Make better - change loop condition to $text in 1.2
* @internal Modified by Scott Reilly (coffee2code) 02 Aug 2004
*      1.1  Fixed handling of append/stack pop order of end text
*           Added Cleaning Hooks
*      1.0  First Version
*
* @param string $text Text to be balanced.
* @return string Balanced text.
*/
function force_balance_tags( $text ) {
    $tagstack  = array();
    $stacksize = 0;
    $tagqueue  = '';
    $newtext   = '';
    // Known single-entity/self-closing tags.
    $single_tags = array( 'area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source' );
    // Tags that can be immediately nested within themselves.
    $nestable_tags = array( 'blockquote', 'div', 'object', 'q', 'span' );

    // WP bug fix for comments - in case you REALLY meant to type '< !--'.
    $text = str_replace( '< !--', '<    !--', $text );
    // WP bug fix for LOVE <3 (and other situations with '<' before a number).
    $text = preg_replace( '#<([0-9]{1})#', '&lt;$1', $text );

    /**
     * Matches supported tags.
     *
     * To get the pattern as a string without the comments paste into a PHP
     * REPL like `php -a`.
     *
     * @see https://html.spec.whatwg.org/#elements-2
     * @see https://w3c.github.io/webcomponents/spec/custom/#valid-custom-element-name
     *
     * @example
     * ~# php -a
     * php > $s = [paste copied contents of expression below including parentheses];
     * php > echo $s;
     */
    $tag_pattern = (
        '#<' . // Start with an opening bracket.
        '(/?)' . // Group 1 - If it's a closing tag it'll have a leading slash.
        '(' . // Group 2 - Tag name.
            // Custom element tags have more lenient rules than HTML tag names.
            '(?:[a-z](?:[a-z0-9._]*)-(?:[a-z0-9._-]+)+)' .
                '|' .
            // Traditional tag rules approximate HTML tag names.
            '(?:[\w:]+)' .
        ')' .
        '(?:' .
            // We either immediately close the tag with its '>' and have nothing here.
            '\s*' .
            '(/?)' . // Group 3 - "attributes" for empty tag.
                '|' .
            // Or we must start with space characters to separate the tag name from the attributes (or whitespace).
            '(\s+)' . // Group 4 - Pre-attribute whitespace.
            '([^>]*)' . // Group 5 - Attributes.
        ')' .
        '>#' // End with a closing bracket.
    );

    while ( preg_match( $tag_pattern, $text, $regex ) ) {
        $full_match        = $regex[0];
        $has_leading_slash = ! empty( $regex[1] );
        $tag_name          = $regex[2];
        $tag               = strtolower( $tag_name );
        $is_single_tag     = in_array( $tag, $single_tags, true );
        $pre_attribute_ws  = isset( $regex[4] ) ? $regex[4] : '';
        $attributes        = trim( isset( $regex[5] ) ? $regex[5] : $regex[3] );
        $has_self_closer   = '/' === substr( $attributes, -1 );

        $newtext .= $tagqueue;

        $i = strpos( $text, $full_match );
        $l = strlen( $full_match );

        // Clear the shifter.
        $tagqueue = '';
        if ( $has_leading_slash ) { // End tag.
            // If too many closing tags.
            if ( $stacksize <= 0 ) {
                $tag = '';
                // Or close to be safe $tag = '/' . $tag.

                // If stacktop value = tag close value, then pop.
            } elseif ( $tagstack[ $stacksize - 1 ] === $tag ) { // Found closing tag.
                $tag = '</' . $tag . '>'; // Close tag.
                array_pop( $tagstack );
                $stacksize--;
            } else { // Closing tag not at top, search for it.
                for ( $j = $stacksize - 1; $j >= 0; $j-- ) {
                    if ( $tagstack[ $j ] === $tag ) {
                        // Add tag to tagqueue.
                        for ( $k = $stacksize - 1; $k >= $j; $k-- ) {
                            $tagqueue .= '</' . array_pop( $tagstack ) . '>';
                            $stacksize--;
                        }
                        break;
                    }
                }
                $tag = '';
            }
        } else { // Begin tag.
            if ( $has_self_closer ) { // If it presents itself as a self-closing tag...
                // ...but it isn't a known single-entity self-closing tag, then don't let it be treated as such
                // and immediately close it with a closing tag (the tag will encapsulate no text as a result).
                if ( ! $is_single_tag ) {
                    $attributes = trim( substr( $attributes, 0, -1 ) ) . "></$tag";
                }
            } elseif ( $is_single_tag ) { // Else if it's a known single-entity tag but it doesn't close itself, do so.
                $pre_attribute_ws = ' ';
                $attributes      .= '/';
            } else { // It's not a single-entity tag.
                // If the top of the stack is the same as the tag we want to push, close previous tag.
                if ( $stacksize > 0 && ! in_array( $tag, $nestable_tags, true ) && $tagstack[ $stacksize - 1 ] === $tag ) {
                    $tagqueue = '</' . array_pop( $tagstack ) . '>';
                    $stacksize--;
                }
                $stacksize = array_push( $tagstack, $tag );
            }

            // Attributes.
            if ( $has_self_closer && $is_single_tag ) {
                // We need some space - avoid <br/> and prefer <br />.
                $pre_attribute_ws = ' ';
            }

            $tag = '<' . $tag . $pre_attribute_ws . $attributes . '>';
            // If already queuing a close tag, then put this tag on too.
            if ( ! empty( $tagqueue ) ) {
                $tagqueue .= $tag;
                $tag       = '';
            }
        }
        $newtext .= substr( $text, 0, $i ) . $tag;
        $text     = substr( $text, $i + $l );
    }

    // Clear tag queue.
    $newtext .= $tagqueue;

    // Add remaining text.
    $newtext .= $text;

    while ( $x = array_pop( $tagstack ) ) {
        $newtext .= '</' . $x . '>'; // Add remaining tags to close.
    }

    // WP fix for the bug with HTML comments.
    $newtext = str_replace( '< !--', '<!--', $newtext );
    $newtext = str_replace( '<    !--', '< !--', $newtext );

    return $newtext;
}
?>
