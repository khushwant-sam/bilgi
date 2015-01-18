<?php defined('MYARCADE_VERSION') or die(); ?>
<?php ?>
<div id="importswfdcr">
 <h2><?php _e("Add SWF or DCR Game", 'myarcadeplugin'); ?></h2>
 <h2 class="box"><?php _e("Game Files", 'myarcadeplugin'); ?></h2>

<form method="post" enctype="multipart/form-data" id="uploadFormSWF">
  <input type="hidden" name="upload" value="swf" />

  <div class="container">
    <div class="block">
      <table class="optiontable" width="100%">
        <tr>
          <td><h3><?php _e("Game File", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
        </tr>
        <tr>
          <td><p style="margin-bottom:10px"><?php _e("Important: A game file must be added prior to completing the other steps.", 'myarcadeplugin'); ?></p></td>
        </tr>
        <tr>
          <td>
          <p style="font-style:italic;margin:5px 0;"><?php _e("Select a game file from your local computer (swf or dcr).", 'myarcadeplugin'); ?></p>
           <?php _e("Local File:", 'myarcadeplugin'); ?> <input type="file" size="50" id="gamefile" name="gamefile" />  <strong><span id="lblgamefile"></span></strong>
          </td>
        </tr>
        <tr>
          <td>
             <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> select an already uploaded file to (games/uploads/swf).", 'myarcadeplugin'); ?></p>
            <div id="swf" style="min-height:30px">
              <img class="loadimg" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none" />
              <input type="button" id="folderswf" class="button-secondary fileselection" value="<?php _e("Select from folder", 'myarcadeplugin'); ?>" />
              <input type="button" class="button-secondary cancelselection" value="<?php _e("Cancel", 'myarcadeplugin'); ?>" style="display:none" />
            </div>
          </td>
        </tr>
        <tr>
          <td>
             <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> paste a URL to import a game file from the internet( swf or dcr).", 'myarcadeplugin'); ?></p>
            <?php _e("URL:", 'myarcadeplugin'); ?> <input name="gameurl" id="gameurl" type="text" size="50" />
          </td>
        </tr>
        <tr>
        <td>
          <p>
            <input type="submit" class="button button-primary" class="button button-primary" id="swfupload" name="swfupload" value="<?php _e('Add File', 'myarcadeplugin'); ?>" />
          </p>
          <img id="loadimgswf" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none;" />
          <div id="filename"></div>
        </td>
        </tr>
      </table>
    </div>
  </div>
</form>
</div>

<?php
 ?>
<div id="importibparcade">
  <?php ?>
     <h2><?php _e("Add IBPArcade Game", 'myarcadeplugin'); ?></h2>
     <h2 class="box"><?php _e("Game Files", 'myarcadeplugin'); ?></h2>
    <form method="post" enctype="multipart/form-data" id="uploadFormTAR">
      <input type="hidden" name="upload" value="tar" />

      <div class="container">
        <div class="block">
          <table class="optiontable" width="100%">
            <tr>
              <td><h3><?php _e("IBPArcade TAR File", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
            </tr>
            <tr>
              <td><p style="margin-bottom:10px"><?php _e("Important: An IBPArcade file must be added prior to completing the other steps.", 'myarcadeplugin'); ?></p></td>
            </tr>
            <tr>
              <td>
              <p style="font-style:italic;margin:5px 0;"><?php _e("Select an IBPArcade file from your local computer (TAR).", 'myarcadeplugin'); ?></p>
               <?php _e("Local File:", 'myarcadeplugin'); ?> <input type="file" size="50" name="tarfile" id="tarfile" /> <strong><span id="lbltarfile"></span></strong>
              </td>
            </tr>
            <tr>
              <td>
                 <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> select an already uploaded file to (games/uploads/ibparcade).", 'myarcadeplugin'); ?></p>
                <div id="ibparcade" style="min-height:30px">
                  <img class="loadimg" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none" />
                  <input type="button" id="folderibparcade" class="button-secondary fileselection" value="<?php _e("Select from folder", 'myarcadeplugin'); ?>" />
                  <input type="button" class="button-secondary cancelselection" value="<?php _e("Cancel", 'myarcadeplugin'); ?>" style="display:none" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                 <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> paste a URL to import an IBPArcade game from the internet (TAR).", 'myarcadeplugin'); ?></p>
                <?php _e("URL:", 'myarcadeplugin'); ?> <input name="tarurl" type="text" size="50" />
              </td>
            </tr>
            <tr>
            <td>
              <p>
                <input type="submit" class="button button-primary" class="button button-primary" id="tarupload" name="tarupload" value="<?php _e('Add File', 'myarcadeplugin'); ?>" />
              </p>
              <img id="loadimgtar" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none;" />
              <div id="filenametar"></div>
            </td>
            </tr>
          </table>
        </div>
      </div>
    </form>
  </div>

<?php
 ?>
<div id="importphpbb">
  <?php ?>
     <h2><?php _e("Add ZIP Game (PHPBB, Mochi) ", 'myarcadeplugin'); ?></h2>
     <h2 class="box"><?php _e("Game Files", 'myarcadeplugin'); ?></h2>
    <form method="post" enctype="multipart/form-data" id="uploadFormZIP">
      <input type="hidden" name="upload" value="phpbb" />

      <div class="container">
        <div class="block">
          <table class="optiontable" width="100%">
            <tr>
              <td><h3><?php _e("Import ZIP File (PHPBB / Mochi)", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
            </tr>
            <tr>
                <td><p style="margin-bottom:10px"><p><?php _e("Import a PHPBB, Mochi Game or a ZIP file. The ZIP file should contain a swf file and a thumbnail image.", 'myarcadeplugin') ?></p><?php _e("Important: add a ZIP file first before you do anything else.", 'myarcadeplugin'); ?></p></td>
            </tr>
            <tr>
              <td>
              <p style="font-style:italic;margin:5px 0;"><?php _e("Select a ZIP file from your local computer.", 'myarcadeplugin'); ?></p>
               <?php _e("Local File:", 'myarcadeplugin'); ?> <input type="file" size="50" name="zipfile" id="zipfile" /> <strong><span id="lblzipfile"></span></strong>
              </td>
            </tr>
            <tr>
              <td>
                 <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> select an already uploaded file to (games/uploads/phpbb).", 'myarcadeplugin'); ?></p>
                <div id="phpbb" style="min-height:30px">
                  <img class="loadimg" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none" />
                  <input type="button" id="folderphpbb" class="button-secondary fileselection" value="<?php _e("Select from folder", 'myarcadeplugin'); ?>" />
                  <input type="button" class="button-secondary cancelselection" value="<?php _e("Cancel", 'myarcadeplugin'); ?>" style="display:none" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                 <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> paste a URL to import an ZIP game from the internet.", 'myarcadeplugin'); ?></p>
                <?php _e("URL:", 'myarcadeplugin'); ?> <input name="zipurl" type="text" size="50" />
              </td>
            </tr>
            <tr>
            <td>
              <p>
                <input type="submit" class="button button-primary" id="zipupload" name="zipupload" value="<?php _e('Add File', 'myarcadeplugin'); ?>" />
              </p>
              <img id="loadimgzip" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none;" />
              <div id="filenamezip"></div>
            </td>
            </tr>
          </table>
        </div>
      </div>
    </form>
  </div>


<?php ?>
<div id="importembedif">
<h2><?php _e("Add Embed Code / Iframe URL", 'myarcadeplugin'); ?></h2>
<h2 class="box"><?php _e("Game Files", 'myarcadeplugin'); ?></h2>
<form method="post" id="uploadFormEMIF">
  <input type="hidden" name="upload" value="emif" />
  <div id="importembedif">
    <div class="container">
    <div class="block">
      <table class="optiontable" width="100%">
        <tr>
          <td><h3><?php _e("Game Code", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
        </tr>
        <tr>
          <td>
            <textarea rows="6" cols="80" name="embedcode"></textarea>
            <br />
            <i><?php _e("Paste here a complete embed code or an iframe URL and click on 'Add Code'.", 'myarcadeplugin'); ?></i>
          </td>
        </tr>
        <tr>
        <td>
          <p>
            <input type="submit" id="emifupload" name="emifupload" value="<?php _e('Add Code', 'myarcadeplugin'); ?>" />
          </p>
          <img id="loadimgemif" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none;" />
          <div id="filenameemif"></div>
        </td>
        </tr>
      </table>
    </div>
    </div>
  </div>
</form>
</div>

<?php
 ?>
<div id="importunity">
  <?php ?>
     <h2><?php _e("Add Unity3D Game", 'myarcadeplugin'); ?></h2>
     <h2 class="box"><?php _e("Game Files", 'myarcadeplugin'); ?></h2>
    <form method="post" enctype="multipart/form-data" id="uploadFormUnity">
      <input type="hidden" name="upload" value="unity" />

      <div class="container">
        <div class="block">
          <table class="optiontable" width="100%">
            <tr>
              <td><h3><?php _e("Import Unity Games", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
            </tr>
            <tr>
              <td><p style="margin-bottom:10px"><?php _e("Important: A Unity file (.unity3d) must be added prior to completing the other steps.", 'myarcadeplugin') ?></p></td>
            </tr>
            <tr>
              <td>
              <p style="font-style:italic;margin:5px 0;"><?php _e("Select a Unity file (.unity3d) from your local computer.", 'myarcadeplugin'); ?></p>
               <?php _e("Local File:", 'myarcadeplugin'); ?> <input type="file" size="50" name="unityfile" id="unityfile" /> <strong><span id="lblunityfile"></span></strong>
              </td>
            </tr>
            <tr>
              <td>
                 <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> select an already uploaded file to (games/uploads/unity).", 'myarcadeplugin'); ?></p>
                <div id="unity" style="min-height:30px">
                  <img class="loadimg" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none" />
                  <input type="button" id="folderunity" class="button-secondary fileselection" value="<?php _e("Select from folder", 'myarcadeplugin'); ?>" />
                  <input type="button" class="button-secondary cancelselection" value="<?php _e("Cancel", 'myarcadeplugin'); ?>" style="display:none" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                 <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> paste a URL to import an Unity game from the internet (.unity3d).", 'myarcadeplugin'); ?></p>
                <?php _e("URL:", 'myarcadeplugin'); ?> <input name="unityurl" type="text" size="50" />
              </td>
            </tr>
            <tr>
            <td>
              <p>
                <input type="submit" class="button button-primary" id="unityupload" name="unityupload" value="<?php _e('Add File', 'myarcadeplugin'); ?>" />
              </p>
              <img id="loadimgunity" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none;" />
              <div id="filenameunity"></div>
            </td>
            </tr>
          </table>
        </div>
      </div>
    </form>
  </div>


<?php ?>
<div id="thumbform">
<form method="post" enctype="multipart/form-data" id="uploadFormTHUMB">
  <input type="hidden" name="upload" value="thumb" />

  <div class="container">
    <div class="block">
      <table class="optiontable" width="100%">
        <tr>
          <td><h3><?php _e("Game Thumbnail", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
        </tr>
        <tr>
          <td>
          <p style="font-style:italic;margin:5px 0;"><?php _e("Select a thumbnail from your local computer.", 'myarcadeplugin'); ?></p>
           <?php _e("Local File:", 'myarcadeplugin'); ?> <input type="file" size="50" name="thumbfile" />
          </td>
        </tr>
        <tr>
          <td>
             <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> paste a URL to import a thumbnail from the internet.", 'myarcadeplugin'); ?></p>
            <?php _e("URL:", 'myarcadeplugin'); ?> <input name="thumburl" type="text" size="50" />
          </td>
        </tr>
        <tr>
        <td>
          <p>
            <input type="submit" class="button button-primary" id="thumbupload" name="thumbupload" value="<?php _e('Add File', 'myarcadeplugin'); ?>" />
          </p>
          <img id="loadimgthumb" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none;" />
          <div id="filenamethumb"></div>
        </td>
        </tr>
      </table>
    </div>
  </div>
</form>
</div>

<?php ?>
  <form method="post" enctype="multipart/form-data" id="uploadFormSCREEN">
    <input type="hidden" name="upload" value="screen" />

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td colspan="2"><h3><?php _e("Game Screenshots", 'myarcadeplugin'); ?></h3></td>
          </tr>
          <tr>
            <td colspan="2">
              <p style="font-style:italic;margin:5px 0;"><?php _e("Select image files from your local computer", 'myarcadeplugin'); ?></p></td>
          </tr>
          <tr>
            <td>
              <?php _e("Screenshot", 'myarcadeplugin'); ?> 1
            </td>
            <td><input name="screen0" type="file" size="50" /></td>
          </tr>
          <tr>
            <td>
              <?php _e("Screenshot", 'myarcadeplugin'); ?> 2
            </td>
            <td><input name="screen1" type="file" size="50" /></td>
          </tr>
          <tr>
            <td>
              <?php _e("Screenshot", 'myarcadeplugin'); ?> 3
            </td>
            <td><input name="screen2" type="file" size="50" /></td>
          </tr>
          <tr>
            <td>
              <?php _e("Screenshot", 'myarcadeplugin'); ?> 4
            </td>
            <td><input name="screen3" type="file" size="50" /></td>
          </tr>
          <tr>
            <td colspan="2">
              <p style="font-style:italic;margin:5px 0;"><?php _e("<strong>OR</strong> paste URL's to import screenshots from the internet.", 'myarcadeplugin'); ?></p></td>
          </tr>
          <tr>
            <td>
              <?php _e("Screenshot URL", 'myarcadeplugin'); ?> 1
            </td>
            <td><input name="screen0url" type="text" size="50" /></td>
          </tr>
          <tr>
            <td>
              <?php _e("Screenshot URL", 'myarcadeplugin'); ?> 2
            </td>
            <td><input name="screen1url" type="text" size="50" /></td>
          </tr>
          <tr>
            <td>
              <?php _e("Screenshot URL", 'myarcadeplugin'); ?> 3
            </td>
            <td><input name="screen2url" type="text" size="50" /></td>
          </tr>
          <tr>
            <td>
              <?php _e("Screenshot URL", 'myarcadeplugin'); ?> 4
            </td>
            <td><input name="screen3url" type="text" size="50" /></td>
          </tr>
          <tr>
            <td colspan="2">
              <p>
                <input type="submit" class="button button-primary" id="screenupload" name="screenupload" value="<?php _e('Add File(s)', 'myarcadeplugin'); ?>" />
              </p>
               <img id="loadimgscreen" src="<?php echo MYARCADE_CORE_URL?>/images/loading.gif" style="display:none;" />
              <div id="filenamescreen"></div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </form>

<?php ?>
  <h2 class="box"><?php _e("Game Information", 'myarcadeplugin'); ?></h2>
  <form method="post" name="FormCustomGame" onsubmit="return myarcade_chkImportCustom()">
    <input type="hidden" name="impcostgame"   value="import" />
    <input type="hidden" name="importgame"    id="importgame" />
    <input type="hidden" name="importtype"    id="importtype" />
    <input type="hidden" name="importgametag" id="importgametag" />
    <input type="hidden" name="importthumb"   id="importthumb" />
    <input type="hidden" name="importscreen1" id="importscreen1" />
    <input type="hidden" name="importscreen2" id="importscreen2" />
    <input type="hidden" name="importscreen3" id="importscreen3" />
    <input type="hidden" name="importscreen4" id="importscreen4" />
    <input type="hidden" name="slug"          id="slug" />

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td><h3><?php _e("Name", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
          </tr>
          <tr>
            <td>
              <input name="gamename" id="gamename" type="text" size="50" />
              <br />
              <i><?php _e("Enter the name of the imported game.", 'myarcadeplugin'); ?></i>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td colspan="2"><h3><?php _e("Game Dimensions", 'myarcadeplugin'); ?></h3></td>
          </tr>
          <tr>
            <td>
              <?php _e("Game width (px)", 'myarcadeplugin'); ?>: <input id="gamewidth" name="gamewidth" type="text" size="20" />
            </td>
            <td>
              <?php _e("Game height (px)", 'myarcadeplugin'); ?>: <input id="gameheight" name="gameheight" type="text" size="20" />
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <br />
              <i><?php _e("If MyArcadePlugin Pro is unable to detect dimensions for the flash files automatically, the dimensions should be indicated manually.", 'myarcadeplugin');?>
              </i>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td><h3><?php _e("Game Description", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
          </tr>
          <tr>
            <td>
              <textarea rows="6" cols="80" name="gamedescr" id="gamedescr"></textarea>
              <br />
              <i><?php _e("Enter description of the game (a unique description can help improve search engine ranking).", 'myarcadeplugin'); ?></i>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td><h3><?php _e("Game Instructions", 'myarcadeplugin'); ?></h3></td>
          </tr>
          <tr>
            <td>
              <textarea rows="6" cols="80" name="gameinstr" id="gameinstr"></textarea>
              <br />
              <i><?php _e("Write brief instructions on how to play the game.", 'myarcadeplugin'); ?></i>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td><h3><?php _e("Tags", 'myarcadeplugin'); ?></h3></td>
          </tr>
          <tr>
            <td>
              <input name="gametags" id="gametags" type="text" size="50" />
              <br />
              <i><?php _e("Enter description tags. Separate the tags with commas (,).", 'myarcadeplugin'); ?></i>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td><h3><?php _e("Game Video", 'myarcadeplugin'); ?></h3></td>
          </tr>
          <tr>
            <td>
              <input name="video_url" id="video_url" type="text" size="50" />
              <br />
              <i><?php _e("Enter a game video URL (Youtube, Vimeo...) if available.", 'myarcadeplugin'); ?></i>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td><h3><?php _e("Post Status", 'myarcadeplugin'); ?></h3></td>
          </tr>
          <tr>
            <td>
              <?php
 $R031CDA15714D1A52C5414C45F0F1EAF2 = ''; if ( current_user_can('publish_posts') ) : ?>
              <input type="radio" name="publishstatus" value="publish" checked>&nbsp;<?php _e("Publish", 'myarcadeplugin'); ?>
              <br />
              <?php else: ?>
              <?php $R031CDA15714D1A52C5414C45F0F1EAF2 = ' checked'; ?>
              <?php endif; ?>
              <input type="radio" name="publishstatus" value="draft" <?php echo $R031CDA15714D1A52C5414C45F0F1EAF2; ?>>&nbsp;<?php _e("Save as draft", 'myarcadeplugin'); ?>
              <br />
              <input type="radio" name="publishstatus" value="add">&nbsp;<?php _e("Add to the games database (don't add as a blog post)", 'myarcadeplugin'); ?>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td><h3><?php _e("Category", 'myarcadeplugin'); ?> <small>(<?php _e("required", 'myarcadeplugin'); ?>)</small></h3></td>
          </tr>
          <tr>
            <td>
              <?php
 $RA16D2280393CE6A2A5428A4A8D09E354 = count($R30E38C1F8EC85F8EE8DF620FF3267157); foreach ($R30E38C1F8EC85F8EE8DF620FF3267157 as $RCB6CF74D12D3949F4F3C570ECE4B9CB5) { $RA16D2280393CE6A2A5428A4A8D09E354--; $R53DBA466EE435BF798AB2C931C135018 = ''; if ($RA16D2280393CE6A2A5428A4A8D09E354 > 0) $R53DBA466EE435BF798AB2C931C135018 = '<br />'; echo '<input type="checkbox" class="gamecat'.intval( $RCB6CF74D12D3949F4F3C570ECE4B9CB5->term_id ).'" name="gamecategs[]" value="'.$RCB6CF74D12D3949F4F3C570ECE4B9CB5->name.'" />&nbsp;'.$RCB6CF74D12D3949F4F3C570ECE4B9CB5->name.$R53DBA466EE435BF798AB2C931C135018; } ?>
              <br /><br />
              <i><?php _e("Select one or more categories for this game.", 'myarcadeplugin'); ?></i>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
        <table class="optiontable" width="100%">
          <tr>
            <td><h3><?php _e("Score Options", 'myarcadeplugin'); ?></h3></td>
          </tr>
          <tr>
            <td>
              <input type="checkbox" id="lbenabled" name="lbenabled" value="1" />&nbsp;
              <i><?php _e("Yes - This game is able to submit scores", 'myarcadeplugin'); ?></i>
              <br /><br />
              <?php _e("Score Order", 'myarcadeplugin'); ?>
              <select name="highscoretype" id="highscoretype">
                <option value="high"><?php _e("DESC (High to Low)", 'myarcadeplugin'); ?></option>
                <option value="low"><?php _e("ASC (Low to High)", 'myarcadeplugin'); ?></option>
              </select>
              <br /><br />
              <input type="checkbox" name="score_bridge" value="gamersafe" />&nbsp;<i><?php _e("GamerSafe Support - Check this if the game has GamerSafe Data Bridge integrated.", 'myarcadeplugin'); ?></i>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="container">
      <div class="block">
         <input class="button-primary" id="submit" type="submit" name="submit" value="<?php _e("Import Game", 'myarcadeplugin'); ?>" />
      </div>
    </div>
  </form>