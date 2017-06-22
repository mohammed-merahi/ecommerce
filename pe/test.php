
<html>
<head></head>
<body>
    

<div class="google-map-section">
    <div class="container-fluid">
        <div class="google-map plr-185">
            <div id="map"></div>
        </div>
    </div>
</div>
    
<iframe width="900" height="510" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=36.252372,6.569417&hl=fr;z=14&amp;output=embed"></iframe>
    <br />
<small><a href="https://maps.google.com/maps?q=36.252372,6.569417&hl=es;z=14&amp;output=embed" style="color:#0000FF;text-align:left" target="_blank">Agrandir</a></small>
    
    
    
 <script>
//LOCATION SCRIPT HERE

        function initialize() {
            var myLatlng = new google.maps.LatLng(36.252372,6.569417 );
            var myOptions = {
                zoom: 8,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
  }
            var map = new google.maps.Map(document.getElementById("map"), myOptions);
}

            function loadScript() {
            var script = document.createElement("script");
                script.type = "text/javascript";
                script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
                document.body.appendChild(script);
}

        window.onload = loadScript;


        //LOCATION SCRIPT ENDS HERE
</script>   
    
</body>
</html>


