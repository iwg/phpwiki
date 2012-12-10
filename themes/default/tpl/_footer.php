       </div>
      </div>
     
    </div>

    <div id="footer">
      <div class="container">
        <p class="muted credit">
         	<b>PHPWiki</b> is sponsored and made possible by constant development from <a href="http://php.net/">PHP Technologies</a> |
         	<a href="http://twitter.github.com/bootstrap/">Bootstrap</a> |
  			<a href="<?php echo wiki_contributors(); ?>">Contributors</a>
  			<br>
  			Copyright &copy; 2012 <a href="http://acm.sjtu.edu.cn/">ACM Class</a>.
  			All rights reserved.
  		<br>
       </p>
     </div>
   </div>

  </div>


  <!--script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/dojo/1.6.0/dojo/dojo.xd.js"></script-->
  <?php foreach ($js as $name): ?>
    <script type="text/javascript" src="<?php echo $theme_path; ?>/js/<?php echo $name; ?>.js"></script>
  <?php endforeach; ?>
  <script type="text/javascript" src="/wiki/themes/default/js/bootstrap.js"></script>
</body>
</html>
