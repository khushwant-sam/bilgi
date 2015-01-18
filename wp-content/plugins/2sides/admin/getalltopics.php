<?php 

global $wpdb;

        $table_name = $wpdb->prefix . "2s_debate_topics";

        

        $query="SELECT *,(agree/(agree+disagree)*100) AS agree_per,(disagree/(agree+disagree)*100) AS disagree_per FROM $table_name ORDER BY RAND() LIMIT 6";

        $data = $wpdb->get_results($query);

       

?>

<?php  // echo "<script type='text/javascript' src='".plugins_url('../bootstrap/assets/js/ie-emulation-modes-warning.js',__FILE__ )."'></script>"; ?>

<?php  // echo "<link rel='stylesheet' href='".plugins_url('../bootstrap/dist/css/bootstrap.min.css',__FILE__ )."'></script>"; ?>

<?php  // echo "<link rel='stylesheet' href='".plugins_url('../bootstrap/dist/css/bootstrap-theme.min.css',__FILE__ )."'></script>"; ?>

<?php   echo "<link rel='stylesheet' href='".plugins_url('../css/custom.css',__FILE__ )."'></script>"; ?>

<div class="col-sm-12">

 <?php foreach($data as $key => $val ) { ?>

<div class="col-sm-6 col-md-4 home_box" style="position:relative">

  <div style="position:absolute; float:left; right:10px;">

    <span class="badge btn-danger">

      <span aria-hidden="true" class="glyphicon glyphicon-chevron-down"></span> 

      <?php echo number_format($val->disagree_per,'2','.','') ?>%

    </span>

    </div> 

    <div style="position:absolute; float:right;">

    <span class="badge btn-success">

      <span aria-hidden="true" class="glyphicon glyphicon-chevron-up"></span>

     <?php echo number_format($val->agree_per,'2','.','') ?>%

    </span>

  </div>

  <div class="thumbnail">

    <img data-src="holder.js/300x300" src="<?php echo $val->image ?>" alt="..." style="width: 300px; height:200px;">

    <span style="position:absolute; right:20px;"><b><?php echo date("d-M, Y",strtotime($val->created_on)) ?></b></span>

    <div class="caption" style="top:7px; position:relative">

      <?php 

      if (strlen($val->topic) > 40) 

        $val->topic = substr($val->topic, 0, 40)."....."; ?>



      <p style="font-size:15px; height:44px"><?php echo $val->topic ?></p>

      

      <a href="<?php echo $_SERVER["REQUEST_URI"]."?ref=".$val->tid ; ?>">

        <button class="btn full btn-primary btn-sm" type="button" aria-expanded="false">

          View Topic

        </button>

      </a>

    </div>

  </div>

</div>

<?php } ?>

</div>