$(function(){
    $('.to_top').css({display: 'none'});
    var i = 1;
    var section_top = [];
    var fadeSpeed = 500;

    while (i< 4){
        section_top[i] = $(".fill_section").eq(i).offset().top;
        $(".fill_section").eq(i).css({opacity: '0'});
        i++;
    }
    // トップに戻る
    $(document).on('click','.to_top',function(){
        $('html, body').animate({scrollTop: 0},500,'swing');
    });
    // スクロール時の各種コマンド
    $(window).scroll(function () {
        if($(window).scrollTop() >= 100) {
            $('.to_top').animate( { opacity: 'show',}, { duration: fadeSpeed, easing: 'swing' } );
        } else {
            $('.to_top').animate( { opacity: 'hide',}, { duration: fadeSpeed, easing: 'swing' } );
        }
        var i = 1;
        while(i< 4){
            if($(window).scrollTop() >= section_top[i] - 500 ){
                $(".fill_section").eq(i).animate({opacity: '1'}, fadeSpeed);
            }
            i++;
        }
    });
    // 次のセレクションへ移動
    $(document).on('click','.nextsection',function(){
        var index = $(".nextsection").index(this) + 1 ;
        $('html, body').animate({scrollTop:$(".fill_section").eq(index).offset().top},500,'swing')
    });
});