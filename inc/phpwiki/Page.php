<?php
class Page extends fActiveRecord
{
  const NORMAL = 0;
  const HYPERLINK = 1;
  
  protected function configure()
  {
    fORMRelated::setOrderBys($this, 'Revision', array('revisions.created_at' => 'desc'));
  }
  
  public function getLatestRevision()
  {
    $revisions = $this->buildRevisions();
    if ($revisions->count()) {
      return $revisions->getRecord(0);
    }
    throw new Exception('Page does not have any revisions (database is inconsistent).');
  }
  
  public function getOwnerBits()
  {
    return $this->getPermission() / 100;
  }
  
  public function getGroupBits()
  {
    return ($this->getPermission() % 100) / 10;
  }
  
  public function getOtherBits()
  {
    return $this->getPermission() % 10;
  }
  
  public function isNormal()
  {
    return $this->getType() == self::NORMAL;
  }
  
  public function isHyperlink()
  {
    return $this->getType() == self::HYPERLINK;
  }
}
