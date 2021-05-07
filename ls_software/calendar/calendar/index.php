
<div id='calendar'></div>


    <script>
    $(function() { // document ready

      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },

        editable: false,

        events: 'test.php',



        eventSources: [

            // your event source
            {
                events: [ // put the array in the `events` property


                    {
                        title  : 'Happy Thanksgiving',
                        start  : '2016-11-25',
                        end    : '2016-11-25',
                        imageurl:'img/holiday-icon.png'
                    },

                ],
                color: 'transparent',     // an option!
                textColor: 'black' // an option!
            }

            // any other event sources...

        ],


    eventRender: function(event, eventElement) {
        if (event.imageurl) {
            eventElement.find("div.fc-content").prepend("<img src='" + event.imageurl +"' width='15' height='15'>");
        }
    },



     });
    });


    </script>
