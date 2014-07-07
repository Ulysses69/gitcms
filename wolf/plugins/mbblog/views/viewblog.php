<div class="entry">
  <h3><a href="/publicblog/view/<?php echo $post->urltitle; ?>/"><?php echo $post->posttitle; ?></a></h3>
  <?php
	$date = date($dateformat, stripslashes($post->date));
    echo stripslashes($post->body); ?>
  	<p class="info">Posted by <?php echo $post->author; ?> on <?php echo $date; ?>
  </p>
</div>
