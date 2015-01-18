<?php 
    
   if(isset($_POST["addTopic"])) {
    //echo "we are here";
        global $wpdb;
        $table_name = $wpdb->prefix . "2s_debate_topics";
        $table_name2 = $wpdb->prefix . "2s_tags";
        $table_name3 = $wpdb->prefix . "2s_topic_tags";
        $query="insert into $table_name set created_on=NOW(),topic='$_POST[topic]',uid='".get_current_user_id( )."',image='$_POST[upload_image_template]'";
        $wpdb->query($query);
        $lastid = $wpdb->insert_id;
        $tags = $_POST["tags"];
        $tags_array = explode(",",$tags);
        foreach($tags_array as $key=>$val){
            $query1="insert into $table_name2 set tcreated_on=NOW(),tgname='$val',tpcount='1'";
            $wpdb->query($query1);
            $lasttagid = $wpdb->insert_id;
            $query2="insert into $table_name3 set tid='$lastid',tgid='$lasttagid'";
            $wpdb->query($query2);
        }
        echo "<b style='color:green'>Topic Added Successfully</b>";
    }
   // add_action( 'in_admin_footer', 'child_theme_footer_script' );
    //echo "<link rel='stylesheet' href='".plugins_url('css/style.css',__FILE__ )."'>";
    wp_enqueue_script( 'media-upload');

?>
<div class="wrap">
    <fieldset>
    <legend>Add Topic Here</legend>
    <form method="post" action=""> 
        
        <form action="" method="post" class="col-sm-12" enctype="multipart/form-data">
            <table><tr><td>Topic Name :</td><td> <input type="text"  name="topic" class="col-sm-12" style="width:100% !important;"> </td></tr>
              <tr><td>Tags : </td><td><input id="inputTagator" name="tags"  style="width:100% !important;"> <br> </td></tr>
              <tr>
                <td>Image : </td>
                <td>
                   <input id="upload_image"  type="text" size="36" name="upload_image_template" value="<?php echo get_option('upload_image_template'); ?>" />
                   <input id="upload_image_button" type="button" value="Browse" />
                </td>
              </tr>

              <tr><td></td><td><input type="submit" class="btn btn-success pull-right" name="addTopic" value="Add Topic"></td></tr></table>
        </form>
        <br style='clear:both'>
        
    </form>
</fieldset>
</div>    
<?php //echo "<script src='".plugins_url('js/responsive.js',__FILE__ )."'></script>"; ?>

<?php  echo "<script type='text/javascript' src='".plugins_url('../js/jquery.js',__FILE__ )."'></script>"; ?>
<?php  echo "<script type='text/javascript' src='".plugins_url('../js/tags.js',__FILE__ )."'></script>"; ?>
<?php  echo "<link rel='stylesheet' href='".plugins_url('../css/tags.css',__FILE__ )."'></script>"; ?>

<script>
$(function () {

      $('#inputTagator').tagator({
        autocomplete: ['test1','test2','test3']
      });
      
  });

$(document).ready(function($) {
    $('#upload_image_button').click(function() {
        formfield = $('#upload_image').attr('name');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    });

    window.send_to_editor = function(html) {
        imgurl = $('img', html).attr('src');
        $('#upload_image').val(imgurl);
        tb_remove();
    };

});

</script>


