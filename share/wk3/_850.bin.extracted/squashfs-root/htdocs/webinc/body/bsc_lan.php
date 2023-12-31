<? include "/htdocs/webinc/body/draw_elements.php"; ?>
<form id="mainform" onsubmit="return false;">
<div class="orangebox">
	<h1><?echo i18n("Network Settings");?></h1>
	<p>
		<?echo i18n("Use this section to configure the internal network settings of your router and also to configure the built-in DHCP server to assign IP addresses to computers on your network.");?>
		<?echo i18n("The IP address that is configured here is the IP address that you use to access the Web-based management interface.");?>
		<?echo i18n("If you change the IP address in this section, you may need to adjust your PC's network settings to access the network again.");?>
	</p>
	<p><strong>
		<?echo i18n("Please note that this section is optional and you do not need to change any of the settings here to get your network up and running.");?>
	</strong></p>
	<p><input type="button" value="<?echo i18n("Save Settings");?>" onClick="BODY.OnSubmit();" />
	<input type="button" value="<?echo i18n("Don't Save Settings");?>" onClick="BODY.OnReload();" /></p>
</div>
<div class="blackbox">
	<h2><?echo i18n("Router Settings");?></h2>
	<p>
		<?echo i18n("Use this section to configure the internal network settings of your router.");?>
		<?echo i18n("The IP address that is configured here is the IP address that you use to access the Web-based management interface.");?>
		<?echo i18n("If you change the IP address here, you may need to adjust your PC's network settings to access the network again.");?>
	</p>
	<div class="textinput">
		<span class="name"><?echo i18n("Router IP Address");?></span>
		<span class="delimiter">:</span>
		<span class="value"><input id="ipaddr" type="text" size="20" maxlength="15" /></span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("Default Subnet Mask");?></span>
		<span class="delimiter">:</span>
		<span class="value"><input id="netmask" type="text" size="20" maxlength="15" /></span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("Host Name");?></span>
		<span class="delimiter">:</span>
		<span class="value"><input id="device" type="text" size="20" maxlength="15" /></span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("Local Domain Name");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input id="domain" type="text" size="20" maxlength="30" />
			(<?echo i18n("optional");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("Enable DNS Relay");?></span>
		<span class="delimiter">:</span>
		<span class="value"><input id="dnsr" type="checkbox" /></span>
	</div>
	<div class="gap"></div>
</div>
<div class="blackbox">
	<h2><?echo i18n("DHCP Server Settings");?></h2>
	<p>
		<?echo i18n("Use this section to configure the built-in DHCP server to assign IP address to the computers on your network.");?>
	</p>
	<div class="textinput">
		<span class="name"><?echo i18n("Enable DHCP Server");?></span>
		<span class="delimiter">:</span>
		<span class="value"><input id="dhcpsvr" type="checkbox" onClick="PAGE.OnClickDHCPSvr();" /></span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("DHCP IP Address Range");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input id="startip" type="text" size="3" maxlength="3" /> to
			<input id="endip" type="text" size="3" maxlength="3" />
			(<?echo i18n("addresses within the LAN subnet");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("DHCP Lease Time");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input id="leasetime" type="text" size="6" maxlength="5" />
			(<?echo i18n("minutes");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("Always broadcast");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input name="broadcast" type="checkbox" id="broadcast" />
			(<?echo i18n("compatibility for some DHCP Clients");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("NetBIOS announcement");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input name="netbios_enable" type="checkbox" id="netbios_enable" onclick="PAGE.on_check_netbios();"/>
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("Learn NetBIOS from WAN");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input name="netbios_learn" type="checkbox" id="netbios_learn" onclick="PAGE.on_check_learn();"/>
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("NetBIOS Scope");?></span>
		<span class="delimiter">:</span>
		<span class="value">			
			<input type="text" id="netbios_scope" name="netbios_scope" size="20" maxlength="30" value=""/>
			(<?echo i18n("optional");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("NetBIOS node type");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input type="radio" name="winstype" value="1" />
			<?echo i18n("Broadcast only");?> (<?echo i18n("use when no WINS servers configured");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"></span>
		<span class="delimiter"></span>
		<span class="value">
			<input type="radio" name="winstype" value="2" />
			<?echo i18n("Point-to-Point");?> (<?echo i18n("no broadcast");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"></span>
		<span class="delimiter"></span>
		<span class="value">
			<input type="radio" name="winstype" value="4" checked />
			<?echo i18n("Mixed-mode");?> (<?echo i18n("Broadcast then Point-to-Point");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"></span>
		<span class="delimiter"></span>
		<span class="value">
			<input type="radio" name="winstype" value="8" />
			<?echo i18n("Hybrid");?> (<?echo i18n("Point-to-Point then Broadcast");?>)
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("Primary WINS IP Address");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input type="text" id="primarywins" size="20" maxlength="15" value="">
		</span>
	</div>
	<div class="textinput">
		<span class="name"><?echo i18n("Secondary WINS IP Address");?></span>
		<span class="delimiter">:</span>
		<span class="value">
			<input type="text" id="secondarywins" size="20" maxlength="15" value="">
		</span>
	</div>
	<div class="gap"></div>
</div>
<div class="blackbox">
	<h2><?echo i18n("Add DHCP Reservation");?></h2>
		<div class="textinput">
			<span class="name"><?echo i18n("Enable");?></span>
			<span class="delimiter">:</span>
			<span class="value"><input type="checkbox" id="en_dhcp_reserv"></span>
		</div>
		<div class="textinput">
			<span class="name"><?echo i18n("Computer Name");?></span>
			<span class="delimiter">:</span>
			<span class="value"><input type="text" id="reserv_host" maxlength="60" size="25">						
			<input type="button" value="<<" class="arrow" onclick="PAGE.OnChangeGetClient();" />
				<? DRAW_select_dhcpclist("LAN-1","pc", i18n("Computer Name"), "",  "", "1", "broad"); ?>
			</span>		
		</div>
		<div class="textinput">
			<span class="name"><?echo i18n("IP Address");?></span>
			<span class="delimiter">:</span>
			<span class="value"><input type="text" id="reserv_ipaddr" maxlength="60" size="25"></span>
		</div>
		<div class="textinput">
			<span class="name"><?echo i18n("MAC Address");?></span>
			<span class="delimiter">:</span>
			<span class="value"><input type="text" id="reserv_macaddr" maxlength="17" size="25"></span>
		</div>
		<div class="textinput">
			<span class="name"></span>
			<span class="delimiter"></span>
			<span class="value"><input id="ipv4_mac_button" type="button" value="<?echo I18N("h","Clone Your PC's MAC Address");?>" onclick="PAGE.OnClickMacButton('reserv_macaddr');" /></span>
		</div>
		<div class="textinput">
			<span class="name"></span>
			<span class="delimiter"></span>
			<span class="value">
				<input type="button" value="<?echo i18n("Add / Update");?>" onclick="PAGE.AddDHCPReserv();" />
				<input type="button" value="<?echo i18n("Clear");?>" onclick="PAGE.ClearDHCPReserv();" />
			</span>				
		</div>
		<div class="gap"></div>
</div>		
<div class="blackbox">
	<h2><?echo i18n("DHCP Reservations List");?></h2>
	<div class="centerline">
		<table id="reserves_list" class="general" width="535px">
		<tr>
			<th width="50px"><?echo i18n("Enable");?></th>
			<th width="100px"><?echo i18n("Host Name");?></th>
			<th width="115px"><?echo i18n("IP Address");?></th>
			<th width="115px"><?echo i18n("MAC Address");?></th>			
			<th width="30px"></th>			
			<th width="30px"></th>
		</tr>
		</table>
	</div>
	<div class="gap"></div>
</div>
<div class="blackbox">
	<h2><?echo i18n("Number of Dynamic DHCP Clients");?></h2>
	<div class="centerline" align="center">
		<table id="leases_list" class="general">
		<tr>
			<th width="200px"><?echo i18n("Host Name");?></th>
			<th width="100px"><?echo i18n("IP Address");?></th>
			<th width="105px"><?echo i18n("MAC Address");?></th>
			<th width="95px"><?echo i18n("Expired Time");?></th>
		</tr>
		</table>
	</div>
	<div class="gap"></div>
</div>

<p><input type="button" value="<?echo i18n("Save Settings");?>" onClick="BODY.OnSubmit();" />
<input type="button" value="<?echo i18n("Don't Save Settings");?>" onClick="BODY.OnReload();" /></p>
</form>
