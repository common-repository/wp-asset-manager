<h1>Custom Scripts</h1>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(document).ready(function(){
    $("#sortable").sortable({
        stop : function(event, ui){

          var datastr = [];

          $('input[name=source_order]').each(function(){

            var source = $(this).val();

            datastr.push(source);

          });

          $.ajax({
            url: '/wp-content/plugins/wp-asset-manager/reorder-scripts.php',
            type : 'POST',
            data : { order : datastr },
            success: function(msg){
              if (msg == 1){
                $('.msg-success').show(0).delay(2000).hide(0);
              } else {
                $('.msg-error').show(0).delay(2000).hide(0);
              }
            }
          });

        }
    });
  $("#sortable").disableSelection();
});//ready
</script>

<style>
h1 { background: url('/wp-content/plugins/wp-asset-manager/page_icon.png') no-repeat; left center; padding: 0 0 0 40px; font-size: 30px; line-height: 30px; color:#dd5136; }
input.fullwidth { width:600px; padding:5px; }
.form_wrap { float:left; margin: 0 0 20px 0; }
input[type=submit] { background: #dd5136; border:0; color:#fff; padding: 10px; border-radius: 2px; cursor: pointer; }
a.btn { background: #dd5136; padding: 2px 5px; color: #fff; text-decoration: none; border: 0; border-radius: 2px; }
table tr th { background: #222; color:#fff!important; }
.drag { cursor: pointer; }
.msg-error, .msg-success { display: none; }
.msg-error p, .msg-success p { margin: 0px; padding: 0px; }
.msg-error p a, .msg-success p a { color:red; text-decoration: underline; }
.msg-error { border: 1px solid red; color: red; padding: 1%; margin: 0 0 10px 0; float: left; }
.msg-success { border: 1px solid green; color: green; padding: 1%; margin: 0 0 10px 0; float: left; }
</style>

<?php

$all_scripts = get_option('_wp_custom_script');
$all_scripts = unserialize($all_scripts);

//print_r($all_scripts); exit;

$empty_msg = FALSE;
$url_msg = FALSE;
$success_msg = FALSE;

////////////////////////////////////////
//
// ADD SCRIPT
//
////////////////////////////////////////

if (isset($_POST['submit_scripts'])){

  $post_data = isset($_POST['custom_src']) && !empty($_POST['custom_src']) ? $_POST['custom_src'] : '' ;

  if (empty($post_data)){

    $empty_msg = TRUE;

  } else {

    if (filter_var($post_data, FILTER_VALIDATE_URL) === FALSE) {

      $url_msg = TRUE;
    
    } else {

      if(strpos($post_data, "http://") !== false){

        $all_scripts[] = $post_data;

        $_clean_array = serialize($all_scripts);

        update_option('_wp_custom_script',$_clean_array);

        $success_msg = TRUE;

      } else {

        $all_scripts[] = str_replace('https:','',$post_data);

        $_clean_array = serialize($all_scripts);

        update_option('_wp_custom_script',$_clean_array);

        //add_option('_wp_custom_script',$_clean_data,'','yes');

        $success_msg = TRUE;

      }

    }

  }

}

////////////////////////////////////////
//
// DELETE SCRIPT
//
////////////////////////////////////////

if (isset($_GET['id'])){

  $update_script = array();

  $i= 1; foreach ($all_scripts as $script): 

    if ($i != $_GET['id']):

      $update_script[] = $script;

    endif;

  $i++; endforeach;

  $_clean_array = serialize($update_script);

  update_option('_wp_custom_script',$_clean_array);

  echo "<script>window.top.location = '/wp-admin/admin.php?page=custom-scripts';</script>"; exit;

}

?>

<?php if (isset($url_msg) && $url_msg != FALSE){ ?><div class="error"><p>Please enter a valid URL</p></div><?php } ?>
<?php if (isset($empty_msg) && $empty_msg != FALSE){ ?><div class="error"><p>URL field is empty</p></div><?php } ?>
<?php if (isset($success_msg) && $success_msg != FALSE){ ?><div id="message"><p>New custom script saved</p></div><?php } ?>

<div class="form_wrap">

<p>Please follow me on Twitter <a href="https://www.twitter.com/johnburns87" target="_blank">@johnburns87</a> <a href="https://www.twitter.com/WPAssetManager" target="_blank">@WPAssetManager</a>. Post any bugs or suggestions to <a href="http://wordpress.org/support/plugin/wp-asset-manager" target="_blank">http://wordpress.org/support/plugin/wp-asset-manager</a></p>

<form method="post">

  <table class="wp-list-table widefat fixed pages" cellspacing="0">
    <thead>
      <tr>
        <th>Add Source</th>
      </tr>
    </thead>
    <tbody id="the-list">
      <tr valign="center">
        <td>
            <input name="custom_src" id="custom_src" value="" class="fullwidth" placeholder="eg. https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"/>
        </td>        
      </tr>
      <tr>
        <td>
          <input type="submit" name="submit_scripts" value="Add Script" />
        </td>
      </tr>
    </tbody>
  </table>

</form>
</div>

<?php if (!empty($all_scripts)){  ?>
<div class="form_wrap">

<div class="msg-error"><p>Opps something went wrong, drop me a <a href="http://wordpress.org/support/plugin/wp-asset-manager" target="_blank">support ticket</a> and I will fix it soon!</p></div>

<div class="msg-success"><p>New order saved!</p></div>

<form method="post">

  <table class="wp-list-table widefat fixed pages" cellspacing="0">
    <thead>
      <tr>
        <th width="2">Reorder</th>
        <th width="200">Scripts</th>
        <th width="10">Action</th>
      </tr>
    </thead>

    <tbody id="sortable">
      <?php $ii = 1; foreach ($all_scripts as $script): ?>
      <tr id="set_<?php echo $ii; ?>" valign="center">
        <td class="drag"><img src="/wp-content/plugins/wp-asset-manager/reorder.png" border="0"/></td>
        <td>
            <label for="custom_src"><a href="<?php echo $script; ?>" target="_blank"><?php echo $script; ?></a></label>
            <input type="hidden" name="source_order" value="<?php echo $script; ?>"/>
        </td>
        <td>
          <a class="btn" href="/wp-admin/admin.php?page=custom-scripts&id=<?php echo $ii; ?>">Remove</a>
        </td>        
      </tr>
    <?php $ii++; endforeach; ?>
    </tbody>
  </table>

</form>
</div>
<?php } ?>