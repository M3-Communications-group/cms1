<script type="text/javascript">
    tinymce.init({
        // General options
        mode: "exact",
        elements: "###vars###",
        gecko_spellcheck: true,
        plugins: ["advlist autolink lists link image charmap print preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars code fullscreen", "insertdatetime media nonbreaking save table contextmenu directionality paste"],
        menubar: false,
        relative_urls: false,
        remove_script_host: false,
        //document_base_url: "###site_path###", 
        document_base_url: "",
        entity_encoding: "raw",
        image_advtab: true,
        resize: "both",

        paste_use_dialog: true,
        paste_auto_cleanup_on_paste: true,
        paste_convert_headers_to_strong: false,
        paste_strip_class_attributes: "all",
        paste_remove_spans: true,
        paste_remove_styles: true,

        // Theme options
        toolbar1: "pastetext bold italic underline sub sup | link unlink anchor | image media | alignleft aligncenter alignright | bullist numlist | table | removeformat code",
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
    <div style="float: left;">
        <script language="JavaScript1.2">
            function openImgGal() {
                //window.open('images.php?popup=1&table=images&pid=###images_table###','','alwaysRaised=1,width=400px,height=450px,scrollbars=1,left=550px;');
                window.open('main.php?admin_option=6&table=m3cms_files&action=view&pid=2', '', 'alwaysRaised=1,width=950px,height=550px,scrollbars=1,left=550px;');
            }
        </script>
        <a href="#" onclick="openImgGal();
                return false;"><img src="images/rte/image.gif" alt="Images" border="0" class="butClass"></a> 
    </div>
</div>
<div style="clear: both;"></div>
