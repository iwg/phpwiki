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
  
  public function is_system_group()
  {
    return $this->getName() == "root" or $this->getName() == "nobody";
  }
}