<?php
    $pagetitle = "セクション";
    require_once("./template/system_header.php"); ?>
    <div id="container">
        <section class="fill_section">
            <h4>今週のおすすめ</h4>
            <a href="javascript:void(0);" class="slideleft">Left</a>
            <a href="javascript:void(0);" class="slideright">Right</a>
            <div class="slideshow">
                <div class ="slide">1</div>
                <div class ="slide">2</div>
                <div class ="slide">3</div>
            </div>
            <div class="slideball">
                <div class ="ball"></div>
                <div class ="ball"></div>
                <div class ="ball"></div>
            </div>
            <a href="javascript:void(0);" class="nextsection">next</a>
        </section>
        <section class="fill_section">
            二番目
            <a href="javascript:void(0);" class="nextsection">next</a>
        </section>
        <section class="fill_section">
            三番目
            <a href="javascript:void(0);" class="nextsection">next</a>
        </section>
        <section class="fill_section">
            四番目
        </section>
    </div>
    <a href="javascript:void(0);" class="to_down">down</a>
    <a href="javascript:void(0);" class="to_top">top</a>


<?php require_once("./template/system_footer.php"); ?>