/*
 * Resize thumbnails to fit the column number
 */
function resizeThumbnails(galId, nbCol) {
    if (galId == '') alert('Error : no id defined for gallery');
    var picturePadding = parseInt($(".gallery-picture").css("border-left-width")) + parseInt($(".gallery-picture").css("margin-left"));
    var galleryWidth = parseInt($("#" + galId).width());
    var pictureWidth = parseInt((galleryWidth / nbCol) - 2*picturePadding);

    $("#" + galId + " .gallery-picture").width(pictureWidth + 'px');
    $("#" + galId + " .gallery-picture").css("visibility", "visible");
}

/*
 * Init galleries
 */
function initGalleries(openOrchestraCss) {
    openOrchestraCss.load(
        [
         '/bundles/openorchestramedia/libs/fancybox/source/jquery.fancybox.css?v=2.1.5',
         '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5',
         '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7',
         '/bundles/openorchestramedia/block/Gallery/css/style.css'
        ]
    );

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
}

/*
 * Chain requirements to init galleries
 */
require(
    ['jquery'],

    function() {
        require(
            ['/bundles/openorchestramedia/libs/fancybox/source/jquery.fancybox.pack.js'],

            function() {
                require(
                    [
                     'openOrchestraCss',
                     '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-buttons.js',
                     '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-media.js',
                     '/bundles/openorchestramedia/libs/fancybox/source/helpers/jquery.fancybox-thumbs.js'
                    ],

                    function (openOrchestraCss) {
                        initGalleries(openOrchestraCss);
                    }

                );
            }

        );
    }

);
