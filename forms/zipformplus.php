<?php if ( ! defined( 'ABSPATH' ) ) { header( 'HTTP/1.0 403 Forbidden' ); exit;}?>
<div class = "zipcodetext"><?php esc_html_e(get_option('zipcodesask'));?></div>
<?php $place = esc_html( get_option( 'zipplaceholder' ));$title = esc_html( get_option( 'ziptitle' ));$submit = esc_html( get_option( 'zipsubmittext' ));switch (get_option( 'zipcodescheck')) {case "4":?>
<form name="zipplus" onSubmit= <?php if (get_option( 'zipsubmitcheck' ) == 'on'){ echo "\"return false;\"";} else {echo "\"zipajax_plus();return false;\"";} ?> id = "zipplus">  
<input type="text" id = "ziptextplus" maxlength="4" size="11" placeholder= <?php echo "\"$place\""?> value = "" name="ziptextplus" title=<?php echo "\"$title\""?> onblur="zipajax_plus()"> <?php if (get_option( 'zipsubmitcheck' ) == 'on') echo "<input type=\"submit\" value=\"$submit\">"; ?></form>   
<?php break; case "5":?>
<form name="zipplus" onSubmit= <?php if (get_option( 'zipsubmitcheck' ) == 'on'){ echo "\"return false;\"";} else {echo "\"zipajax_plus();return false;\"";} ?> id = "zipplus">  
<input type="text" id = "ziptextplus" maxlength="5" size="11" placeholder= <?php echo "\"$place\""?> value = "" name="ziptextplus" title=<?php echo "\"$title\""?> onblur="zipajax_plus()"> <?php if (get_option( 'zipsubmitcheck' ) == 'on') echo "<input type=\"submit\" value=\"$submit\">"; ?></form>
<?php break; case "6":?>
<form name="zipplus"  onSubmit= <?php if (get_option( 'zipsubmitcheck' ) == 'on'){ echo "\"return false;\"";} else {echo "\"zipajax_plus();return false;\"";} ?> id = "zipplus">  
<input type="text" id = "ziptextplus" maxlength="7" size="11" placeholder= <?php echo "\"$place\""?> value = "" name="ziptextplus" title=<?php echo "\"$title\""?> onblur="zipajax_plus()"> <?php if (get_option( 'zipsubmitcheck' ) == 'on') echo "<input type=\"submit\" value=\"$submit\">"; ?></form>
<?php break; default:?>
<form name="zipplus"  onSubmit= <?php if (get_option( 'zipsubmitcheck' ) == 'on'){ echo "\"return false;\"";} else {echo "\"zipajax_plus();return false;\"";} ?> id = "zipplus">  
<input type="text" id = "ziptextplus" maxlength="8" size="11" placeholder= <?php echo "\"$place\""?> value = "" name="ziptextplus" title=<?php echo "\"$title\""?> onblur="zipajax_plus()"> <?php if (get_option( 'zipsubmitcheck' ) == 'on')  echo"<input type=\"submit\" value=\"$submit\">"; ?></form>
<?php } ?>
<div class = "zipcodetext" id="zipplusshow"><?php esc_html_e(get_option('zipcodesuse'));?></div>