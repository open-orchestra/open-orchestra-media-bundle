requirejs(
    ['jquery'],
    function() {
        requirejs(
            [
                'openOrchestraCss',
                '/bundles/openorchestramedia/libs/jssor/jssor.slider.mini.js',
                '/bundles/openorchestramedia/libs/jssor/jssor.js'
            ],
            function (openOrchestraCss) {
                openOrchestraCss.load(['/bundles/openorchestramedia/block/Gallery/css/style.css']);
                jQuery(document).ready(function ($) {
                    var options = {
                        $AutoPlay: false,
                        $ArrowKeyNavigation: true,
                        $ArrowNavigatorOptions: {
                            $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                            $ChanceToShow: 1               //[Required] 0 Never, 1 Mouse Over, 2 Always
                        },
                        $ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
                            $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                            $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                            $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                            $Lanes: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1
                            $SpacingX: 5,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                            $SpacingY: 10,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                            $DisplayPieces: 10,                             //[Optional] Number of pieces to display, default value is 1
                            $ParkingPosition: 5,                          //[Optional] The offset position to park thumbnail
                            $Orientation: 1                                //[Optional] Orientation to arrange thumbnails, 1 horizontal, 2 vertical, default value is 1
                        }
                    };
                    function ScaleSlider(jssor_slider) {
                        var parentWidth = jssor_slider.$Elmt.parentNode.clientWidth;
                        if (parentWidth)
                            jssor_slider.$ScaleWidth(Math.max(Math.min(parentWidth, 960), 300));
                        else
                            window.setTimeout(ScaleSlider, 30);
                    }
                    $.each($(".jssor-gallery-container "), function (gallery) {
                        $(this).css("display", "block");
                        var jssor_slider = new $JssorSlider$($(this).attr("id"), options);
                        ScaleSlider(jssor_slider);
                        $(window).bind("load", ScaleSlider);
                        $(window).bind("resize", ScaleSlider);
                        $(window).bind("orientationchange", ScaleSlider);
                    });
                });
            }
        )
    }
);
