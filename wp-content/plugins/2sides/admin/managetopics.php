<?php 

    

        global $wpdb;

        $table_name = $wpdb->prefix . "2s_debate_topics";

        $table_name2 = $wpdb->prefix . "2s_tags";

        $table_name3 = $wpdb->prefix . "2s_topic_tags";
        $query="select *,(select count(tid) from $table_name3 as tb1 where tb1.tid = $table_name.tid ) as tagcount from $table_name";

        $data = $wpdb->get_results($query);
?>

<div class="wrap">

    <fieldset>

    <h2>Topics </h2>

    <form method="post" action=""> 

        <table class="widefat fixed" cellspacing="0" style="text-align: center">

            <thead>

            <tr>



                    <th id="cb" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th> 

                    <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 40%">Title</th>

                    <th id="columnname" class="manage-column column-columnname num" scope="col">User</th> 

                    <th id="columnname" class="manage-column column-columnname num" scope="col"><span title="Comments" class="comment-grey-bubble"></span></th> 

                    <th id="columnname" class="manage-column column-columnname num" scope="col">Approved</th> 

                    <th id="columnname" class="manage-column column-columnname num" scope="col">Disapproved</th> 

                    <th id="columnname" class="manage-column column-columnname num" scope="col">Date</th>



            </tr>

            </thead>



            <tfoot>

            <tr>



                   <th id="cb" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th> 

                    <th id="columnname" class="manage-column column-columnname" scope="col">Title</th>

                    <th id="columnname" class="manage-column column-columnname num" scope="col">User</th> 

                    <th id="columnname" class="manage-column column-columnname num" scope="col"><span title="Comments" class="comment-grey-bubble"></span></th> 

                    <th id="columnname" class="manage-column column-columnname num" scope="col">Approved</th> 

                    <th id="columnname" class="manage-column column-columnname num" scope="col">Disapproved</th> 

                    <th id="columnname" class="manage-column column-columnname num" scope="col">Date</th>



            </tr>

            </tfoot>



            <tbody>

                <?php

                foreach($data as $key => $val){ 

                $userinfo = get_userdata($val->uid);



                //echo "<tr><td>".($key+1)."</td><td>".$val->topic."</td><td>".$userinfo->data->user_nicename."</td><td>".date("d-M Y",strtotime($val->created_on))."</td></tr>";

               ?>

                <tr class="<?php if($key%2 == 0) echo 'alternate';?>" valign="top"> 

                    <th class="check-column" scope="row"><input type="checkbox"></th>

                    <td class="column-columnname">

                        <?php echo $val->topic ;?>

                        <div class="row-actions">

                            <span><a href="#">Edit</a> |</span>

                            <span><a href="#">Trash</a></span>

                        </div>

                    </td>

                    <td><?php echo $userinfo->data->user_nicename; ?></td>

                    <td><?php echo $val->agree_comments+$val->disagree_comments; ?></td>

                    <td><?php echo $val->agree; ?></td>

                    <td><?php echo $val->disagree; ?></td>

                    <td class="column-columnname"><?php echo date("d-M Y",strtotime($val->created_on));?></td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

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





