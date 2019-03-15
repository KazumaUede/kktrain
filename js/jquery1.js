$(function(){
    $('.to_top').hide();
    var i = 1;
    var section_top = [];

    while (i< 4){
        section_top[i] = $(".fill_section").eq(i).offset().top;
        $(".fill_section").eq(i).animate({ height: 'hide'});
        i++;
    }
    // トップに戻る
    $(document).on('click','.to_top',function(){
        $('html, body').animate({scrollTop: 0},500,'swing');
    });
    // トップボタンを表示、非表示
    $(window).scroll(function () {
        if($(window).scrollTop() >= 200) {
            $('.to_top').animate({ width: 'show'}, 'fast' );
        } else {
            $('.to_top').animate({ width: 'hide'}, 'fast' );
        }
        var i = 1;
        while(i< 4){
            if($(window).scrollTop() >= section_top[i] - 500 ){
                $(".fill_section").eq(i).animate({ height: 'show'}, 'fast' );
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