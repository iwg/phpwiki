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
}
