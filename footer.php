
<!--- Footer Menu -->
<ul class="nav nav-pills" style="text-align:center;">
	<li role='presentation'><a target='_Blank' href="https://datastudio.google.com/u/0/reporting/f4919f28-eb01-47d1-8c49-51c343e55f20/page/tBINB">Google Analytics Report</a></li>
	<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/download_zip.php'){ echo "class='active'"; } ?> ><a href="download_zip.php">Download Our Zipcode Data</a></li>

	<li role='presentation'><a target='_Blank' href="https://www.facebook.com/groups/covid19md/">MD Facebook Group</a></li>
	<li role='presentation'><a target='_Blank' href="https://www.reddit.com/r/CoronavirusDMV/">CoronavirusDMV</a></li>
	<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/debug.php'){ echo "class='active'"; } ?> ><a href="debug.php">Raw Data</a></li>
	<li role='presentation'><a target='_Blank' href='https://github.com/insidenothing/coronavirus/blob/master<?PHP echo $_SERVER['SCRIPT_NAME'];?>'>Open Source - Edit <?PHP echo $_SERVER['SCRIPT_NAME'];?> at Github.com</a></li>
	<li role='presentation'><a target='_Blank' href="https://coronavirus.maryland.gov/">Maryland Department of Health</a></li>
	
	<li role='presentation'><a target='_Blank' href="http://www.ciclt.net/sn/clt/capitolimpact/gw_countymap.aspx?State=md&StFIPS=&StName=Maryland">ZIP Data</a></li>
	<li role='presentation'><a target='_Blank' href="http://boinc.bakerlab.org/rosetta/team_display.php?teamid=18832">Fold for Covid</a></li>
	<li role='presentation'><span id="siteseal"><script async type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=JF3ETwtNbyZ345vnJlsp4zh2fEEasPM3vcpVLuhjNIi6TCtnnRaJxL5WiQ5T"></script></span></li>
</ul>

<div class="row"><div class="col-sm-12">&copy 2020 Patrick McGuire</div></div>
<div class="row"><div class="col-sm-12"><h3>Hit Counter</h3><?PHP echo get_hits();?></div><br>---- 5/30/2020 Since we get data starting at 8 - but only zips with cases are in the data set, let's fix all the math issues with zero and start with 1 less than the first number we get, 7</div>


</div><!--- Close Container -->
<script type="text/javascript">
    window.doorbellOptions = {
        "id": "11536",
        "appKey": "Mde6NrqDnof6aohbQDsgmZOMkiHDET5dCBq9zuE1xneMgrAruqnrt3Jm1tYXy9OW"
    };
    (function(w, d, t) {
        var hasLoaded = false;
        function l() { if (hasLoaded) { return; } hasLoaded = true; window.doorbellOptions.windowLoaded = true; var g = d.createElement(t);g.id = 'doorbellScript';g.type = 'text/javascript';g.async = true;g.src = 'https://embed.doorbell.io/button/'+window.doorbellOptions['id']+'?t='+(new Date().getTime());(d.getElementsByTagName('head')[0]||d.getElementsByTagName('body')[0]).appendChild(g); }
        if (w.attachEvent) { w.attachEvent('onload', l); } else if (w.addEventListener) { w.addEventListener('load', l, false); } else { l(); }
        if (d.readyState == 'complete') { l(); }
    }(window, document, 'script'));
</script>
</body>
</html>
