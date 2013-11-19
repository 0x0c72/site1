<!DOCTYPE html>
<html>
<!-- Piwik --> 
  <script type="text/javascript">
  var pkBaseURL = (("https:" == document.location.protocol) ? "https://chs.no-ip.org/piwik/" : "http://chs.no-ip.org/piwik/");
  document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
  </script><script type="text/javascript">
  try {
  var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
  piwikTracker.trackPageView();
  piwikTracker.enableLinkTracking();
  } catch( err ) {}
  </script><noscript><p><img src="http://chs.no-ip.org/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script>
$(document).ready(function(){
  $("button").click(function(){
    $("#div1").load("mission.txt",function(responseTxt,statusTxt,xhr){
      if(statusTxt=="success")
        alert("External content loaded successfully!");
      if(statusTxt=="error")
        alert("Error: "+xhr.status+": "+xhr.statusText);
    });
  });
  $("#ext").click(function(){
    $("button").hide();
  });
});
</script>
</head>
<body>

<div id="div1"><h2>Let jQuery GET Content</h2></div>
<button id="ext">GET External Content</button>

</body>
</html>
