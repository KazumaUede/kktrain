$(function(){
    $('.to_top').css({display: 'none'});

    var i = 0;
    var section_top = [];
    var fadeSpeed = 500;
    var _scrollEvent;
    var _scrollEvent2;
    var ballid = 0;
    $(".slideball .ball").eq(0).css({"cssText" : "background-color : red !important"});
    while (i< 4){
        section_top[i] = $(".fill_section").eq(i).offset().top;
        $(".fill_section").eq(i).css({opacity: '0'});
        i++;
    }
    var center_section = (section_top[1] - section_top[0]) / 2 ;
    $(".fill_section").eq(0).animate({opacity: '1'}, fadeSpeed);
    $('html, body').animate({scrollTop: 0},0,'swing');
    // トップに戻る
    $(document).on('click','.to_top',function(){
        $('html, body').animate({scrollTop: 0},fadeSpeed,'swing');
    });
    // スクロール時の各種コマンド
    $(window).scroll(function () {

        if(!_scrollEvent){
            _scrollEvent = setTimeout(function(){
                _scrollEvent = null;
                if($(window).scrollTop() >= 100) {
                    $('.to_top').stop().animate( { opacity: 'show',}, { duration: fadeSpeed, easing: 'swing' } );
                } else {
                    $('.to_top').stop().animate( { opacity: 'hide',}, { duration: fadeSpeed, easing: 'swing' } );
                }
                var i = 0;
                if ($(".fill_section").eq(3).css('opacity') == '0'){
                    while(i< 4){
                        if($(window).scrollTop() >= section_top[i] - 500 ){
                            $(".fill_section").eq(i).animate({opacity: '1'}, fadeSpeed);
                        }
                        i++;
                    }
                }
            }, 200);
        }
        if(!_scrollEvent2){
            _scrollEvent2 = setTimeout(function(){
                _scrollEvent2 = null;
                switch (true) {
                    case $(window).scrollTop() < center_section:
                        $('html, body').animate({scrollTop: 0},fadeSpeed,'swing');
                        break;
                    case $(window).scrollTop() < center_section * 3:
                        pageto(1);
                        break;
                    case $(window).scrollTop() < center_section * 5:
                        pageto(2);
                        break;
                    default:
                        pageto(3);
                }
            },3000);
        }
    });
    function pageto(n) {
        $('html, body').stop().animate({scrollTop:section_top[n]},fadeSpeed,'swing');
    }
    // 次のセレクションへ移動
    $(document).on('click','.nextsection',function(){
        var index = $(".nextsection").index(this) + 1 ;
        $('html, body').stop().animate({scrollTop:section_top[index]},fadeSpeed,'swing')
    });

    //スライダー
    //1.スライドの長さを測る
    var slideWidth = $('.slide').outerWidth();
    var slideNum = $('.slide').length;
    var slideSetWidth = slideWidth * slideNum;
    //2.並べる
    $('.slideSet').css('width', slideSetWidth);
    var click_flg = true;


    // 前へボタンが押されたとき
    $('.slideleft').click(function(){
        if(click_flg){
            buttonaction(slideleft(2),500);
        }else {
            return false;
        }
    });
    // 次へボタンが押されたとき
    $('.slideright').click(function(){
        if(click_flg){
            buttonaction(slideright(1),500);
        }else {
            return false;
        }
    });

    function getid(actionFuction,time){
        click_flg = false;
        //実行内容
        actionFuction
        setTimeout(function(){
            click_flg = true;
        },time)
    }


    function buttonaction(){
        click_flg = false;
        //実行内容
        actionFuction
        setTimeout(function(){
            click_flg = true;
        },time)
    }

    $(document).on('click','.ball',function(){
        var nextslide = $(".ball").index(this);
        if (lastslide < nextslide){
            i = nextslide - lastslide;
            slideright(i);
        }else if(lastslide > nextslide) {
            i = lastslide - nextslide
            slideleft(i);
        }

    })
    // 右スライド
    function slideright(count){
            //li先頭要素のクローンを作成
        for (var i = 0; count > i; i++){
            $(".slide").eq(i).clone(true).insertAfter($(".slide:last"));
        }
            var slidewidth = (-800 * count)+ 'px';
        $(".slideSet .slide:first").animate({
            marginLeft : slidewidth
        }, {
            duration : 500,
            complete : function() {
                for (var i = 0; count > i; i++){
                    $(".slide:first").remove();
                }
            }
        });
    }
    // 左スライド
    function slideleft(count){
        var slidewidth = (800 * count)+ 'px';
        for (var i = 0; count > i; i++){
            $.when(
                $(".slide:last").eq(i).clone(true).insertBefore($(".slide:first"))
            ).done(function(){
                $(".slide:last").remove()
            });
        }
        $.when(
            $(".slideSet .slide:first").animate({
                marginLeft : "-" + slidewidth
            },0)
        ).done(function(){
            $(".slideSet .slide:first").animate({
                marginLeft : "0"
            },500);
        });
    }
});