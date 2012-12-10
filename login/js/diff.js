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
