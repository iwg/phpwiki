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
    echo wiki_render_markup($this->getTitle(), $this->getBody());
  }
}
