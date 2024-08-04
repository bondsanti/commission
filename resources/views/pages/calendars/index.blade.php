@extends('layouts.loged')
@section('title', 'Calendars')
@push('css')
<link href="/assets/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" media='print' />
<link href="/assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" />
@endpush
@section('content')

<div class="container">

    <div id="calendar" class="vertical-box-column calendar"></div>
</div>
@endsection
@push('scripts')
<script src="/assets/plugins/moment/moment.js"></script>
<script src="/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
{{-- <script src="/assets/js/demo/calendar.demo.js"></script> --}}

<script>
    $(document).ready(function() {
        Calendar.init();

    });

var handleCalendarDemo = function (data) {
    let user = "{{ Auth::user()->role()->name }}"
    $('#external-events .fc-event').each(function () {

        $(this).data('event', {
            title: $.trim($(this).text()), // use the element's text as the event title
            stick: true, // maintain when user navigates (see docs on the renderEvent method)
            color: ($(this).attr('data-color')) ? $(this).attr('data-color') : ''
        });
        // $(this).draggable({
        //     zIndex: 999,
        //     revert: true,      // will cause the event to go back to its
        //     revertDuration: 0  //  original position after the drag
        // });
    });


    $('#calendar').fullCalendar({
        header: {
            left: 'month,agendaWeek,agendaDay',
            center: 'title',
            right: 'prev,today,next '
        },
        droppable: true, // this allows things to be dropped onto the calendar,
        dropAccept: '.cool-event',
        drop: function () {
            $(this).remove();
        },
        selectable:  ( user == 'Admin' ) ? true : false,
        selectHelper: true,
        select: function (start, end) {

            var title = prompt('Event Title:');
            var eventData;
            if (title) {
                eventData = {
                    title: title,
                    start: start,
                    end: end
                };

            axios.post(`/api/calendars`, eventData).then( res => {
                // eventData.push({id:res.data.id})
                eventData = {
                        title: title,
                        start: start,
                        end: end,
                        id: res.data.id
                };
                $('#calendar').fullCalendar('renderEvent', eventData, false);
            })

            }
            $('#calendar').fullCalendar('unselect');
        },
        editable: true,
        eventDrop:function( event,start, end){
               if(user != 'Admin'){ return ;}
            eventData = {
            start: event.start,
            end: event.end,
            id: event.id
            };
            axios.put(`/api/calendar/${event.id}`, eventData);
        },
        eventClick:function(event){
            if(user != 'Admin'){ return ;}

            if( confirm('กรุณายืนยันการลบ') ){

            $("#calendar").fullCalendar('removeEventSource', event._id)
            $(this).remove();

            axios.delete(`/api/calendar/${event.id}`);

            }
        },
        eventLimit: true, // allow "more" link when too many events
        events: data
    });

    // $("#calendar").fullCalendar('removeEventSources',1)
    // $("#calendar").fullCalendar('removeEventSource')
};

var Calendar = function () {
    "use strict";
    return {
        //main function
        init: function () {
            let data = [];


            axios.get(`api/calendars`).then( res =>{

                    for (let index = 0; index < res.data.length; index++) {
                        const element = res.data[index];
                        data.push({
                        title : res.data[index]['title'],
                        start : res.data[index]['from'],
                        id : res.data[index]['id'],
                        end: (res.data[index]['to'] ) ? res.data[index]['to'] : '',
                        color :"#F7A236",
                        });
                    }
                handleCalendarDemo(data);
            })
        }
    };
}();

</script>
@endpush
