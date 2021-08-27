(function($) {
    'use strict';
    $(function() {
        $('.file-upload-browse').on('click', function() {
        var file = $(this).parent().parent().find('.file-upload-default');
        file.trigger('click');
        });
        $('.file-upload-default').on('change', function() {
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });

        $(document).on('click', '.js-close-image-preview', function (e) {
            e.preventDefault();
            let previewElement = document.querySelector('span.file-upload-browse');
            let thumbnail = previewElement.dataset.thumbnail;
            previewElement.style.background = "url("+ thumbnail+")";
            this.remove();
            document.getElementById("featured_image").value = "";
        });

        function handleFileSelect(evt) {
            var files = evt.target.files; // FileList object

            // Loop through the FileList and render image files as thumbnails.
            for (var i = 0, f; f = files[i]; i++) {

                // Only process image files.
                if (!f.type.match('image.*')) {
                    continue;
                }

                var reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function(theFile) {
                    console.log(theFile)
                    return function(e) {
                        let previewElement = document.querySelector('span.file-upload-browse');
                        previewElement.style.background = "url("+ e.target.result +")";
                        let closeElement = document.createElement('label'), icon = document.createElement('i');
                        icon.className = "mdi mdi-close-box";
                        closeElement.className = 'js-close-image-preview';
                        closeElement.append(icon);
                        previewElement.parentNode.append(closeElement);
                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
        }

        document.getElementById('featured_image').addEventListener('change', handleFileSelect, false);

        $(document).on("click", ".js-close-image-preview-2", function() {
            totalFile--;
            formDataDelete($(this).parents("div.input-group").index());
            $(this).parents("div.input-group").remove();
        });
    
        $('#openFileUploadButton').click(function(){ $('#fileUpload').trigger('click'); });
        document.getElementById('fileUpload').addEventListener('change', handleFileUploadSelect, false);
    
        function handleFileUploadSelect(evt) {
            var files = evt.target.files; // FileList object
            let _token   = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            let TotalFiles = files.length; //Total files
            for (let i = 0; i < TotalFiles; i++) {
                formData.append('filesUpload[]', files[i]);
            }
    
            $.ajax({
                url: "/administrator/upload-image",
                type:"POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                dataType: 'json',
                contentType: false,
                processData: false,
                success:function(images){
                    $.each(images, function (index, image) {
                        let htmlAppend = '';
                        htmlAppend += `<li class="pb-3">
                                    <i class="mdi mdi-close-box js-close-product-image"></i>
                                    <input type="text" name="ProductImages[]" value="${image.id}" style="display:none" />
                                    <img src="${image.url}" />
                                </li>`
                        $(htmlAppend).insertBefore( "#itemUpload" );
                        $( "#sortable-images" ).sortable();
                        $( "#sortable-images" ).disableSelection();
                    })
                },
            });
        }

        $(document).on('click', '.js-close-product-image', function (e) {
            e.preventDefault();
            $(this).parent().remove();
        });
    });
})(jQuery);
