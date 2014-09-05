<?php foreach($posts as $post): ?>
<div class="entry">
  <h3><a href="/publicblog/view/<?php echo $post->urltitle; ?>/"><?php echo $post->posttitle; ?></a></h3>
  <?php
	$date = date($dateformat, stripslashes($post->date));
	if(!empty($post->shortbody))
	{
		$bPost = stripslashes($post->shortbody)."<br /><br /><a href='/publicblog/view/".stripslashes($post->urltitle)."'>Read More</a>";
	} else
	{
		$bPost = stripslashes($post->body);
	}
	echo $bPost; ?>
  <p class="info">Posted by <?php echo $post->author; ?> on <?php echo $date; ?> 
  </p>
</div>
<?php endforeach;

if(count($paging) > 0 && $paging !== false):
	echo $paging['firstLink'].$paging['prevLink'].implode('', $paging['nums']).$paging['nextLink'].$paging['lastLink'];
endif;
?>