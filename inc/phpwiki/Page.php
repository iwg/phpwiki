<?php
class Page extends fActiveRecord
{
  const NORMAL = 0;
  const HYPERLINK = 1;
  
  protected function configure()
  {
    fORMRelated::setOrderBys($this, 'Revision', array('revisions.created_at' => 'desc'));
  }
}
