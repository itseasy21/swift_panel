<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_count_words( $string )
{
    $split_array = preg_split( "/\\s+/", $string );
    $word_count = preg_grep( "/[a-zA-Z0-9\\x80-\\xff]/", $split_array );
    return count( $word_count );
}

?>
