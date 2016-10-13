/*
var myVarZoom=setInterval(function(){zoomFucnt();comp()},100);
//$("#content").removeClass("contentShow");
function zoomFucnt () {
	var zoom = document.documentElement.clientWidth / window.innerWidth;
		$(window).resize(function() {
		    var zoomNew = document.documentElement.clientWidth / window.innerWidth;
		    if (zoom != zoomNew) {
		        // zoom has changed
		        // adjust your fixed element
		        zoom = zoomNew
		        //$( "#getw" ).text(zoom);contentFWidth
		        if (zoom<'0.99140625') {
		     		  //$("#wrapper").slideUp( "fast", function() {});
		     		  //$("#wrapper").toggleClass("toggled");
		     		  $("#wrapper").hide();
					  $("#headerSlide").slideUp("fast", function() {});
 					  $("#footerSlide").slideUp("fast", function() {});
 					  //$("#content").removeClass("content");
 					  //$("#content").addClass("contentFWidth");
		        };
		       	if (zoom>'0.99240625') {
  		     		  //$("#wrapper").show( "fast", function() {});
  		     		  //$("#wrapper").toggleClass("toggled");
  		     		  $("#wrapper").show();
					  $("#headerSlide").show( "fast", function() {});
 					  $("#footerSlide").show( "fast", function() {});
  		     		  //$("#content").removeClass("contentFWidth");
  		     		  //$("#content").addClass("content");

		        };
		    }
		});
}

/*Pour obtenir le width de la page
function showWidth( ele, w ) {
  $( "div" ).text( "The width for the " + ele + " is " + w + "px." );
}
$("#getw").click(function() {
  showWidth( "window", $( window ).width() );
});
*/