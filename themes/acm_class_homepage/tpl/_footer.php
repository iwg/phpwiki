        </div>
      </div>

    </div><!-- END .front-page -->

  </div><!-- END #main -->

  <div id="footer">
    <p class="part-1">
      Powered by <a class="b" target="_blank" href="https://github.com/oipn4e2/phpwiki">phpwiki</a>
      |
      Edit
      |
      Login
      |
      Logout
    </p>
    <p class="part-2">
      Copyright &copy; 2002-<?php echo date('Y'); ?> <a href="<?php echo SITE_BASE; ?>">ACM Class</a>. All rights reserved.
    </p>
  </div>
  <?php foreach ($js as $name): ?>
  <script type="text/javascript" src="<?php echo $theme_path; ?>/js/<?php echo $name; ?>.js"></script>
  <?php endforeach; ?>
</body>
</html>
