require(
    [
     'openOrchestraCss',
     '/bundles/openorchestradisplay/libs/jquery-2.0.2.min.js',
     '/bundles/openorchestramedia/libs/fancybox/source/jquery.fancybox.pack.js',
     '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-buttons.js',
     '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-media.js',
     '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-thumbs.js'
    ],

    function (openOrchestraCss) {
        openOrchestraCss.load([
            '/bundles/openorchestramedia/libs/fancybox/source/jquery.fancybox.css?v=2.1.5',
            '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5',
            '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7',
            '/bundles/openorchestramedia/block/Gallery/css/style.css'
        ]);

        function resizeThumbnails(galId, nbCol) {
            if (galId == '') alert('Error : no id defined for gallery');
            var picturePadding = parseInt($(".gallery-picture").css("border-left-width")) + parseInt($(".gallery-picture").css("margin-left"));
            var galleryWidth = parseInt($("#" + galId).width());
            var pictureWidth = parseInt((galleryWidth / nbCol) - 2*picturePadding);

            $("#" + galId + " .gallery-picture").width(pictureWidth + 'px');
            $("#" + galId + " .gallery-picture").css("visibility", "visible");
        }

        $(document).ready(function() {
            for(var galleryId in orchestraGalCol) {
                resizeThumbnails(galleryId, orchestraGalCol[galleryId]);
            }

            $(".fancybox-thumb").fancybox({
                prevEffect  : 'none',
                nextEffect  : 'none',
                closeBtn    : false,
                helpers     : {
                    title     : {
                        type    : 'inside'
                    },
                    thumbs    : {
                        width   : 50,
                        height  : 50
                    }
                }
            });
        });

    }
);
