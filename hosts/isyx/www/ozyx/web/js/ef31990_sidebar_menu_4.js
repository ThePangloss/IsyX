function initMenu() {
  $(".submenuQsj").hide();
  $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
        if($("#menu-toggle").text() == "  Afficher le menu") {
            $(".btn-custom").html('<span class="glyphicon glyphicon-indent-right fa-lg"><b style="font-family: Brushsci;font-size:30px;">  Cacher le menu</span>');
            return false;
        }else{
            $(".btn-custom").html('<span class="glyphicon glyphicon-indent-left fa-lg"><b style="font-family: Brushsci;font-size:30px;">  Afficher le menu</span>');
            return false;
        }
  });

  //Sous menu du Slide menu pronciapl
      $('.menuParentQsj').click(function() {
           $('.submenuQsj').toggle('visible');
       });
}
$(document).ready(function() {initMenu();});
/*
//Slide menu principal
    $('.btn-custom').click(
        function(e) {
          e.preventDefault();
          if($("#menu-toggle-2").text() == "  Afficher le menu") {
              $("#wrapper").toggleClass("toggled-2");
              $('#insidenavbar').show("400");
              
              $("#wrapper").removeClass("none");
              $("#wrapper").addClass("col-md-2");
              //$('#wrapper').css('height','135%');
              //$('#sidebar-wrapper').css('top', '0%');
              $("#content").addClass('col-md-10 col-md-offset-2').removeClass('col-md-12');

              $(".btn-custom").html('<span class="glyphicon glyphicon-indent-right fa-lg"><b style="font-family: Brushsci;font-size:30px;">  Cacher le menu</span>');
              return false;

            }else{
              $("#wrapper").toggleClass("toggled-2");
              //Pour changer un attribut css
              //$('#insidenavbar').css('position','');
              $('#insidenavbar').hide("400");
              
              $("#wrapper").removeClass("col-md-2");
              $("#wrapper").addClass('none')
              //$('#wrapper').css('height','0px');
              $("#content").addClass('col-md-12').removeClass('col-md-10').removeClass('col-md-offset-2');

              $(".btn-custom").html('<span class="glyphicon glyphicon-indent-left fa-lg"><b style="font-family: Brushsci;font-size:30px;">  Afficher le menu</span>');
              return false;
            }
        }
      );
    
    
function initMenu() {
//$(".submenuQsj").hide();
//Sous menu du Slide menu pronciapl
    $('.menuParentQsj').click(function() {
         $('.submenuQsj').toggle('visible');
     });
}
$(document).ready(function() {initMenu();});
*/