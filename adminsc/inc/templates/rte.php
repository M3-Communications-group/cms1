<script type="text/javascript">
    tinymce.init({
        // General options
        mode: "exact",
        elements: "###vars###",
        gecko_spellcheck: true,
        plugins: ["advlist autolink lists link image charmap print preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars code fullscreen", "insertdatetime media nonbreaking save table directionality paste"],
        menubar: false,
        relative_urls: true,
        remove_script_host: false,
        document_base_url: "###site_path###",
        entity_encoding: "raw",
        image_advtab: true,
        resize: "both",
        // contextmenu: "link image inserttable | cell row column deletetable",

        paste_use_dialog: true,
        paste_auto_cleanup_on_paste: true,
        paste_convert_headers_to_strong: false,
        paste_strip_class_attributes: "all",
        paste_remove_spans: true,
        paste_remove_styles: true,

        // Theme options
        toolbar1: "pastetext | styleselect |  bold italic underline sub sup | link unlink anchor | image media | alignleft aligncenter alignright | bullist numlist | table | removeformat code",
        toolbar2: "",

        content_css: "###site_path###css/rte.css"    // resolved to http://domain.mine/mycontent.css
    });
</script>


<div style="float: left;">
    <div style="float: left;">
        <textarea id="###vars###" name="###vars###" rows="30" cols="180">
		###content###
        </textarea>
    </div>
</div>
<div style="clear: both;"></div>
