function openWin(fileToOpen,nameOfWindow,width,height) {
	myWindow = window.open("",nameOfWindow,"menubar=no,scrollbars=yes,status=no,width="+width+",height="+height);
	myWindow.document.open();
	myWindow.document.write('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">');
	myWindow.document.write('<html><head><title>Screenshot Viewer</title>')
	myWindow.document.write('<style type="text/css">');
	myWindow.document.write('body { margin: 0; padding: 0; background-color: lightgrey; }');
	myWindow.document.write('img { border: 0; }');
	myWindow.document.write('p { display: inline; }');
	myWindow.document.write('</style></head><body>');
	myWindow.document.write('<a onclick="self.close();" href=""><img src="'+ fileToOpen +'" alt="Screenshot"></a>');
	myWindow.document.write('</body></html>');
	myWindow.document.close();
}

function deleteURL(text, url) {
	if (confirm(text)) {
	   self.location = url;
	}
}

function ChangeTr(tableRow, bRowActive, sHighlightColor, sInactiveColor,
                       sTextDecorationHighlight, sTextDecorationInactive)
{
    if (bRowActive)
    {
        tableRow.style.backgroundColor = sHighlightColor;
        tableRow.style.cursor = "hand";
        tableRow.style.textDecoration = sTextDecorationHighlight;
    }
    else
    {
        tableRow.style.backgroundColor = sInactiveColor;
        tableRow.style.cursor = "pointer";
        tableRow.style.textDecoration = sTextDecorationInactive;
    }
}

function DoNav(sUrl)
{
    document.location.href = sUrl;
}

/**
 * commentId is the uniquely identifying comment id from the database.
 * It is also used as the div id for the comment body.
 */
function showComment(commentid)
{
  elem = $(commentid);
  if(elem.visible() && !elem.empty())
  {
    elem.hide();
  }
  else
  {
   // Cache the contents of the comment body so we don't need to hit db again.
    if(elem.empty())
    {
      new Ajax.Updater(commentid, 'comment_body.php', { 
        method: 'get',
        parameters: {
          iCommentId: commentid    
        }
      });
    }
    elem.show();
  }
}
