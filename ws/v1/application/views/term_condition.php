
<?php
  $term_condition = $this->db->where('key','terms_condition')->get('setting')->row_array();
?>
<!--<style>
    @media (max-width:320px){
        img {
            width: 100% !important;
        }
    }
</style>-->
<html>
    <body><?php echo $term_condition['value']; ?></body>
</html>
