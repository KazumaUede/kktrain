<?php
    $pagetitle = "セクション";
    require_once("./template/system_header.php"); ?>
    <div id="container">
        <section class="fill_section">
            一番目
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