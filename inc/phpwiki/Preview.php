<?php
class Preview extends fActiveRecord
{
  protected function configure()
  {
  }
  
  public function buildPage()
  {
    $page = new Page();
    $page->setId(0);
    $page->setPath($this->getPath());
    $page->setOwnerName($this->getOwnerName());
    $page->setGroupId($this->getGroupId());
    $page->setPermission($this->getPermission());
    $page->setType(Page::NORMAL);
    $page->setCreatedAt($this->getCreatedAt());
    $page->setUpdatedAt(now());
    return $page;
  }
  
  public function buildRevision()
  {
    $revision = new Revision();
    $revision->setId(0);
    $revision->setPageId(0);
    $revision->setTitle($this->getTitle());
    $revision->setBody($this->getBody());
    $revision->setThemeId($this->getThemeId());
    $revision->setIsMinorEdit(false);
    $revision->setEditorName($this->getOwnerName());
    $revision->setCommitMessage('');
    $revision->setCreatedAt($this->getCreatedAt());
    $revision->setUpdatedAt(now());
    return $revision;
  }
}
