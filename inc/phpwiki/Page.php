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
  
  public function getRevisionCount()
  {
    $revisions = $this->buildRevisions();
    if ($revisions->count()) {
      return $revisions->count();
    }
    throw new Exception('Page does not have any revisions (database is inconsistent).');
  }
  
  public function getRevision($ID)
  {
    $revisions = $this->buildRevisions();
    if ($revisions->count() > $ID) {
      return $revisions->getRecord($ID);
    }
    throw new Exception('Page does not have any revisions (database is inconsistent).');
  }

  public function getGroupBits()
  {
    return intval($this->getPermission() / 10);
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

  public function isPrivatePage()
  {
    $path = $this->getPath();
    if ($path[1] != '~') {
      return FALSE;
    }
    $ans = '';
    $i = 2;
    while (($i < strlen($path)) && ($path[$i] != '/')) {
      $ans .= $path[$i];
      $i = $i + 1;
    }
    return $ans;
  }

  public function isPermitted($user_name, $action)
  {
    $privatepage = $this->isPrivatePage();
    if (($privatepage == $user_name) && ($user_name != '')) {
      return 'owner';
    }
    $group_bits = $this->getGroupBits();
    $other_bits = $this->getOtherBits();
    $page_owner = $this->getOwnerName();
    $page_group_id = $this->getGroupId();
    if ($action == 'read') {
      $group_permission = wiki_allow_read($group_bits);
      $other_permission = wiki_allow_read($other_bits);
    } else if ($action == 'write') {
      $group_permission = wiki_allow_write($group_bits);
      $other_permission = wiki_allow_write($other_bits);
    } else if ($action == 'create') {
      $group_permission = wiki_allow_create($group_bits);
      $other_permission = wiki_allow_create($other_bits);
    } else {
      return FALSE;
    }
    if ($user_name == '') {
      if ($other_permission) 
        return 'other';
      else
        return FALSE;
    }
    $tempgroup = new Group(array('id' => $page_group_id));
    if ($page_owner!=$user_name) {
      if (!$group_permission || !$tempgroup->isMember($user_name)) {
        if (!$other_permission)
          return FALSE;
        else
          return 'other';
      } else {
        return 'group';
      }
    } else {
      return 'owner';
    }
  }

  public static function parentPage($page_path)
  {
    $lastpos = strrpos($page_path, '/');
    if ($lastpos == 0) {
      return '/';
    } else {
      return substr($page_path, 0, $lastpos);
    }
  }
}
