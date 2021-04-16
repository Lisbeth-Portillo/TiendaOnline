<?php

function getSlider()
{
    global $con;
    //Obtencion de las imgs del slider
    $get_slides = "SELECT * FROM slider LIMIT 5";
    $run_slides = mysqli_query($con, $get_slides);
    while ($row_slides = mysqli_fetch_array($run_slides)) {

        $slide_name = $row_slides['slide_name'];
        $slide_title = $row_slides['slide_title'];
        $slide_subtitle = $row_slides['slide_subtitle'];
        $slide_image = $row_slides['slide_image'];

        echo "
            <div class='slide'>
                <!-- lazyload -->
                <div class='blur-up lazyload bg-size'>
                    <!-- Img slider -->
                    <img class='blur-up lazyload bg-img' data-src='images/slider/$slide_image' src='images/slider/$slide_image' title='$slide_name' />
                    <!-- /Img slider -->
                    <div class='slideshow__text-wrap slideshow__overlay classic bottom'>
                        <!-- Slider contenido -->
                        <div class='slideshow__text-content bottom'>
                            <div class='wrap-caption center'>
                                <!--Titulo -->
                                <h2 class='h1 mega-title slideshow__title'>$slide_title</h2>
                                <!-- Subtitulo -->
                                <span class='mega-subtitle slideshow__subtitle'>$slide_subtitle</span>
                            </div>
                        </div>
                        <!-- /Slider contenido -->
                    </div>
                </div>
                <!-- /lazyload -->
            </div>
                ";
    }
}
