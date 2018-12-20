
<?php
  $privacy_policy = $this->db->where('key','about_us')->get('setting')->row_array();
  $dom = new DOMDocument();
  $dom->loadHTML($privacy_policy['value']);
  foreach ($dom->getElementsByTagName('img') as $img) {
	    // put your replacement code here
  		$original = $img->getAttribute("src");
  		$img->setAttribute( 'src', '../'.$original);
	}

	$content = $dom->saveHTML();
?>

 <html>
    <body><?php echo $content; ?></body>
</html> 

