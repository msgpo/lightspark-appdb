<?php

$_indent_level = 0;

function do_indent($str, $v = 0)
{
	global $_indent_level;

	if($v < 0)
		$_indent_level += $v;

	if($_indent_level > 0)
	    $str =  str_repeat("  ", $_indent_level) . $str;

	if($v > 0)
		$_indent_level += $v;

	return $str . "\n";
}

function do_html_tr($t, $arr, $class, $extra)
{
	if(strlen($class))
		$class = " class=\"$class\"";

	$str = do_indent("<tr$class>", 1);
	for($i = 0; $i < sizeof($arr); $i++)
	{
		if(is_array($arr[$i]))
		{
			$val = $arr[$i][0];
			$extra = " ".$arr[$i][1];
		}
		else
		{
			$val = $arr[$i];
			$extra = "";
		}

		if (! $val)
		{
			$val = "&nbsp;";
		}

		if(stristr($val, "<$t"))
		{
			$str .= do_indent($val);
		}
		else
		{
			$str .= do_indent("<$t$class$extra> ".trim($val)." </$t>", 0);
		}
	}
	$str .= do_indent("</tr>", -1);

	return $str;
}

// HTML TH
function html_th($arr, $class = "", $extra = "")
{
	return do_html_tr("th", $arr, $class, $extra);
}

// HTML TR
function html_tr($arr, $class = "", $extra = "")
{
	return do_html_tr("td", $arr, $class, $extra);
}

// HTML TABLE
function html_table_begin($extra = "")
{
	return do_indent("<table $extra>", 1);
}

function html_table_end()
{
	return do_indent("</table>", -1);
}


// HTML HTML
function html_begin()
{
	return do_indent("<html>", 1);
}

function html_end()
{
	return do_indent("</html>", -1);
}


// HTML HEAD
function html_head($title, $stylesheet = 0)
{
	$str  = do_indent("<head>", 1);
	$str .= do_indent("<title> $title </title>", 0);
	if($stylesheet)
		$str .= do_indent("<link rel=\"stylesheet\" ".
				  "href=\"$stylesheet\" type=\"text/css\">", 0);
	$str .= do_indent("</head>", -1);

	return $str;
}


// HTML BODY
function html_body_begin()
{
	return do_indent("<body>", 1);
}

function html_body_end()
{
	return do_indent("</body>", -1);
}


// HTML BR
function html_br($count = 1)
{
	return do_indent(str_repeat("<br>", $count));
}

// HTML A HREF
function html_ahref($label, $url, $extra = "")
{
	$label = stripslashes($label);
	if (!$label and $url)
	{
		return do_indent(" <a href=\"$url\" $extra>$url</a> ");
	}
	else if (!$label)
	{
		return do_indent(" &nbsp; ");
	}
	else
	{
		return do_indent(" <a href=\"$url\" $extra>$label</a> ");
	}
}

// HTML echo a string
function html_echo($str)
{
	return do_indent($str);
}

// HTML B (bold)
function html_b($str)
{
	return do_indent("<b>$str</b>");
}

// HTML SMALL (small text)
function html_small($str)
{
	return do_indent("<small>$str</small>");
}

// HTML P
function html_p()
{
	return do_indent("<p>");
}

function html_line($thickness = 1, $colspan = 1, $color = "#000000")
{
    return do_indent("<tr><td bgcolor=\"$color\" colspan=$colspan> ".
		     "<img src=\"/images/blank.gif\" height=$thickness ".
		     "vspace=0> </td></tr>");
}



function html_imagebutton($text, $url, $extra = "")
{
    static $i = 1;

    $i++;
    $img1 = apidb_url("util/button.php?text=".urlencode($text)."&pressed=0");
    $img2 = apidb_url("util/button.php?text=".urlencode($text)."&pressed=1");

    $java  = "onMouseDown = 'document.img$i.src = \"$img2\"; return true;' ";
    $java .= "onMouseUp = 'document.img$i.src = \"$img1\"; return true;' ";

    return "\n<a href='$url' $extra $java>\n <img src='$img1' name='img$i' alt='$text'> </a>\n";
}


function html_frame_start($title = "", $width = "", $extra = "", $innerPad = 5)
{

    global $apidb_root;

    if ($width) { $width = 'width="'.$width.'"'; }

$str = '<table '.$width.' border=0 id="mainTable" cellpadding=0 cellspacing=0 align=center>'."\n";

if ($title)
{
$str .= '
<tr><td colspan=3><table width="100%" border=0 cellpadding=0 cellspacing=0>
<tr><td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="topMenu">
      <tr>
        <td valign="top" align="left"><img src="'.$apidb_root.'images/winehq_border_top_left.gif" alt=""></td>
        <td rowspan="3" valign="middle" align="left"><img src="'.$apidb_root.'images/winehq_border_dot_left.gif" alt=""></td>
        <td width="100%" rowspan="3" align="center"><span class="menuTitle">'.$title.'</span></td>
        <td rowspan="3" valign="middle" align="right"><img src="'.$apidb_root.'images/winehq_border_dot_right.gif" alt=""></td>
        <td valign="top" align="left"><img src="'.$apidb_root.'images/winehq_border_top_right.gif" alt=""></td>
      </tr>
      <tr>
        <td><img src="'.$apidb_root.'images/blank.gif" width="1" height="1" alt=""></td>
        <td><img src="'.$apidb_root.'images/blank.gif" width="1" height="1" alt=""></td>
      </tr>
      <tr>
        <td valign="bottom" align="right"><img src="'.$apidb_root.'images/winehq_border_bottom_left.gif" alt=""></td>
        <td valign="bottom" align="right"><img src="'.$apidb_root.'images/winehq_border_bottom_right.gif" alt=""></td>
      </tr>
    </table>
</td></tr>
</table></td></tr>
';
}

$str .= '
<tr>
<td><img src="'.$apidb_root.'images/blank.gif" width=5 height=1 alt="-"></td>
<td width="100%"><table width="100%" border=0 cellpadding=0 cellspacing=0>
    <tr><td class=topMenu>
        <table width="100%" border=0 cellpadding="'.$innerPad.'" cellspacing="1" '.$extra.'><tr><td class=white>
';

    return $str;
}

function html_frame_end($text = "")
{
    global $apidb_root;
    
$str = '
        </td></tr></table></td></tr>
    </table>
</td>
<td><img src="'.$apidb_root.'images/blank.gif" width=5 height=1 alt="-"></td>
</tr>
</table>
<br>
';
    
    return $str;
}


function html_select($name, $values, $default = null, $descs = null)
{
    $str = "<select name='$name'>\n";
    while(list($idx, $value) = each($values))
	{
	    $desc = $value;
	    if($descs)
		$desc = $descs[$idx];

	    if($value == $default)
		$str .= "  <option selected value='$value'>$desc\n";
	    else
		$str .= "  <option value='$value'>$desc\n";
	}
    $str .= "</select>\n";

    return $str;
}

function html_back_link($howmany = 1, $url = "")
{
    if (!$url)
    {
        $url = 'javascript:history.back('.$howmany.');';
    }
    return '<p>&nbsp;&nbsp; <a href="'.$url.'">&lt;&lt; Back</a></p>'."\n";
}


function p()
{
	return "\n<p>&nbsp;</p>\n";
}

function add_br($text = "")
{
	$text = ereg_replace("\n","<br>\n",$text);
	return $text;
}

function make_dll_option_list($varname, $dllid = -1)
{
    $db = new ApiDB();

    echo "<select name='$varname'>\n";
    //echo "<option value='ALL'>ALL\n";
    $list = $db->get_dll_names();
    while(list($name, $id) = each($list))
	{
	    if($dllid == $id)
		echo "<option value=$id selected>$name  ($id)\n";
	    else
		echo "<option value=$id>$name  ($id)\n";
	}
    echo "</select>\n";
}


function make_inx_option_list($varname, $inx = null)
{
    $list = array("yes", "no", "stub", "unknown");
    echo "<select name='$varname'>\n";
    while(list($idx, $value) = each($list))
        {
            if($value == $inx)
                echo "<option value=$value selected>$value\n";
            else
                echo "<option value=$value>$value\n";
        }
    echo "</select>\n";

}


function make_quality_option_list($varname, $quality)
{
    $list = array(-1, 1, 2, 3, 4, 5);
    echo "<select name='$varname'>\n";
    while(list($idx, $value) = each($list))
	{
	    if($value == -1)
		$label = "unknown";
	    else
		$label = $value;

	    if($quality == $value)
		echo "<option value=$value selected>$label\n";
	    else
		echo "<option value=$value>$label\n";
	}
    echo "</select>\n";
}

?>
