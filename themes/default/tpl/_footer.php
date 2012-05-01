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
  <?php foreach ($js as $name): ?>
    <script type="text/javascript" src="<?php echo $theme_path; ?>/js/<?php echo $name; ?>.js"></script>
  <?php endforeach; ?>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/dojo/1.6.0/dojo/dojo.xd.js"></script>
  <script language="javascript">
  var $ = dojo.byId;
  var url = window.location.toString().split("#")[0];

  function diffUsingJS () {
    var base = difflib.stringAsLines($("baseText").value);
    var newtxt = difflib.stringAsLines($("newText").value);
    var sm = new difflib.SequenceMatcher(base, newtxt);
    var opcodes = sm.get_opcodes();
    var diffoutputdiv = $("diffoutput");
    while (diffoutputdiv.firstChild) diffoutputdiv.removeChild(diffoutputdiv.firstChild);
    var contextSize = null;
    diffoutputdiv.appendChild(diffview.buildView({ baseTextLines:base,
      newTextLines:newtxt,
      opcodes:opcodes,
      baseTextName:"Text1(Base)",
      newTextName:"Text2",
      contextSize:contextSize,
      viewType: $("inline").checked ? 1 : 0 }));
    window.location = url + "#diff";
  }
  </script>

</body>
</html>
