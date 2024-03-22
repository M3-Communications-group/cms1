<script type="text/javascript">
    _editor_url = "inc/htmlarea/";
    _editor_lang = "en";
</script>
<script type="text/javascript" src="inc/htmlarea/htmlarea.js"></script>


<script type="text/javascript">
    var editor = null;

    function initEditor()
    {
        editor = new HTMLArea("###vars###");


        editor.registerPlugin(TableOperations);
        editor.registerPlugin(ListType);
        editor.registerPlugin(CharacterMap);
        editor.registerPlugin(ImageManager);

        editor.generate();

        return false;
    }

</script>

<textarea id="###vars###" name="###vars###" style="width: 750px;" rows="20">###content###</textarea><br>

<script language="JavaScript">
    function showeb()
    {
        if (document.readyState == 'complete')
            initEditor();
        else
            setTimeout('showeb()', 1000);
    }

    showeb();

    // load the plugin files
    HTMLArea.loadPlugin("TableOperations");
    HTMLArea.loadPlugin("ListType");
    HTMLArea.loadPlugin("ImageManager");
    HTMLArea.loadPlugin("CharacterMap");

    HTMLArea.init();

</script>
