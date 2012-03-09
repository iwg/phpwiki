<?php
class Group extends fActiveRecord
{
  protected function configure()
  {
  }
  
  public function memberships()
  {
    return fRecordSet::build('Membership', array('group_id=' => $this->getId()));
  }
  
  public function isSystemGroup()
  {
    return $this->getName() == "root" or $this->getName() == "nobody";
  }
  
  public static function root()
  {
    return new Group(array('name' => 'root'));
  }
  
  public static function nobody()
  {
    return new Group(array('name' => 'nobody'));
  }

  public function isMember($user_name)
  {
    $result = fRecordSet::build(
      'Membership', 
      array(
        'group_id=' => $this->getId(),
        'user_name=' => $user_name
      )
    );
    try {
      $result->tossIfEmpty();
      return TRUE;
    } catch (fEmptySetException $e) {
      return FALSE;
    }
  }
}
