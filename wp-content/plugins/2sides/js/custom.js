 var cur_page = 1;
    
function get_contributions(tid){
    jQuery(document).ready(function($) {
    var data = {
        action: 'my_action',
        tid: tid,
        page: cur_page      // We pass php values differently!
    };
    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
    $(".loadmorecon").html("Loading....");
    jQuery.post(ajax_object.ajax_url, data, function(data) {
       var data_split = data.split("!8@~!!@!"); 
        var aggree = data_split[0].trim();
        var disaggree = data_split[1].trim();
        $(".agree_div").append(aggree);
        $(".disagree_div").append(disaggree);
        $(".loadmorecon").html("Loadmore");
        if(data_split[2] < 5 && data_split[3] < 5)
          $(".loadmorecon").remove();
        cur_page += 1; 
      //alert(data);// $("#trending-Container").html(data).fadeIn(1000);
    });

}); 
}//end function
