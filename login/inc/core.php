<?php
function login_check_credential($username, $password)
{
  $db = new ldap(LDAP_HOST, 1389);
  return $db->authenticate($username, $password);
}

function login_authenticate($username, $password)
{
  $db = new ldap(LDAP_HOST, LDAP_PORT);
  if ($db->authenticate($username, $password)) {
    $result = $db->getInformation($username);
    fAuthorization::setUserToken(array(
      'id' => $result[0]['id'][0],
      'name' => $username,
      'email' => $result[0]['email'][0],
      'display_name' => $result[0]['display_name'][0]
    ));
    return true;
  }
  return false;
}

function login_change_password($username, $oldpassword, $newpassword)
{
  $db = new ldap(LDAP_HOST, LDAP_PORT);
  $h = array('pass' => $newpassword);
  return $db->changeInformation($username, $oldpassword, $h);
}

function login_get_referer($default_value)
{
  if (array_key_exists('HTTP_REFERER', $_SERVER)) {
    return $_SERVER['HTTP_REFERER'];
  }
  return $default_value;
}
