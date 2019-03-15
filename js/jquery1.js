$(function(){
    $('.to_top').css({display: 'none'});

    var i = 0;
    var section_top = [];
    var fadeSpeed = 500;

    while (i< 4){
        section_top[i] = $(".fill_section").eq(i).offset().top;
        $(".fill_section").eq(i).css({opacity: '0'});
        i++;
    }
    var center_section = (section_top[1] - section_top[0]) / 2 ;
    $(".fill_section").eq(0).animate({opacity: '1'}, fadeSpeed);
    $('html, body').animate({scrollTop:section_top[0]},0,'swing')
    // トップに戻る
    $(document).on('click','.to_top',function(){
        $('html, body').animate({scrollTop: 0},fadeSpeed,'swing');
    });
    // スクロール時の各種コマンド
    $(window).scroll(function () {
        if ($('.to_top').is(':animated')){
        }else{
            if($(window).scrollTop() >= 100) {
                $('.to_top').animate( { opacity: 'show',}, { duration: fadeSpeed, easing: 'swing' } );
            } else {
                $('.to_top').animate( { opacity: 'hide',}, { duration: fadeSpeed, easing: 'swing' } );
            }
        }
        var i = 0;
        if ($(".fill_section").eq(3).css('opacity') == '0'){
            console.log(" 処理中");
            while(i< 4){
                if($(window).scrollTop() >= section_top[i] - 500 ){
                    $(".fill_section").eq(i).animate({opacity: '1'}, fadeSpeed);
                }
                i++;
            }
        }

    });
    if ($('html, body').is(':animated')){
        console.log("animate中");
    }else{
        setTimeout(function(){
            if ($(window).scrollTop() < center_section){
                $('html, body').animate({scrollTop:section_top[0]},fadeSpeed,'swing');
            }else if(center_section <= $(window).scrollTop() < (center_section * 3) ){
                $('html, body').animate({scrollTop:section_top[1]},fadeSpeed,'swing');
            }else if((center_section * 3) <= $(window).scrollTop() < (center_section * 5) ){
                $('html, body').animate({scrollTop:section_top[2]},fadeSpeed,'swing');
            }else{
                $('html, body').animate({scrollTop:section_top[3]},fadeSpeed,'swing');
            }
        },3000)
    }

    // 次のセレクションへ移動
    $(document).on('click','.nextsection',function(){
        var index = $(".nextsection").index(this) + 1 ;
        $('html, body').animate({scrollTop:section_top[index]},fadeSpeed,'swing')
    });
});