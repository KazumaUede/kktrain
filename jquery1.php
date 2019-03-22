<?php
    $pagetitle = "セクション";
    require_once("./template/system_header.php"); ?>
    <div id="container">
        <section class="fill_section">
            <h4>今週のおすすめ</h4>
            <a href="javascript:void(0);" class="slideleft">Left</a>
            <a href="javascript:void(0);" class="slideright">Right</a>
            <div class="slider">
                <div class="slideSet">
                    <div class ="slide" id="page1"></div>
                    <div class ="slide" id="page2"></div>
                    <div class ="slide" id="page3"></div>
                    <div class ="slide" id="page4"></div>
                    <div class ="slide" id="page5"></div>
                </div>
            </div>
            <div class="slideball">
                <div class ="ball"></div>
                <div class ="ball"></div>
                <div class ="ball"></div>
                <div class ="ball"></div>
                <div class ="ball"></div>
            </div>
            <a href="javascript:void(0);" class="nextsection">next</a>
        </section>
        <section class="fill_section">
                <a href="javascript:void(0);" class="bannerleft">Left</a>
                <div class="banners">
                    <div class="bannerSet">
                        <div class ="banner" id="banner1">バナー1</div>
                        <div class ="banner" id="banner2">バナー2</div>
                        <div class ="banner" id="banner3">バナー3</div>
                        <div class ="banner" id="banner4">バナー4</div>
                        <div class ="banner" id="banner5">バナー5</div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="bannerright">Right</a>
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