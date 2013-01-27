<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_core_write_compiled_include( $params, &$smarty )
{
    $_tag_start = "if \\(\\\$this->caching && \\!\\\$this->_cache_including\\)\\: echo '\\{nocache\\:(".$params['cache_serial'].")#(\\d+)\\}'; endif;";
    $_tag_end = "if \\(\\\$this->caching && \\!\\\$this->_cache_including\\)\\: echo '\\{/nocache\\:(\\2)#(\\3)\\}'; endif;";
    preg_match_all( "!(".$_tag_start."(.*)".$_tag_end.")!Us", $params['compiled_content'], $_match_source, PREG_SET_ORDER );
    if ( count( $_match_source ) == 0 )
    {
        return;
    }
    $_include_compiled = "<?php /* Smarty version ".$smarty->_version.", created on ".strftime( "%Y-%m-%d %H:%M:%S" )."\n";
    $_include_compiled .= "         compiled from ".strtr( urlencode( $params['resource_name'] ), array( "%2F" => "/", "%3A" => ":" ) )." */\n\n";
    $_compile_path = $params['include_file_path'];
    $smarty->_cache_serials[$_compile_path] = $params['cache_serial'];
    $_include_compiled .= "\$this->_cache_serials['".$_compile_path."'] = '".$params['cache_serial']."';\n\n?>";
    $_include_compiled .= $params['plugins_code'];
    $_include_compiled .= "<?php";
    $this_varname = 5 <= ( double )phpversion( ) ? "_smarty" : "this";
    $_i = 0;
    $_for_max = count( $_match_source );
    for ( ; $_i < $_for_max; $_i++ )
    {
        $_match =& $_match_source[$_i];
        $source = $_match[4];
        if ( $this_varname == "_smarty" )
        {
            $tokens = token_get_all( "<?php ".$_match[4] );
            $open_tag = "";
            while ( $tokens )
            {
                $token = array_shift( $tokens );
                if ( is_array( $token ) )
                {
                    $open_tag .= $token[1];
                }
                else
                {
                    $open_tag .= $token;
                }
                if ( $open_tag == "<?php " )
                {
                    break;
                }
            }
            $i = 0;
            $count = count( $tokens );
            for ( ; $i < $count; $i++ )
            {
                if ( is_array( $tokens[$i] ) )
                {
                    if ( $tokens[$i][0] == T_VARIABLE && $tokens[$i][1] == "\$this" )
                    {
                        $tokens[$i] = "\$".$this_varname;
                    }
                    else
                    {
                        $tokens[$i] = $tokens[$i][1];
                    }
                }
            }
            $source = implode( "", $tokens );
        }
        $_include_compiled .= "\nfunction _smarty_tplfunc_{$_match['2']}_{$_match['3']}(&\${$this_varname})\n{\n{$source}\n}\n\n";
    }
    $_include_compiled .= "\n\n?>\n";
    $_params = array(
        "filename" => $_compile_path,
        "contents" => $_include_compiled,
        "create_dirs" => TRUE
    );
    require_once( SMARTY_CORE_DIR."core.write_file.php" );
    smarty_core_write_file( $_params, $smarty );
    return TRUE;
}

?>
