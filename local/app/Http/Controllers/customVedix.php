<?php
function combos($data, &$all = array(), $group = array(), $val = null, $i = 0) {
    if (isset($val)) {
        array_push($group, $val);
    }
    if ($i >= count($data)) {
        array_push($all, $group);
    } else {
        foreach ($data[$i] as $v) {
            combos($data, $all, $group, $v, $i + 1);
        }
    }
    return $all;
}


 $data = array(
      array('body_frame_thin', 'body_frame_medium','body_frame_ligre'),
      array('is_sweet_less', 'is_sweet_medium', 'is_sweet_a_lot'),
      array('appetite_irregular', 'appetite_strong', 'appetite_normal'),
      array('hair_volume_fine', 'hair_volume_medium', 'hair_volume_thick'),
      array('hair_type_wavy', 'hair_type_straight', 'hair_type_thick'),
      array('hair_texture_rough_and_dry', 'hair_texture_silky_and_smooth', 'hair_texture_Full and lustrous'),
      array('scalp_texture__dry', 'scalp_texture_oily', 'scalp_texture_normal_oily'),
      array('dandruff_yes', 'dandruff_yes'),
      array('gender_male', 'gender_female'),
  );
  $combos = combos($data);
  
  
echo '<pre>'; print_r(count($combos)); echo '</pre>';
