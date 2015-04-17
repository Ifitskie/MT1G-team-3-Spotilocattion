$(document).ready(function(){
    $(".playlist").each(function(){
        console.log ($(this).attr("id"));
        var id = $(this).attr("id");
        $(this).click(function (){
            window.location = "?playlist="+id;
        });
    });
});

//<div id="playlist1" class="playlist"></div>
//<div id="playlist2" class="playlist"></div>
//    if(isset($_GET['playlist'])){
//        sla op in database
//
//        got to map
//        }