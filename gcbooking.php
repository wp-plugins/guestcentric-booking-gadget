<?php
/*
Plugin Name: GuestCentric Booking Gadget
Plugin URI: http://www.guestcentric.com
Description: Insert a widget with the GuestCentric Booking Gadget on your website.
Author: Pedro Araujo
Version: 1.0b
Author URI: mailto:pedro.araujo@guestcentric.com
*/

//Adds the fields in the widget options panel
function gcWidgetControl () {

	$gcData = get_option("gcBookingGadget");

	if (function_exists('icl_register_string')) {
		$langDetail = icl_get_languages('skip_missing=0');
  		$langList = array_keys ( icl_get_languages('skip_missing=0') );
	}
	  else {
		$langDetail['none'] = array ( 'native_name' => 'None' );
		$langList = array ( '0' => 'none' );
	}

	$langNum = count ( $langList );

	for ($i=0; $i<$langNum; $i++) {
		if (!is_array( $gcData[$langList[$i]] )) {
			$gcData[$langList[$i]] = array( 'titleText' => 'Booking Gadget',  'orientation' => 'undefined', 'linkText' => 'BOOK ONLINE!');
	  	}
	}

	if ($_POST['gcWidgetSubmit']) {
		$curLang = $_POST['gcLanguage'];
		$gcData[$curLang]['titleText'] = htmlspecialchars($_POST['gcWidgetTitle']);
		$gcData[$curLang]['apiKey'] = htmlspecialchars($_POST['gcApiKey']);
		$gcData[$curLang]['orientation'] = $_POST['gcOrientation'];
		$gcData[$curLang]['linkText'] = htmlspecialchars($_POST['gcLinkText']);
		update_option("gcBookingGadget", $gcData);
	}

?>
	<script type="text/javascript">

		function changeValues(lang){
		

			switch (lang){
				<?php updateFormValues(); ?>
			}
			
		}

				
	</script>
        <p>
                <label for="gcLanguage" >Language: </label>
                <select name="gcLanguage" onChange="changeValues(this.value)">
			<?php for ($i=0; $i<$langNum; $i++) 
				echo '<option value="'.$langList[$i].'">'.$langDetail[$langList[$i]]['native_name'].'</option>';
                        ?>
                </select>
        </p>

	<p>
		<label for="gcWidgetTitle">Title label: </label><br>
		<input type="text" id="gcWidgetTitle" name="gcWidgetTitle" size="28" class="titleClass" value="<?php echo $gcData[$langList[0]]['titleText'];?>" />
	</p>

	<p>
		<label for="gcApiKey">Api Key: </label><br>
		<input type="text" id="gcApiKey" name="gcApiKey" size="28" maxlength="32" class="apiClass" value="<?php echo $gcData[$langList[0]]['apiKey'];?>" />
	</p>

        <p>
                <label for="gcOrientation">Orientation: </label>
                <select name="gcOrientation" class="orientationClass">
			<option value="horizontal" <?php if ($gcData[$langList[0]]['orientation']=='horizontal') echo 'selected="selected"'; ?> >Horizontal</option>
			<option value="vertical" <?php if ($gcData[$langList[0]]['orientation']=='vertical') echo 'selected="selected"'; ?> >Vertical</option>
			<option value="link" <?php if ($gcData[$langList[0]]['orientation']=='link') echo 'selected="selected"'; ?> >Link</option>
		</select>
        </p>

        <p>
		<label for="gcLinkText">Link text: </label><br>
        	<input type="text" id="gcLinkText" name="gcLinkText" class="linkClass" size="28" value="<?php echo $gcData[$langList[0]]['linkText'];?>" /><br>
		(Text for use in the link orientation)
 	</p>

	<input type="hidden" id="gcWidgetSubmit" name="gcWidgetSubmit" value="1" />
<?php

}


//Dirty Hack for passing the values from the php var to the js
function updateFormValues() {

	$gcData = get_option("gcBookingGadget");
	$langNum = count ($gcData);
	$langList = array_keys ($gcData);

	for ($i=0; $i<$langNum; $i++) {
		echo 'case "'.$langList[$i].'":
		';
		echo '$(".titleClass").val("'.$gcData[$langList[$i]]['titleText'].'");
		';
		echo '$(".apiClass").val("'.$gcData[$langList[$i]]['apiKey'].'");
		';
		echo '$(".orientationClass").val("'.$gcData[$langList[$i]]['orientation'].'");
		';
		echo '$(".linkClass").val("'.$gcData[$langList[$i]]['linkText'].'");
		';
		echo 'break;
		';
	}

}


//Self explainatory, outputs an Horizontal booking gadget
function outputHorizontal($apiKey) {

	echo '<div class="gcBookingGadget"></div>';
	echo '<script type="text/javascript" src="https://secure.guestcentric.net/api/bg/?apikey='.$apiKey.'"> </script>';

}

//Self explainatory, outputs an Vertical booking gadget
function outputVertical($apiKey) {

        echo '<div class="gcBookingGadget vertical"></div>';
        echo '<script type="text/javascript" src="https://secure.guestcentric.net/api/bg/?apikey='.$apiKey.'"> </script>';

}

//Self explainatory, outputs an Link booking gadget
function outputLink($apiKey, $text) {

	echo '<a href="https://secure.guestcentric.net/api/bg/book.php?apikey='.$apiKey.'">'.$text.'</a>';

}


//Selects the booking gadget type to insert in the page, and returns the html code
function gcSelectWidget ($language) {

	$gcData = get_option("gcBookingGadget");

	switch ($gcData[$language]['orientation']) {
		case 'horizontal':
			outputHorizontal($gcData[$language]['apiKey']);
		break;
		case 'vertical':
                        outputVertical($gcData[$language]['apiKey']);
                break;
		case 'link':
                        outputLink($gcData[$language]['apiKey'], $gcData[$language]['linkText']);
                break;
		case 'undifined':
			echo 'Please set your apiKey for this language';
		break;
	}
}

//Inserts the widget in the website
function gcPostWidget($args){

	extract ($args);

	$gcData = get_option("gcBookingGadget");

	if (function_exists('icl_register_string'))
                $curLang = ICL_LANGUAGE_CODE;
          else
                $curLang = 'none';
	
	echo $before_widget;
	echo $before_title;
	echo '<h2>'.$gcData[$curLang]['titleText'].'</h2>';
	echo $after_title;
	gcSelectWidget($curLang);
	echo $after_widget;

}

//Register the widget
function gcWidgetInit() {
	register_sidebar_widget(__('Booking gadget'), 'gcPostWidget'); 
	register_widget_control(   'Booking gadget', 'gcWidgetControl', 200, 400 );
}

add_action("plugins_loaded", "gcWidgetInit");
