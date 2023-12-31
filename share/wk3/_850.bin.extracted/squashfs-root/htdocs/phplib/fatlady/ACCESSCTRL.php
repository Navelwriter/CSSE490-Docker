<? /* vi: set sw=4 ts=4: */
/* fatlady is used to validate the configuration for the specific service.
 * FATLADY_prefix was defined to the path of Session Data.
 * 3 variables should be returned for the result:
 * FATLADY_result, FATLADY_node & FATLADY_message. */
include "/htdocs/phplib/trace.php";
include "/htdocs/phplib/xnode.php";
include "/htdocs/phplib/inet.php";

function set_result($result, $node, $message)
{
	$_GLOBALS["FATLADY_result"] = $result;
	$_GLOBALS["FATLADY_node"]   = $node;
	$_GLOBALS["FATLADY_message"]= $message;
	return $result;
}

set_result("FAILED","","");
$rlt = "0";
$ret = "OK";
$cnt = query($FATLADY_prefix."/acl/accessctrl/count");

if ($cnt > query("/acl/accessctrl/max"))
{
	set_result("FAILED", $FATLADY_prefix."/acl/accessctrl/count", i18n("The rules exceed maximum."));
	$rlt = "-1";
}
else
{
	/* Below to Check for webfilter */
	$root = "/acl/accessctrl/webfilter";
	
	/* The default MAX. value. */
	$max = query($root."/max"); if ($max=="") $max=32;
	$count = query($FATLADY_prefix.$root."/count"); if ($count=="") $count=0;
	$seqno = query($FATLADY_prefix.$root."/seqno");
	if ($count > $max) $count = $max;
	TRACE_debug("FATLADY: URLCTRL: max=".$max.", count=".$count.", seqno=".$seqno);
	/* Delete the extra entries. */
	$cnt = query($FATLADY_prefix.$root."/entry#");
	while ($cnt>$count) { del($FATLADY_prefix.$root."/entry:".$cnt); $cnt--; }
	/* Verify each entries */
	set($FATLADY_prefix.$root."/count", $count);
	foreach ($FATLADY_prefix.$root."/entry")
	{
		if ($InDeX > $count) break;
	
		/* The current entry path. */
		$entry = $FATLADY_prefix.$root."/entry:".$InDeX;
	
		/* Check empty UID */
		$uid = query("uid");
		if ($uid=="")
		{
			$uid = "URLF-".$seqno;
			set("uid", $uid);
			$seqno++;
			set($FATLADY_prefix.$root."/seqno", $seqno);
		}
		/* Check duplicated UID */
		if ($$uid == "1")
		{
			$ret = set_result("FAILED", $entry."/uid", "Duplicated UID - ".$uid);
			break;
		}
		$$uid = "1";
	
		/* verify URL */
		$url = query("url");
		if($url == "")
		{
			$ret = set_result("FAILED",$entry."/url", i18n("No URL for this rule."));
			break;
		}
	
		/* remove the leading 'http://' */
		$tmpurl = cut($url, 0, "/");
		if($tmpurl == "http:") $url = scut($url, 0, "http://");
	
		/* Check valid URL */
		/*if(isdomain($url)!=1)
		{
			$ret = set_result("FAILED",$entry."/url", i18n("Invalid URL."));
			break;
		}*/
		if(cut_count($url,"/")==1)  //no find '/' char
		{
			if(isdomain($url)!=1)   //filename
			{
				if (isalnum(charcodeat($url,0))!=1 || isalnum(charcodeat($url,strlen($url)-1))!=1)
				{
					$ret = set_result("FAILED",$entry."/url", i18n("Invalid URL."));
					break;
				}
				$i = 1; 
				while($i < strlen($url)-1)
				{
					if (isalnum(charcodeat($url,$i))!=1 && 
						charcodeat($url,$i) != "_" && 
						charcodeat($url,$i) != "." && 
						charcodeat($url,$i) != "-" && 
						charcodeat($url,$i) != "~" && 
						charcodeat($url,$i) != "&" && 
						charcodeat($url,$i) != "?" && 
						charcodeat($url,$i) != "%" && 
						charcodeat($url,$i) != ":" && 
						charcodeat($url,$i) != "=")
					{
						$ret = set_result("FAILED",$entry."/url", i18n("Invalid URL."));
						break;
					}
					$i++;
				}
			}
		}
		else //if(cut_count($url,"/")>1)    find  more than one '/' char
		{
			$tmpurl1 = cut($url, 0, "/");   //first is hostname,other is path and filename
			if(isdomain($tmpurl1)!=1)
			{
				$ret = set_result("FAILED",$entry."/url", i18n("Invalid URL."));
				break;
			}

			//path and filename
			$i = 0; 
			while ($i < strlen($url))
			{
				if (isalnum(charcodeat($url,$i))!=1 && 
					charcodeat($url,$i) != "=" && 
					charcodeat($url,$i) != "_" && 
					charcodeat($url,$i) != "-"  && 
					charcodeat($url,$i) != "/"  && 
					charcodeat($url,$i) != "~"  && 
					charcodeat($url,$i) != "&"  && 
					charcodeat($url,$i) != "?"  && 
					charcodeat($url,$i) != "%"  && 
					charcodeat($url,$i) != ":"  && 
					charcodeat($url,$i) != ".")
				{
					$ret = set_result("FAILED",$entry."/url", i18n("Invalid URL."));
					break;
				}
				$i++;
			}
		}
		
		/* duplication check */
		$i = $InDeX + 1;
		while ($i <= $cnt)
		{
			$url_i = query($FATLADY_prefix.$root."/entry:".$i."/url");
			/* remove the leading 'http://' */
			$tmpurl = cut($url_i, 0, "/");
			if($tmpurl == "http:") $url_i = scut($url_i, 0, "http://");
			if ($url == $url_i)
			{
				$ret = set_result("FAILED", $entry."/url", i18n("Duplicated URL."));
				break;
			}
			$i++;
		}
		if ($ret=="FAILED") break;
	}
}

if ($rlt=="0" && $ret=="OK")
{
	set($FATLADY_prefix."/valid", "1");
	set_result("OK", "", "");
}
?>
