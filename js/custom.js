

// When an alert is clicked, do something
$('a.close').click(function(event){
    event.preventDefault();
    var heading = $(this).parent().attr('data-heading');
    var body = $(this).parent().attr('data-body');    
});

// To start off with    
halfScreen();

// On Document Load
$(document).ready(function() {
    halfScreen();
    var mainInterval=setInterval(function(){flashAlerts()},10000);
});

// On Document Resize
$(window).resize(function() {
    halfScreen();
});

// Devide the screen properly
function halfScreen()
{
    var getDocHeight = $(window).height();
    $('.alertHolder').css({'height': getDocHeight-40}).height(getDocHeight-40);
}

// This function will be used to create a flash alert for issues. 
function flashAlerts()
{
    var fadeValue = 100;
    $('div.alert').each(function(item, val){
        $(this).fadeTo(fadeValue, 0).fadeTo(fadeValue, 1).fadeTo(fadeValue, 0).fadeTo(fadeValue, 1).fadeTo(fadeValue, 0).fadeTo(fadeValue, 1).fadeTo(fadeValue, 0).fadeTo(fadeValue, 1).fadeTo(fadeValue, 0).fadeTo(fadeValue, 1);       
    });
}

// This is the bees knees when it comes to graphing
$('.graph').each(function(){    
    var holder = $(this).children('.holder');
    var graph = $(this).attr('data');
    var goal = $(this).attr('goal');
    
    // Get the labels
    $.getJSON("graph.php", {'action': 'labels', 'render' : graph }, function(getLabels){        
        
        // Then get the graph
        $.getJSON("graph.php", {'action': 'morris', 'render' : graph } ,function(getData){        
            new Morris.Line({
                // ID of the element in which to draw the chart.
                element: holder,
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: getData,
                xkey: ['period'],
                ykeys: getLabels,
                labels: getLabels,
                units: 's',
                goals: [goal],
                hideHover: 'auto',
                continuousLine: true,
            }); 
        });
    });
});
