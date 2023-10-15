var prevX = 0;
var prevY = 0;
var posX = "-50%";
var posY = "-50%";
var movedUp = false;
var movedLeft = false;


// EVENT HANDLERS
$( ".move-background" ).hover(function( event ) {
  prevX = event.pageX;
  prevY = event.pageY;
}, null);

$( ".move-background" ).mousemove(function( event ) {
  moveBackground(event);
});

// PARALLAX BACKGROUND EFFECT
function moveBackground( event ) {

  directionMoved( event );
  
  posX = (movedLeft) ? "-49%" : "-51%";
  posY = (movedUp) ? "-49%" : "-51%";
  
  $(".background").css({"-webkit-transform":"translate("+ posX + ","+posY+")"});
  
  prevX = event.pageX;
  prevY = event.pageY;
}

function directionMoved(event)
{
  movedLeft = (prevX > event.pageX) ? true : false;
  movedUp = (prevY > event.pageY) ? true : false;
}
