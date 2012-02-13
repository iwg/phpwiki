<?php
class Revision extends fActiveRecord
{
  protected function configure()
  {
  }
  
  public function getTheme()
  {
    return new Theme($this->getThemeId());
  }
  
  public function show()
  {
    // TODO
    echo "<PRE>" . $this->getBody() . "</PRE>";
  }
}
