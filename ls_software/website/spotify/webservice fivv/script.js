// funktionen hämtar låtar som spelas just nu och visar förgående låt
function getStationInfo(id, csong, psong){
  $.ajax({
    url: "http://api.sr.se/api/v2/playlists/rightnow?channelid=" + id + "&format=json",
  }).then((...results) => {
        results = results[0].playlist;
      var prevSongTitle = results.previoussong.title;  //förgående låt
        var prevArtist = results.previoussong.artist;  //förgående artist 
        if(typeof results.song !== "undefined"){
            var currentArtist = results.song.artist;   //artist just nu
			var currentSong = results.song.title;	  // sång just nu 
            $(csong).text("CurrentSong: " + currentSong + " - " + currentArtist);
            console.log("current song: " + currentSong + " - " + currentArtist);
        } else {
            $(csong).text("Current Song: Not Available" ) 	//om den inte hittar, visas detta meddelande. 
        }
        $(psong).text("Previous Song: " + prevSongTitle + " - " + prevArtist);
        console.log(prevSongTitle + " - " + prevArtist);
  })
};

// funktionen gör så att varje radiostationerna (p1,p2,p3) expanderas på klick. om användaren klickar igen så krymps den tillbaka. 
var acc = document.getElementsByClassName("Radio");
var i;
for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none"; //minimerar de. 
    } else {
      panel.style.display = "block"; //visar de i block element
    }
  });
}