<?

include("path.php");
include(BASE."include/"."incl.php");
include(BASE."include/"."tableve.php");

if(!havepriv("admin")) 
{
    errorpage("Insufficient Privileges!");
    exit;
}
else
{
    global $admin_mode;
    $admin_mode = 1;
}

apidb_header("Add Application Version");

$t = new TableVE("create");

if(!$appId)
    $appId = 0;

if($_POST)
{
    $t->update($_POST);
}
else
{
    $table = "appVersion";
    $query = "INSERT INTO $table VALUES(0, $appId, 'NONAME', null, null, null, 0.0, 0.0)";

    mysql_query("DELETE FROM $table WHERE versionName = 'NONAME'");

    if(debugging())
	echo "$query <br /><br />\n";

    $t->create($query, $table, "versionId");
}

echo html_back_link(1,BASE."appview.php?appId=$appId");

apidb_footer();

?>
