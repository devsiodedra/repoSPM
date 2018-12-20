
<?php
  $privacy_policy = $this->db->where('key','terms_condition')->get('setting')->row_array();
?>

<html>
    <body><?php echo $privacy_policy['value']; ?></body>
</html>

