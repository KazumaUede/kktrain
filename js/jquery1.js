$(function(){
    $('.to_top').css({display: 'none'});

    var i = 0;
    var section_top = [];
    var fadeSpeed = 500;
    var _scrollEvent;
    var _scrollEvent2;

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

    //スライドショー
    //（１）ページの概念・初期ページを設定
    var page =0;
    //（２）イメージの数を最後のページ数として変数化
    var lastPage =parseInt($(".slideshow .slide").length-1);
    //（３）全部のイメージを一旦非表示
    $(".slideshow .slide").css("display","none");
    //（４）初期ページを表示
    $(".slideshow .slide").eq(page).css("display","block");
    // （５）ページ切換用、自作関数作成
    function SlaidRight(){
        if( page === 0){
            SlaidRight_Set(lastPage,page);
        }else{
            cpage = page -1;
            SlaidRight_Set(cpage,page);
        }
    };
    function SlaidRight_Set(lp,np){
        $(".slideshow .slide").eq(lp).css({"z-index":10});
        $(".slideshow .slide").eq(np).css({"z-index":5}).show();
        $(".slideshow .slide").eq(lp).animate( { width: 'hide'},1000 );
    }
    function SlaidLeft_Set(lp,np){
        $(".slideshow .slide").eq(lp).css({"z-index":5});
        $(".slideshow .slide").eq(np).css({"z-index":10}).animate( { width: 'show'},1000 );
        $(".slideshow .slide").eq(lp).css("display","none");
    }


    $(document).on('click','.slideright',function(){
        stopTimer;
        startTimer;
        if(page === lastPage){
            page = 0;
            SlaidRight();
        }else{
            page ++;
            SlaidRight();
        };
    });





    //（６）～秒間隔でイメージ切換の発火設定
    var Timer;
    function startTimer(){
        Timer =setInterval(function(){
            if(page === lastPage){
                page =0;
                SlaidRight();
            }else{
                page++;
                SlaidRight();
            };
        },5000
        );
    }
    //（７）～秒間隔でイメージ切換の停止設定
    function stopTimer(){
        clearInterval(Timer);
    }
    startTimer();










});