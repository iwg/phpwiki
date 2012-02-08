      </div>

      <div id="outtro">
        <strong>phpwiki</strong> is a sponsored and made possible by constant development from
        <a href="http://acm.sjtu.edu.cn">ACM class</a>.
      </div>
    </div>

    <div id="footer">
      &copy; 2012
    </div>
  </div>
  <?php foreach ($js as $name): ?>
    <script type="text/javascript" src="<?php echo $theme_path; ?>/js/<?php echo $name; ?>.js"></script>
  <?php endforeach; ?>
</body>
</html>
