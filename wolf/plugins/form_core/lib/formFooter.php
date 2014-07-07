
				<div class="submitholder">
				<?php
				/* Don't display formbody content if low-profile formsize is true */
				if($formsize != true) echo $privacy; ?>

				<?php if($buttontype != 'text' && $buttontype != ''){
					if(stristr($buttontype,'.')){
						$type = "image";
						$src = ' src="'.$buttontype.'" alt="Submit"';
						$label = "Send";
					} else {
					  $type = "submit";
					  $src = "";
					  $label = $buttontype;
					}
				} else {
					$type = "submit";
					$src = "";
					$label = "Send";
				} ?>
				<input type="hidden" id="send" name="send" value="sent" />
				<input type="<?php echo $type; ?>"<?php echo $src; ?> id="submit" name="submit" value="<?php echo $label; ?>" class="submit" />
				</div>

