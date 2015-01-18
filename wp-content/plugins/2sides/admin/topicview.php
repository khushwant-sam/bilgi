<?php 
global $wpdb;
         $table_name = $wpdb->prefix . "2s_debate_topics";
          $table_name_1 = $wpdb->prefix . "2s_contributions";
        if($_POST["add_contri"]){
         // print_r($_POST);
          $type = $_POST["type"];
          $contri = $_POST["contri"];
          $tid = $_GET["ref"];
         //echo "insert into $table_name_1 set contribution = '$contri' , uid ='".get_current_user_id()."' , tid ='$tid',type='$type',created_on =NOW()";
          $query = "insert into $table_name_1 set contribution = '$contri' , uid ='".get_current_user_id()."' , tid ='$tid',type='$type',created_on =NOW()";
          $wpdb->query($query); 
          $data_ag = $wpdb->get_results(  "SELECT agree_comments,disagree_comments FROM $table_name WHERE tid='$tid';" );
          //print_r($data_ag);

          $agree_comments_1 = intval($data_ag[0]->agree_comments); $agree_comments_1++;
          $disagree_comments_1 = intval($data_ag[0]->disagree_comments); $disagree_comments_1++;
          //echo $agree_comments.$disagree_comments;
          if($type == 1)
            $wpdb->update($table_name,array( 'agree_comments' => $agree_comments_1),array("tid"=>$tid)); 
          else
            $wpdb->update($table_name,array( 'disagree_comments' => $disagree_comments_1),array("tid"=>$tid)); 
          //header("HTTP/1.1 302 Found");
      echo "<script> location.href = '$_SERVER[REQUEST_URI]' ; </script>";
      exit;
        }

        $query="SELECT *,(agree/(agree+disagree)*100) AS agree_per,(disagree/(agree+disagree)*100) AS disagree_per FROM $table_name WHERE tid = $_GET[ref]";
        $data = $wpdb->get_results($query);
       //print_r($data);
?>
<?php  // echo "<script type='text/javascript' src='".plugins_url('../bootstrap/assets/js/ie-emulation-modes-warning.js',__FILE__ )."'></script>"; ?>
<?php  // echo "<link rel='stylesheet' href='".plugins_url('../bootstrap/dist/css/bootstrap.min.css',__FILE__ )."'></script>"; ?>
<?php  // echo "<link rel='stylesheet' href='".plugins_url('../bootstrap/dist/css/bootstrap-theme.min.css',__FILE__ )."'></script>"; ?>
<?php   echo "<link rel='stylesheet' href='".plugins_url('../css/custom.css',__FILE__ )."'></script>"; ?>
<div id="body">
    <br>
    <table id="main_topic" align="center">
      <?php 

      foreach($data as $key => $val ) { 
      ?> 
      <tr><td align="right"> 
          <span class="badge btn-success">
                        <span aria-hidden="true" class="glyphicon glyphicon-chevron-up"></span>
                        <?= number_format($val->agree_per,'2','.','') ?>% (<?= $val->agree_comments ?>)
                      </span>
                    <span class="badge btn-danger">
                        <span aria-hidden="true" class="glyphicon glyphicon-chevron-down"></span> 
                        <?= number_format($val->disagree_per,'2','.','') ?>% (<?= $val->disagree_comments ?>)
                    </span>
                    &nbsp;&nbsp;&nbsp; 
                </td></tr> 
      <tr>
        <td><h3><?= $val->tid ?> <?= $val->topic ?></h3></td>
        </tr>
        <?php $ag_con = $val->agree_comments; $disag_con =$val->disagree_comments; ?>
        <tr><td style="text-align:center"><button class="btn btn-success agree_add" onclick="add_side(1,<?= $val->tid ?>);">Yes i agree</button> <button class="btn btn-danger disagree_add" onclick="add_side(-1,<?= $val->tid ?>);">No i disagree!!</button></td>
      </tr>
      <?php } ?>
  </table>
  </div>


  <div class="span12 color_bg_com">
          <div id="" class="agree_comments col-sm-6 color_bg_com">
            <br>
            <h3>Agree Contributions ( <?= $ag_con ?> ) </h3>
            <form method="post">
              <?php if(!isset($logged_in))
              echo "<input type='hidden' name='stop' value='stop'><script>var log =0;</script>";
              else
                echo "<script>var log=1;</script>";
               ?>
              <input type="hidden" name="type" value="1">
                
              <textarea cols="24" name="contri" class="form-control"></textarea>
              <br>
              <input type="submit" name="add_contri" value="Contribute" class="form-control btn btn-primary" > 
            </form>
            <br>
            <div class="agree_div"></div>
          </div>
          <div id=""  class="disagree_comments col-sm-6 color_bg_com">
            <br>
            <h3>Disagree Contributions ( <?= $disag_con ?> ) </h3>
            <form method="post">
              <?php if(!isset($logged_in))
              echo "<input type='hidden' name='stop' value='stop'><script>var log =0;</script>";
              else
                echo "<script>var log=1;</script>";
               ?>
              <input type="hidden" name="type" value="0">
                
              <textarea cols="24" name="contri" class="form-control"></textarea>
              <br>
              <input type="submit" name="add_contri" value="Contribute" class="form-control btn btn-primary" > 
            </form>
            <br>
            <div class="disagree_div"></div>
          </div><br style="clear:both">
          <center><button onclick="get_contributions(<?= $_GET['ref']?>);" class="btn btn-primary loadmorecon">Loadmore</button></center>
        </div>


<script type="text/javascript">

jQuery(document).ready(function($){
  get_contributions(<?= $_GET["ref"] ?>);
});
</script>
</script> 
  <?php
//  add_action( 'wp_ajax_my_action', 'my_action_callback' );

//add_action('wp_footer', 'footer_scripts_combine');
 ?>