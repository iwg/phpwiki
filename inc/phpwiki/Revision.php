<?php
class Revision extends fActiveRecord
{
  protected function configure()
  {
  }
  
  public function show()
  {
    // TODO
    echo "<PRE>" . $this->getBody() . "</PRE>";
  }
}
