<!-- End Left Sidebar -->
                <div class="content-inner">
                    <div class="container-fluid">
                        <!-- Begin Page Header-->
                        <div class="row">
                            <div class="page-header">
                                <div class="d-flex align-items-center">
                                    <h2 class="page-header-title"><?= $page_title ?></h2>
                                    <div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="ti ti-home"></i></a></li>
                                            <li class="breadcrumb-item active"><?= $page_title ?></li>
                                        </ul>
                                    </div>                              
                                </div>
                            </div>
                        </div>
                        <!-- End Page Header -->
                        <!-- Begin Row -->
                        <div class="row flex-row">
                            <div class="col-xl-12 col-12">
                                <div class="widget has-shadow">
                                    <div class="widget-body">
                                          <form name="cms" method="post">
                                            <div class="row form-group row mb-5">
                                                <div class="col-md-12 inputGroup">
                                                    <label class="label">Content</label>
                                                    <div class="input">
                                                        <input type="hidden" name="key" value="<?= $page ?>" />
                                                        <textarea class="form-control" name="value"><?= $content ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 inputGroup resp_cms" style="color: green;">
                                                    
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button class="btn btn-gradient-01 btn_save">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Container -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.min.js"></script> -->
<script src="assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({ 
                        selector:'[name="value"]',
                        height: 500,
                        menubar: false,
                        //paste_as_text:true,
                        /*plugins: [
                            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern"
                          ],
                        toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",*/
                         plugins: [
                            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars code fullscreen   nonbreaking",
                            "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
                          ],

                          toolbar1: "newdocument | bold italic underline | alignleft aligncenter alignright alignjustify | formatselect | print ",
                          toolbar2: "cut copy paste pastetext | searchreplace | bullist numlist | outdent indent | undo redo | link unlink anchor code",
                        branding: false,
                        //toolbar_items_size: 'small',
                        paste_webkit_styles: "none",
                        images_upload_url: 'cms/uplaodImages',
                        images_upload_base_path: '<?= base_url(); ?>',
                        images_upload_handler: function (blobInfo, success, failure) {
                            var xhr, formData;
                          
                            xhr = new XMLHttpRequest();
                            xhr.withCredentials = false;
                            xhr.open('POST', 'cms/uplaodImages');
                          
                            xhr.onload = function() {
                                var json;
                            
                                if (xhr.status != 200) {
                                    failure('HTTP Error: ' + xhr.status);
                                    return;
                                }
                            
                                json = JSON.parse(xhr.responseText);
                            
                                if (!json || typeof json.location != 'string') {
                                    failure('Invalid JSON: ' + xhr.responseText);
                                    return;
                                }
                                console.log(blobInfo);
                                success(json.location);
                            };
                          
                            formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());
                          
                            xhr.send(formData);
                        },
                });
</script>

<script>
 

    /*$(".btn_save").click(function() {
             tinymce.triggerSave();
             var status;
             status = $("[name='cms']").valid(); //Validate again
             if(status==true) { 
                console.log('valid');
             }
             else { 
                console.log('not valid');
             }
    });*/

    $(document).on('click', '.btn_save', function(event) {
        event.preventDefault();
            var btn = $(".btn_save");
            var frm = $("[name='cms']");
            var key = $("[name='key']").val();
            var value = tinymce.activeEditor.getContent();
            if(!value) {
                alert('Enter <?= $page_title ?> content');
                return false;
            }
            btn.html("Saving...").attr("disabled", true);
            $.ajax({
                url: "cms/update_page",
                type: "post",
                //data: frm.serialize(),
                data: {key: key, value: value},
                success: function (resp) {
                    $(".resp_cms").html("<?= $page_title ?> updated.");
                    btn.html("Save").attr("disabled", false);
                }
            });
        return false;
    });
            

    $(document).ready(function () {
       
        /*$(document).on("click", ".btn_save", function () {
            $(".resp_cms").html("");
            $("[name='cms']").submit();
        })*/
    });

  
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.main-footer').removeClass('fixed-footer');
    });
</script>