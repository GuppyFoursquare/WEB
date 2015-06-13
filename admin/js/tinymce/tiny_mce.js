  tinyMCE.init({mode:"exact",
              skin:"o2k7",		   
	      width : "400",
	      height:"300",
              skin_variant:"silver",
              relative_urls : true,
              convert_urls : false,
              elements:"contents",
              theme:"advanced",
              content_css : "tinymce/custom_css.css",
              plugins:"pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,safari,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
              theme_advanced_buttons1:"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
              theme_advanced_buttons2:"cut,copy,paste,pastetext,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,backcolor",
              theme_advanced_buttons3:"table,advhr,|,sub,sup,|,fullscreen",
              theme_advanced_toolbar_location:"top",
              theme_advanced_toolbar_align:"left",
              theme_advanced_statusbar_location:"none",
              theme_advanced_path : false,
              paste_retain_style_properties :"all",
              theme_advanced_resizing:false,
              file_browser_callback:"openKCFinder"});

function openKCFinder(c,a,b,d){tinyMCE.activeEditor.windowManager.open({file:"../javascript/kcfinder/browse.php?opener=tinymce&type="+b+"&dir="+b+"/public",title:"KCFinder",width:700,height:500,resizable:"yes",inline:true,close_previous:"no",popup_css:false},{window:d,input:c});return false};
    