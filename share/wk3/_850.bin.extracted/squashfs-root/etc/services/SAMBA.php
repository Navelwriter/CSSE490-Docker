<?
include "/htdocs/phplib/trace.php";
include "/htdocs/phplib/inf.php";
include "/htdocs/phplib/xnode.php";

$SAMBAP		= "/var/etc/samba";
$SAMBACFG	= $SAMBAP."/smb.conf";
$MNTROOT	= "/var/tmp/storage";
$user_name_list = "";
$partition_count = query("/runtime/device/storage/disk/count");

fwrite("w",$START, "#!/bin/sh\n");
/* enable only when USB is pluged */
if($partition_count!="" && $partition_count!="0")
{
	fwrite("a",$START, "if [ ! -d ".$SAMBAP." ]; then mkdir -p ".$SAMBAP."; fi\n");
	/* SAMBA authentication*/
	$auth=query("/samba/auth");
	if($auth == 1)
	{
		foreach("/device/account/entry")
		{
			$user_name = query("name");
			if(tolower($user_name)=="admin")
			{
				$user_passwd = get("s", "password");
				fwrite("a",$START, "adduser ".$user_name."; ( echo \"".$user_passwd."\"; echo \"".$user_passwd."\" ) | smbpasswd -s -a ".$user_name."\n");
				fwrite("a",$STOP, "smbpasswd -x ".$user_name.";deluser ".$user_name."\n");
				$user_name_list=$user_name;
				break;
			}
		}
	}
}

fwrite("a",$START, "smbd -D\n");
fwrite("a",$START, "nmbd -D\n");
fwrite("a",$START, "sh /etc/services/SAMBA_loop.sh &\n");
fwrite("a",$START, "pid=`ps | grep -v \"grep\" | grep SAMBA_loop.sh | scut -f 1`\n");
fwrite("a",$START, "echo $pid > /var/run/samba_loop.pid\n");
fwrite("w",$STOP,  "#!/bin/sh\n");
fwrite("a",$STOP,  "pid=`cat /var/run/samba_loop.pid`\n");
fwrite("a",$STOP,  "kill $pid \n");
fwrite("a",$STOP,  "killall nmbd\n");
fwrite("a",$STOP,  "killall smbd\n");
fwrite("a",$STOP,  "rm -rf ".$SAMBAP."\n");

fwrite("w",$SAMBACFG, "[global]\n");
fwrite("a",$SAMBACFG, "\tunix charset = UTF8\n");
fwrite("a",$SAMBACFG, "\tworkgroup = WORKGROUP\n");
fwrite("a",$SAMBACFG, "\tserver string = ".query("/runtime/device/modelname")."\n");
fwrite("a",$SAMBACFG, "\tnetbios name = ".query("/runtime/device/modelname")."\n");
fwrite("a",$SAMBACFG, "\twinbind nested groups = no\n");
fwrite("a",$SAMBACFG, "\tdomain master = no\n");
fwrite("a",$SAMBACFG, "\tinterfaces = ".INF_getcfgipaddr("LAN-1")."/".INF_getcfgmask("LAN-1")."\n");
fwrite("a",$SAMBACFG, "\tbind interfaces only = yes\n");
	if($auth=="1")
		{fwrite("a",$SAMBACFG, "\tsecurity = user\n");}
	else
		{fwrite("a",$SAMBACFG, "\tsecurity = share\n");}

fwrite("a",$SAMBACFG, "\tsocket options = IPTOS_LOWDELAY TCP_NODELAY SO_KEEPALIVE SO_RCVBUF=65536 SO_SNDBUF=65536\n");
fwrite("a",$SAMBACFG, "\tdns proxy = no\n");
fwrite("a",$SAMBACFG, "\tguest ok = yes\n");
fwrite("a",$SAMBACFG, "\tload printers = no\n");
fwrite("a",$SAMBACFG, "\tbrowseable = yes\n");
fwrite("a",$SAMBACFG, "\twriteable = yes\n");
fwrite("a",$SAMBACFG, "\tpublic = yes\n");
fwrite("a",$SAMBACFG, "\toplocks = no\n");
fwrite("a",$SAMBACFG, "\tcreate mask = 0777\n");
fwrite("a",$SAMBACFG, "\tdirectory mask = 0777\n");
fwrite("a",$SAMBACFG, "\tmax connections = 8\n");
fwrite("a",$SAMBACFG, "\tread size = 32768\n");
fwrite("a",$SAMBACFG, "\tread prediction = true\n");
fwrite("a",$SAMBACFG, "\tfollow symlinks = no\n"); 

//check kernel version. if newwer than 2.6.31 then enable sendfile else disable
//because of ntfs-3g have add direct_op option to fuse. and may cause sendfile error.
//2.6.31 have fixed it
$read_buf = fread("","/proc/version");
$version = cut($read_buf, 2," ");

$major = cut($version,  0, ".");
$sub = cut($version,  1, ".");
$minor = cut($version,  2, ".");

if($major == 2)
{
	if($sub == 6)
	{
		if($minor >= 31)
			fwrite("a",$SAMBACFG, "\tuse sendfile = yes\n");
		else
			fwrite("a",$SAMBACFG, "\tuse sendfile = no\n");
	}
	else if($sub > 6)
		fwrite("a",$SAMBACFG, "\tuse sendfile = yes\n");
	else
		fwrite("a",$SAMBACFG, "\tuse sendfile = no\n");
}else if($major > 2)
	fwrite("a",$SAMBACFG, "\tuse sendfile = yes\n");
else
	fwrite("a",$SAMBACFG, "\tuse sendfile = no\n");


fwrite("a",$SAMBACFG, "\tuse receivefile = yes\n");
//fwrite("a",$SAMBACFG, "\tencrypt passwords = yes\n");
//fwrite("a",$SAMBACFG, "\tnull passwords = yes\n");
//fwrite("a",$SAMBACFG, "\tguest account = nobody\n");
//fwrite("a",$SAMBACFG, "\tmap to guest=bad user\n");
//fwrite("a",$SAMBACFG, "\tkernel change notify = yes\n");
//fwrite("a",$SAMBACFG, "\tpid directory = /var/run\n");

fwrite("a",$SAMBACFG, "\tvalid users = ".$user_name_list."\n");
/*for shareport*/
fwrite("a",$SAMBACFG, "\tinclude = /var/etc/silex/smb.dir.conf\n");
?>
