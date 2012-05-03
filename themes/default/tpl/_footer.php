      </div>

      <div id="outtro">
        <strong>phpwiki</strong> is sponsored and made possible by constant development from
        <a href="http://acm.sjtu.edu.cn">ACM class</a>.
      </div>
    </div>

    <div id="footer">
      &copy; 2012
    </div>
  </div>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/dojo/1.6.0/dojo/dojo.xd.js"></script>
  <?php foreach ($js as $name): ?>
    <script type="text/javascript" src="<?php echo $theme_path; ?>/js/<?php echo $name; ?>.js"></script>
  <?php endforeach; ?>
</body>
</html>
