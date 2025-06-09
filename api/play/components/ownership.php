<?php

function check_ownership($user_id, $brin_id)
{
  $user_id_from_db = db_select_where(['Usuario_user_id'], 'brinquedo', ['brin_id'], [$brin_id]);
  if($user_id != $user_id_from_db['Usuario_user_id']){
    response_format(400, "Você não é o dono deste brinquedo.");
  }
}