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
}
